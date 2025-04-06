<?php

namespace App\Http\Controllers;

use App\Client;
use App\Sale;
use App\Product;
use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\PaymentMethod;
use Illuminate\Http\Request;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\EscposImage;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {

        Carbon::setLocale('PT-BR');
     }

    public function index()
    {
        $sales = Sale::latest()->with('transactions')->paginate(25);

        return view('sales.index', compact('sales'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();

        return view('sales.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sale $model)
    {
        $existent = Sale::where('client_id', $request->get('client_id'))->where('finalized_at', null)->get();

        if($existent->count()) {
            return back()->withError('Já existe uma venda inacabada pertencente a esta mesa . <a href="'.route('sales.show', $existent->first()).'">Clique aqui para ir a ele</a>');
        }

        $sale = $model->create($request->all());

        return redirect()
            ->route('sales.show', ['sale' => $sale->id])
            ->withStatus('Venda registrada com sucesso, você pode começar a registrar produtos e transações.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('sales.show', ['sale' => $sale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->withStatus('O registro de venda foi excluído com sucesso.');
    }

    public function finalize(Sale $sale)
    {
        $sale->total_amount = $sale->products->sum('total_amount');



        if($sale->total_amount ==0){
            return back()->withError("Fatura sem produtos !");
        }


        foreach ($sale->products as  $sold_product) {
            $product_name = $sold_product->product->name;
            $sold_product['name'] = $product_name;

            $product_stock = $sold_product->product->stock;

            if($sold_product->qty > $product_stock) return back()->withError("O produto '$product_name' não tem stock suficiente , no stock de   $product_stock unidades.");
        }

        foreach ($sale->products as $sold_product) {



            $sold_product->product->stock -= $sold_product->qty;
            $sold_product->product->save();
        }

        $sale->finalized_at = Carbon::now()->toDateTimeString();
        $sale->client->balance -= $sale->total_amount;

        $sale->save();
        $sale->client->save();


        $ivaAmount =   $sale->total_amount;
        // $ivaAmount =  $sale->total_amount*0.16 + $sale->total_amount;


        if($this->printCommand($sale)){

            Transaction::create(['title'=>'caixa', 'reference'=>Carbon::now(), 'amount'=> $ivaAmount, 'payment_method_id'=>1, 'type', 'client_id'=>$sale->client->id, 'user_id'=>Auth::user()->id, 'sale_id'=>$sale->id,'type'=>'income']);
        }else{
            return back()->withError("Falha na impressora !");
        }
        // $this->printTest();

        return back()->withStatus('Venda efectuada com sucesso !');
    }

    public function addproduct(Sale $sale)
    {
        $products = Product::all();

        return view('sales.addproduct', compact('sale', 'products'));
    }

    public function storeproduct(Request $request, Sale $sale, SoldProduct $soldProduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldProduct->create($request->all());

        return redirect()
            ->route('sales.show', ['sale' => $sale])
            ->withStatus('Product successfully registered.');
    }

    public function editproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $products = Product::all();

        return view('sales.editproduct', compact('sale', 'soldproduct', 'products'));
    }

    public function updateproduct(Request $request, Sale $sale, SoldProduct $soldproduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldproduct->update($request->all());

        return redirect()->route('sales.show', $sale)->withStatus('Product successfully modified.');
    }

    public function destroyproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $soldproduct->delete();

        return back()->withStatus('The product has been disposed of successfully.');
    }

    public function addtransaction(Sale $sale)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.addtransaction', compact('sale', 'payment_methods'));
    }

    public function storetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch($request->all()['type']) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: ' . $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: ' . $request->all('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1) ]);
                }
                break;
        }

        $transaction->create($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully registered transaction.');
    }

    public function edittransaction(Sale $sale, Transaction $transaction)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.edittransaction', compact('sale', 'transaction', 'payment_methods'));
    }

    public function updatetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch($request->get('type')) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: '. $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: '. $request->get('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }
        $transaction->update($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully modified transaction.');
    }

    public function destroytransaction(Sale $sale, Transaction $transaction)
    {
        $transaction->delete();

        return back()->withStatus('Transação excluída com sucesso.');
    }




    public function printCommand($mealList)
    {
        $items =array();
        // Set params
        $mid = $mealList->client->name ;
        $store_name = "Bululu's Bar & Lounge Lda";
        $store_address = 'Rua da Mozal';
        $store_phone = '842278856';
        $store_email = '';
        $store_website = '';
        $tax_percentage = 16;
        $transaction_id = $mealList->id;
        $currency=" MT ";


        // Set items

        foreach ($mealList->products as $meal){

            $aux = array('name'=>$meal->name,'price'=>$meal->price,'qty'=>$meal->qty);
            array_push($items,$aux);

        }



        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Add items
        foreach ($items as $item) {

            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }
        // Set tax
        $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        $printer->setCurrency($currency);



        // Set qr code
        $printer->setQRcode([
            "phone"=> $store_phone,
        ]);



        // Print receipt
       $printer->printReceipt();

       return true ;



    }


    public function printTest(){



// Set params
$mid = '123123456';
$store_name = 'YOURMART';
$store_address = 'Mart Address';
$store_phone = '1234567890';
$store_email = 'yourmart@email.com';
$store_website = 'yourmart.com';
$tax_percentage = 10;
$transaction_id = 'TX123ABC456';
$currency = 'Rp';

// Set items
$items = [
    [
        'name' => 'French Fries (tera)',
        'qty' => 2,
        'price' => 65000,
    ],
    [
        'name' => 'Roasted Milk Tea (large)',
        'qty' => 1,
        'price' => 24000,
    ],
    [
        'name' => 'Honey Lime (large)',
        'qty' => 3,
        'price' => 10000,
    ],
    [
        'name' => 'Jasmine Tea (grande)',
        'qty' => 3,
        'price' => 8000,
    ],
];

// Init printer
$printer = new ReceiptPrinter;
$printer->init(
    config('receiptprinter.connector_type'),
    config('receiptprinter.connector_descriptor')
);



// Set store info
$printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

// Set currency
$printer->setCurrency($currency);

// Add items
foreach ($items as $item) {
    $printer->addItem(
        $item['name'],
        $item['qty'],
        $item['price']
    );
}
// Set tax
$printer->setTax($tax_percentage);

// Calculate total
$printer->calculateSubTotal();
$printer->calculateGrandTotal();

// Set transaction ID
$printer->setTransactionID($transaction_id);

// Set qr code
$printer->setQRcode([
    'tid' => $transaction_id,
]);

// Print receipt
$printer->printReceipt();



    }


}

@extends('layouts.app', ['page' => 'Category Information', 'pageSlug' => 'categories', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informações da categoria</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>produtos</th>
                            <th>Stocks</th>
                            <th>Stocks mínimo</th>
                            <th>Preço médio</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->products->count() }}</td>
                                <td>{{ $category->products->sum('stock') }}</td>
                                <td>{{ $category->products->sum('stock_defective') }}</td>
                                <td>{{ round($category->products->avg('price'), 2) }} MT</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">products: {{ $products->count() }}</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Estoque</th>
                            <th> Stockc com defeito</th>
                            <th>Preço base</th>
                            <th>Preço médio</th>
                            <th>Vendas totais</th>
                            <th>Renda produzida</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><a href="{{ route('products.show', $product) }}">{{ $product->id }}</a></td>
                                    <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->stock_defective }}</td>
                                    <td>@money($product->price) </td>
                                    <td>@money($product->solds->avg('price')) </td>
                                    <td>{{ $product->solds->sum('qty') }}</td>
                                    <td>@money($product->solds->sum('total_amount')) </td>
                                    <td class="td-actions text-right">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end">
                        {{ $products->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

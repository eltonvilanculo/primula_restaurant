@extends('layouts.app', ['page' => 'Manage Sale', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
    @include('alerts.success')
    @include('alerts.error')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Resumo da venda</h4>
                        </div>
                        @if (!$sale->finalized_at)
                            <div class="col-4 text-right">
                                @if ($sale->products->count() == 0)
                                    <form action="{{ route('sales.destroy', $sale) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-primary">
                                           Excluir venda
                                        </button>
                                    </form>
                                @else
                                <button type="button" class="btn btn-sm btn-primary" onclick="confirm('Atenção: As transações desta venda não parecem coincidir com o custo dos produtos, você quer finalizá-lo?Seus registros não podem ser modificados a partir de agora.') ? window.location.replace('{{ route('sales.finalize', $sale) }}') : ''">
                                   Finalize a venda
                                </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Do utilizador</th>
                            <th>Cliente</th>
                            <th>produtos</th>
                            <th>Total de estoque</th>
                            <th>Custo total</th>
                            <th>status</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ date('d-m-y', strtotime($sale->created_at)) }}</td>
                                <td>{{ $sale->user->name }}</td>
                                <td><a href="{{ route('clients.show', $sale->client) }}">{{ $sale->client->name }}<br>{{ $sale->client->document_type }}-{{ $sale->client->document_id }}</a></td>
                                <td>{{ $sale->products->count() }}</td>
                                <td>{{ $sale->products->sum('qty') }}</td>
                                <td>@money($sale->products->sum('total_amount')) </td>
                                <td>{!! $sale->finalized_at ? 'Completado em.<br>'.date('d-m-y', strtotime($sale->finalized_at)) : (($sale->products->count() > 0) ? 'POR FINALIZAR' : 'EM ESPERA') !!}</td>
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
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Total de produtos vendidos: {{ $sale->products->sum('qty') }}</h4>
                        </div>
                        @if (!$sale->finalized_at)
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.product.add', ['sale' => $sale->id]) }}" class="btn btn-sm btn-primary">Adicionar</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Categoria</th>
                            <th>produtos</th>
                            <th>Quantidade</th>
                            <th>Preço C/U</th>
                            <th>total</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($sale->products as $sold_product)
                                <tr>
                                    <td>{{ $sold_product->product->id }}</td>
                                    <td><a href="{{ route('categories.show', $sold_product->product->category) }}">{{ $sold_product->product->category->name }}</a></td>
                                    <td><a href="{{ route('products.show', $sold_product->product) }}">{{ $sold_product->product->name }}</a></td>
                                    <td>{{ $sold_product->qty }}</td>
                                    <td>@money($sold_product->price) </td>
                                    <td>@money($sold_product->total_amount) </td>
                                    <td class="td-actions text-right">
                                        @if(!$sale->finalized_at)
                                            <a href="{{ route('sales.product.edit', ['sale' => $sale, 'soldproduct' => $sold_product]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Pedido">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('sales.product.destroy', ['sale' => $sale, 'soldproduct' => $sold_product]) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Pedido" onclick="confirm('Estás seguro que quieres eliminar este pedido de producto/s? Su registro será eliminado de esta venta.') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets') }}/js/sweetalerts2.js"></script>
@endpush

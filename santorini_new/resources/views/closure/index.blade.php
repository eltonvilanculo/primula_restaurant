@extends('layouts.app', ['page' => 'List of closures', 'pageSlug' => 'Fechamento', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Fechamentos</h4>
                        </div>
{{--                        <div class="col-4 text-right">--}}
{{--                            <a href="{{ route('closures.create') }}" class="btn btn-sm btn-primary">Novo produto</a>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                            <th scope="col">Valor</th>
                            <th scope="col">Data</th>
                            <th scope="col"></th>
                            </thead>
                            <tbody>
                            @foreach ($closures as $closure)
                                <tr>
{{--                                    <td><a href="{{ route('closure.show')}}">Aa</a></td>--}}
                                    <td>@money($closure->value+0.17*$closure->value)</td>
                                    <td>{{ $closure->created_at }}</td>
                                    <td class="td-actions text-right">
{{--                                        <a href="{{ route('closure.show', $closure) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Mais detalhes">--}}
{{--                                            <i class="tim-icons icon-zoom-split"></i>--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ route('closure.edit', $closure) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Editar produto">--}}
{{--                                            <i class="tim-icons icon-pencil"></i>--}}
{{--                                        </a>--}}
{{--                                        <form action="{{ route('closure.destroy', $closure) }}" method="post" class="d-inline">--}}
{{--                                            @csrf--}}
{{--                                            @method('delete')--}}
{{--                                            <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Excluir produto" onclick="confirm('Tem certeza de que quer remover este produto?Os registros que contêm continuarão a existir.') ? this.parentElement.submit() : ''">--}}
{{--                                                <i class="tim-icons icon-simple-remove"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end">
                        {{ $closures->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

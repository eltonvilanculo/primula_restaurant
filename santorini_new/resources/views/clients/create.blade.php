@extends('layouts.app', ['page' => 'Register Client', 'pageSlug' => 'clients', 'section' => 'clients'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Registrar Mesa</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('clients.index') }}" class="btn btn-sm btn-primary">De volta à lista</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('clients.store') }}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">Informações da mesa.</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Nome</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Nome" value="{{ old('name') }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="row">
{{--                                    <div class="col-1">--}}
{{--                                        <label class="form-control-label" for="input-document_type">Modelo</label>--}}
{{--                                        <select name="document_type" id="input-document_type" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" required>--}}
{{--                                            @foreach (['VIP', 'E', 'P', 'RIF'] as $document_type)--}}
{{--                                                @if($document_type == old('document_type'))--}}
{{--                                                    <option value="{{$document_type}}" selected>{{$document_type}}</option>--}}
{{--                                                @else--}}
{{--                                                    <option value="{{$document_type}}">{{$document_type}}</option>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <div class="col">
                                        <label class="form-control-label" for="input-document_id">Capacidade da mesa</label>
                                        <input type="number" name="document_id" id="input-document_id" class="form-control form-control-alternative{{ $errors->has('document_id') ? ' is-invalid' : '' }}" placeholder="Número de cadeiras" value="{{ old('document_id') }}" required>
                                        @include('alerts.feedback', ['field' => 'document_id'])

                                    </div>
                                </div>
{{--                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">--}}
{{--                                    <label class="form-control-label" for="input-email" hidden>O email</label>--}}
{{--                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="O email" value="{{ old('email') }}" required>--}}
{{--                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="O email" value="milton@mk.com" required hidden>--}}
{{--                                    @include('alerts.feedback', ['field' => 'email'])--}}
{{--                                </div>--}}
{{--                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">--}}
{{--                                    <label class="form-control-label" for="input-phone" hidden>Telefone</label>--}}
{{--                                    <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Telephone" value="869736169" required hidden>--}}
{{--                                    <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Telephone" value="{{ old('phone') }}" required>--}}
{{--                                    @include('alerts.feedback', ['field' => 'phone'])--}}
{{--                                </div>--}}


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

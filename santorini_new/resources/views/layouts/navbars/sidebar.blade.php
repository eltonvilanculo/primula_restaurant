<div class="sidebar">
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>Painel de controle</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#transactions" {{ $section == 'transactions' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-bank" ></i>
                    <span class="nav-link-text">Sumatório</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $section == 'transactions' ? 'show' : '' }}" id="transactions">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'tstats') class="active " @endif>
                            <a href="{{ route('transactions.stats')  }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>Relatórios</p>
                            </a>
                        </li>
{{--                        <li @if ($pageSlug == 'transactions') class="disabled " @endif >--}}
{{--                            --}}{{--  <a href="{{ route('transactions.index')  }}"  class="disabled">  --}}
{{--                            <a href="#">--}}
{{--                                <i class="tim-icons icon-bullet-list-67"></i>--}}
{{--                                <p>Tudo</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li @if ($pageSlug == 'sales') class="active " @endif>
                            <a href="{{ route('sales.index')  }}">
                                <i class="tim-icons icon-bag-16"></i>
                                <p>Vendas</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'fechamento') class="active " @endif>
                            <a href="{{ route('transactions.type', ['type' => 'expense'])  }}">
                                <a href="/closure">
                                <i class="tim-icons icon-coins"></i>
                                <p>Fechamento</p>
                            </a>
                        </li>
{{--                        <li @if ($pageSlug == 'incomes') class="active " @endif>--}}
{{--                            --}}{{--  <a href="{{ route('transactions.type', ['type' => 'income'])  }}">  --}}
{{--                                <a href="#">--}}
{{--                                <i class="tim-icons icon-credit-card"></i>--}}
{{--                                <p>Entrada</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li @if ($pageSlug == 'transfers') class="active " @endif>--}}
{{--                            --}}{{--  <a href="{{ route('transfer.index')  }}">  --}}
{{--                                <a href="#">--}}
{{--                                <i class="tim-icons icon-send"></i>--}}
{{--                                <p>Transferências</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li @if ($pageSlug == 'payments') class="active " @endif>--}}
{{--                            --}}{{--  <a href="{{ route('transactions.type', ['type' => 'payment'])  }}">  --}}

{{--                                <a href="#">--}}
{{--                                <i class="tim-icons icon-money-coins"></i>--}}
{{--                                <p>Pagamentos</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#inventory" {{ $section == 'inventory' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-app"></i>
                    <span class="nav-link-text">Inventário</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $section == 'inventory' ? 'show' : '' }}" id="inventory">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'istats') class="active " @endif>
                            <a href="{{ route('inventory.stats') }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>Estatisticas</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'products') class="active " @endif>
                            <a href="{{ route('products.index') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Produtos</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'categories') class="active " @endif>
                            <a href="{{ route('categories.index') }}">
                                <i class="tim-icons icon-tag"></i>
                                <p>Categorias</p>
                            </a>
                        </li>
{{--                        <li @if ($pageSlug == 'receipts') class="active " @endif>--}}
{{--                            --}}{{--  <a href="{{ route('receipts.index') }}">  --}}
{{--                                <a href="#">--}}
{{--                                <i class="tim-icons icon-paper"></i>--}}
{{--                                <p>Recepientes</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </li>

            <li @if ($pageSlug == 'clients') class="active " @endif>
                <a href="{{ route('clients.index') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Mesas</p>
                </a>
            </li>

            {{--  <li @if ($pageSlug == 'providers') class="active " @endif>
                <a href="{{ route('providers.index') }}">
                    <i class="tim-icons icon-delivery-fast"></i>
                    <p>Fornecedores</p>
                </a>
            </li>  --}}

            {{--  <li @if ($pageSlug == 'methods') class="active " @endif>
                <a href="#">
                <a href="{{ route('methods.index') }}">
                    <i class="tim-icons icon-wallet-43"></i>
                    <p>Métodos e Contas</p>
                </a>
            </li>  --}}


            <!-- <li>
                <a data-toggle="collapse" href="#clients">
                    <i class="tim-icons icon-single-02" ></i>
                    <span class="nav-link-text">Clients</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="clients">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'clients-list') class="active " @endif>
                            <a href="{{ route('clients.index')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Administrar Clientes</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'clients-create') class="active " @endif>
                            <a href="{{ route('clients.create')  }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p>Novo cliente</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> -->


            <li>
                <a data-toggle="collapse" href="#users" {{ $section == 'users' ? 'aria-expanded=true' : '' }}>
                    <i class="tim-icons icon-badge" ></i>
                    <span class="nav-link-text">Utilizadores</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $section == 'users' ? 'aria-expanded=true' : '' }}" id="users">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'profile') class="active " @endif>
                            <a href="{{ route('profile.edit')  }}">
                                <i class="tim-icons icon-badge"></i>
                                <p>Meu perfil</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users-list') class="active " @endif>
                            <a href="{{ route('users.index')  }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>Gestão de utilizadores</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users-create') class="active " @endif>
                            <a href="{{ route('users.create')  }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p>Novo utilizador</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>

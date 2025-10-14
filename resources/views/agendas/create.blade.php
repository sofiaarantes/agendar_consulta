<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Criar Agenda</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo ms-3 ps-3">
                    <a href="{{ route('dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo AgendeFácil" width="40"></a>
                        </span>
                    <span class="app-brand-text demo menu-text fw-bolder text-capitalize">AgendeFácil</span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item">
                        <a href="{{ route('dashboard')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Página Inicial</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Agenda</span>
                    </li>
                    <li class="menu-item active">
                        <a href="{{ route('agendas.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            Editar Agendas
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Consultas</span>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('consultas.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            Ver Consultas
                        </a>
                    </li>
                    
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Sair</span>
                    </li>
                    <li class="menu-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="menu-link w-100 d-flex align-items-center" style="border: none; background: none; text-align: left; padding: 0.625rem 1rem; color: inherit;">
                                <i class="menu-icon tf-icons bx bx-power-off"></i>
                                <div data-i18n="Sair">Sair</div>
                            </button>
                        </form>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

        <div class="layout-page">
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Criar Agenda Mensal</h4>

                    {{-- Mensagem de sucesso --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Mensagem de erro --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Defina os horários recorrentes</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('agendas.store') }}" method="POST">
                                @csrf

                                {{-- Médico --}}
                                <input type="hidden" name="medico_id" value="{{ Auth::user()->medico->id ?? '' }}">

                                {{-- Dias da semana --}}
                                <div class="mb-3">
                                    <label class="form-label">Dias da Semana</label>
                                    <div class="row">
                                        @foreach(['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado']  as $dia)
                                            <div class="col-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                        name="dias_semana[]" 
                                                        value="{{ $dia }}" 
                                                        id="{{ $dia }}">
                                                    <label class="form-check-label" for="{{ $dia }}">{{ $dia }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Horário de início e fim --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="hora_inicio">Hora de Início</label>
                                    <div class="col-sm-4">
                                        <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" required>
                                    </div>

                                    <label class="col-sm-2 col-form-label" for="hora_fim">Hora de Fim</label>
                                    <div class="col-sm-4">
                                        <input type="time" id="hora_fim" name="hora_fim" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Duração das consultas --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label" for="duracao_consulta">Duração (minutos)</label>
                                    <div class="col-sm-4">
                                        <input type="number" id="duracao_consulta" name="duracao_consulta" class="form-control" value="30" min="10" required>
                                    </div>
                                </div>

                                {{-- Botões --}}
                                <div class="row mb-5">
                                    <div class="col d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-2">Criar Agenda</button>
                                        <a href="{{ route('agendas.index') }}" class="btn btn-secondary">Voltar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>

<!-- Core JS -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>

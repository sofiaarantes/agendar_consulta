<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Clinique</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
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
                    <span class="app-brand-text demo menu-text fw-bolder text-capitalize">Clinique</span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item active">
                        <a href="{{ route('dashboard')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Página Inicial</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Médicos</span>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('medicos.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            Ver Médicos
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Consultas</span>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('consultas.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-group"></i>
                            Minhas Consultas
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('consultas.historico') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            Histórico de Consultas
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

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)"> <i class="bx bx-menu bx-sm"></i> </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="{{ Auth::user()->profile_photo_path 
                                            ? asset('storage/' . Auth::user()->profile_photo_path) 
                                            : asset('assets/img/foto_padrao.jpg') }}" 
                                        alt="Foto do perfil" class="rounded-circle">
                                </div>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ Auth::user()->profile_photo_path 
                                                                ? asset('storage/' . Auth::user()->profile_photo_path) 
                                                                : asset('assets/img/foto_padrao.jpg') }}" 
                                                            alt="Foto do perfil" class="rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                                    <small class="text-muted">Paciente</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('pacientes.edit', Auth::user()->paciente->id)}}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Editar Perfil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                                <i class="bx bx-power-off me-2"></i> 
                                                Sair
                                            </button>
                                        </form> 
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->
                <div class="container-xxl flex-grow-1 container-p-y">

                    {{-- Próxima Consulta --}}
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0 mt-3">
                                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-white">
                                        <i class="bx bx-calendar me-2"></i> Sua Próxima Consulta
                                    </h5>
                                </div>

                                <div class="card-body mt-3 d-flex flex-wrap align-items-center justify-content-between">
                                    @if($proximaConsulta)
                                        <div class="d-flex align-items-center mb-3 mb-md-0">
                                            <img src="{{ $proximaConsulta->agenda->medico->usuario->profile_photo_path 
                                                        ? asset('storage/' . $proximaConsulta->agenda->medico->usuario->profile_photo_path) 
                                                        : asset('assets/img/foto_padrao.jpg') }}" 
                                                alt="Foto do médico"
                                                class="rounded-circle me-3 shadow-sm"
                                                style="width: 90px; height: 90px; object-fit: cover;">

                                            <div>
                                                <h5 class="mb-1 text-dark">{{ $proximaConsulta->agenda->medico->usuario->name }}</h5>
                                                <p class="mb-1 text-muted">{{ $proximaConsulta->agenda->medico->especialidade->especialidade }}</p>
                                                <p class="mb-0">
                                                    <i class="bx bx-time-five text-primary"></i>
                                                    {{ \Carbon\Carbon::parse($proximaConsulta->data.' '.$proximaConsulta->hora_inicio)->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <p class="mb-1">
                                                <strong>Status:</strong> 
                                                <span class="badge 
                                                    @if($proximaConsulta->status === 'reservada') bg-warning text-dark 
                                                    @elseif($proximaConsulta->status === 'realizada') bg-success 
                                                    @elseif($proximaConsulta->status === 'cancelada') bg-danger 
                                                    @else bg-secondary 
                                                    @endif">
                                                    {{ ucfirst($proximaConsulta->status) }}
                                                </span>
                                            </p>

                                            @if($proximaConsulta->status === 'reservada' && \Carbon\Carbon::parse($proximaConsulta->data)->isFuture())
                                                <a href="{{ route('consultas.cancelar', $proximaConsulta->id) }}" 
                                                class="btn btn-outline-danger btn-sm mt-2">
                                                    <i class="bx bx-x-circle me-1"></i> Cancelar
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center w-100">
                                            <p class="mb-2 text-muted">Você não possui consultas agendadas.</p>
                                            <a href="{{ route('medicos.index') }}" class="btn btn-sm btn-primary">
                                                <i class="bx bx-search me-1"></i> Buscar Médicos
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notificações -->
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header">
                                    <h5 class="mb-0">Notificações Recentes</h5>
                                </div>
                                <div class="card-body">
                                    @if($notificacoes->isNotEmpty())
                                        @foreach($notificacoes as $notif)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="mdi mdi-bell-outline text-primary me-2"></i>
                                                    {{ $notif->mensagem }}
                                                    <small class="text-muted d-block">
                                                        {{ \Carbon\Carbon::parse($notif->created_at)->setTimezone('America/Sao_Paulo')->diffForHumans() }}
                                                    </small>
                                                </div>

                                                <form action="{{ route('notificacoes.destroy', $notif->id) }}" method="POST" class="ms-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        <i class="mdi mdi-check"></i> Marcar como Lida
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                        <p class="text-muted mb-0">Nenhuma notificação no momento.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Últimas Consultas (somente realizadas) --}}
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-dark">
                                        <i class="bx bx-history me-2 text-primary"></i> Últimas Consultas Realizadas
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @php
                                        $consultasRealizadas = $ultimasConsultas->where('status', 'realizada');
                                    @endphp

                                    @if($consultasRealizadas->isEmpty())
                                        <div class="text-center py-4 text-muted">
                                            <i class="bx bx-calendar-x fs-1 d-block mb-2"></i>
                                            Nenhuma consulta realizada até o momento.
                                        </div>
                                    @else
                                        <table class="table table-striped text-center align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Médico</th>
                                                    <th>Especialidade</th>
                                                    <th>Data/Hora</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($consultasRealizadas as $consulta)
                                                    <tr>
                                                        <td>{{ $consulta->agenda->medico->usuario->name }}</td>
                                                        <td>{{ $consulta->agenda->medico->especialidade->especialidade }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($consulta->data.' '.$consulta->hora_inicio)->format('d/m/Y H:i') }}</td>
                                                        <td><span class="badge bg-success">Realizada</span></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="text-end">
                                            <a href="{{ route('consultas.historico') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                Ver histórico completo
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Resumo Rápido --}}
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card text-center border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Consultas Agendadas</h6>
                                    <h3 class="text-primary fw-bold">{{ $totalAgendadas }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card text-center border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Consultas Realizadas</h6>
                                    <h3 class="text-success fw-bold">{{ $totalRealizadas }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card text-center border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Consultas Canceladas</h6>
                                    <h3 class="text-danger fw-bold">{{ $totalCanceladas }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
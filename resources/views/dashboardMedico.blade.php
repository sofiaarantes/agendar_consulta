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
                        <span class="menu-header-text">Agenda</span>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('agendas.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            Editar Agendas
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Consultas</span>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('consultas.index') }}" class="menu-link">
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
                                                    <small class="text-muted">Médico(a)</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('medicos.edit', Auth::user()->medico->id)}}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Meu Perfil</span>
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

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">

                        <h4 class="fw-bold mb-4">Dados do Mês</h4>

                        <!-- Cards Resumo -->
                        <div class="row mb-4">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card shadow-sm border-0 text-center p-3">
                                    <i class="mdi mdi-calendar-check text-primary mb-2" style="font-size: 2rem;"></i>
                                    <h5 class="mb-1">Consultas Hoje</h5>
                                    <h3 class="text-primary fw-bold">{{ $consultasHoje ?? 0 }}</h3>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card shadow-sm border-0 text-center p-3">
                                    <i class="mdi mdi-account-multiple text-success mb-2" style="font-size: 2rem;"></i>
                                    <h5 class="mb-1">Pacientes do Mês</h5>
                                    <h3 class="text-success fw-bold">{{ $pacientesMes ?? 0 }}</h3>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card shadow-sm border-0 text-center p-3">
                                    <i class="mdi mdi-clock-outline text-warning mb-2" style="font-size: 2rem;"></i>
                                    <h5 class="mb-1">Consultas Realizadas</h5>
                                    <h3 class="text-warning fw-bold">{{ $consultasMes ?? 0 }}</h3>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card shadow-sm border-0 text-center p-3">
                                    <i class="mdi mdi-alert-circle text-danger mb-2" style="font-size: 2rem;"></i>
                                    <h5 class="mb-1">Cancelamentos</h5>
                                    <h3 class="text-danger fw-bold">{{ $cancelamentosMes ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico -->
                        <div class="card mb-4 shadow-sm border-0">
                            @if($temConsultas)
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Consultas Realizadas</h5>
                                    <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center">
                                        <select name="mes" class="form-select form-select-sm" onchange="this.form.submit()">
                                            @foreach(range(1, 12) as $mes)
                                                <option value="{{ $mes }}" {{ $mes == $mesSelecionado ? 'selected' : '' }}>
                                                    {{ ucfirst(\Carbon\Carbon::create()->month($mes)->translatedFormat('F')) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <canvas id="graficoConsultas" height="120"></canvas>
                                </div>
                            @else
                                <div class="alert alert-info text-center mt-4">
                                    Nenhuma consulta realizada neste mês.
                                </div>
                            @endif
                        </div>

                        <!-- Próximas Consultas -->
                        <div class="card mb-4 shadow-sm border-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Próximas Consultas</h5>
                                <a href="{{ route('consultas.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                            </div>
                            <div class="card-body">
                                @if(!empty($proximasConsultas) && count($proximasConsultas) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Horário</th>
                                                    <th>Paciente</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($proximasConsultas as $consulta)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($consulta->data)->format('d/m/Y') }}</td>
                                                    <td>{{ $consulta->hora_inicio }} - {{ $consulta->hora_fim }}</td>
                                                    <td>{{ $consulta->paciente->usuario->name ?? '—' }}</td>
                                                    <td>
                                                        <span class="badge 
                                                            @if($consulta->status == 'disponivel') bg-success
                                                            @elseif($consulta->status == 'reservada') bg-primary
                                                            @else bg-danger @endif">
                                                            {{ ucfirst($consulta->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted mb-0">Nenhuma consulta futura encontrada.</p>
                                @endif
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
                                            <ul class="list-group list-group-flush">
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficoConsultas').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels ?? []),
                datasets: [{
                    label: 'Consultas Realizadas',
                    data: @json($dados ?? []),
                    backgroundColor: 'rgba(105,108,255,0.5)',
                    borderColor: '#696cff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Mostra apenas números inteiros
                            callback: function(value) {
                                return Number.isInteger(value) ? value : null;
                            },
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
  </body>
</html>
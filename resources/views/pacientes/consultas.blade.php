<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Minhas Consultas</title>

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
                    <li class="menu-item active">
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

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Consultas/</span> Minhas Consultas</h4>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>Minhas Consultas</h5>
                    </div>
                    <div class="card-body">
                        @if($consultas->isEmpty())
                            <p>Nenhuma consulta encontrada.</p>
                        @else
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Médico</th>
                                        <th>Clínica</th>
                                        <th>Especialidade</th>
                                        <th>Data</th>
                                        <th>Horário Início</th>
                                        <th>Horário Fim</th>
                                        <th>Duração</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($consultas as $consulta)
                                        @php
                                            $agenda = $consulta->agenda;
                                            $medico = $agenda->medico;
                                            $dataHoraConsulta = \Carbon\Carbon::parse($consulta->data . ' ' . $consulta->hora_inicio);
                                            $agora = \Carbon\Carbon::now();
                                            $podeCancelar = $dataHoraConsulta->diffInHours($agora, false) < -24;
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ ucfirst($consulta->status) }}
                                                @if($consulta->status == 'cancelado' && $agenda->observacao)
                                                    <br><small>Obs.: {{ $agenda->observacao }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $medico->usuario->name }}</td>
                                            <td>{{ $medico->clinica }}</td>
                                            <td>{{ $medico->especialidade->especialidade ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($consulta->data)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($consulta->hora_inicio)->format('H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($consulta->hora_fim)->format('H:i') }}</td>
                                            <td>{{ $agenda->duracao_consulta }} min</td>
                                            <td>
                                                @if($consulta->status == 'reservada')
                                                    @if($podeCancelar)
                                                        <a href="{{ route('consultas.cancelar.form', $consulta->id) }}" class="btn btn-danger btn-sm">
                                                            Cancelar
                                                        </a>
                                                    @else
                                                        <button class="btn btn-secondary btn-sm" disabled>Não é possível cancelar</button>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
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

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>

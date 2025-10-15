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
                    <span class="app-brand-text demo menu-text fw-bolder text-capitalize"> Clinique</span>
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

                    <!-- Médicos -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Médicos</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-pulse"></i>
                            <div data-i18n="Layouts">Gerenciar Médicos</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('medicos.autenticar') }}" class="menu-link">
                                    Autenticar Médico
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('medicos.index') }}" class="menu-link">
                                    Ver Médicos
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Pacientes -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Pacientes</span>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('pacientes.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            Gerenciar Pacientes
                        </a>
                    </li>

                    <!-- Especialidades -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Especialidades</span>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('especialidades.index')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-book"></i>
                            Gerenciar Especialidades
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
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id)}}">
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

                <!-- Conteúdo -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <h4 class="fw-bold mb-4">Resumo do Sistema</h4>

                        <!-- Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-center shadow-sm border-0 p-3">
                                    <i class="bx bx-user-pin text-primary mb-2" style="font-size: 2rem;"></i>
                                    <h6>Médicos Cadastrados</h6>
                                    <h3 class="fw-bold text-primary">{{ $totalMedicos ?? 0 }}</h3>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-center shadow-sm border-0 p-3">
                                    <i class="bx bx-user text-success mb-2" style="font-size: 2rem;"></i>
                                    <h6>Pacientes Ativos</h6>
                                    <h3 class="fw-bold text-success">{{ $totalPacientes ?? 0 }}</h3>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-center shadow-sm border-0 p-3">
                                    <i class="bx bx-layer text-warning mb-2" style="font-size: 2rem;"></i>
                                    <h6>Especialidades</h6>
                                    <h3 class="fw-bold text-warning">{{ $totalEspecialidades ?? 0 }}</h3>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-center shadow-sm border-0 p-3">
                                    <i class="bx bx-user-check text-danger mb-2" style="font-size: 2rem;"></i>
                                    <h6>Médicos Pendentes</h6>
                                    <h3 class="fw-bold text-danger">{{ $medicosPendentes->count() ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Médicos não autenticados -->
                        <div class="card shadow-sm border-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Médicos Não Autenticados</h5>
                                <a href="{{ route('medicos.autenticar') }}" class="btn btn-sm btn-primary">
                                    Autenticar Médicos
                                </a>
                            </div>
                            <div class="card-body">
                                @if($medicosPendentes->isNotEmpty())
                                    <div class="list-group list-group-flush">
                                        @foreach($medicosPendentes as $medico)
                                            <div class="list-group-item p-3 d-flex align-items-center justify-content-between shadow-sm mb-2 rounded">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <img src="{{ $medico->usuario->profile_photo_path ? asset('storage/' . $medico->usuario->profile_photo_path) : asset('assets/img/foto_padrao.jpg') }}" 
                                                            alt="Foto do Médico" class="rounded-circle" width="60" height="60">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">{{ $medico->usuario->name }}</h6>
                                                        <small class="text-muted">{{ $medico->especialidade->especialidade ?? '-' }}</small><br>
                                                        <small class="text-muted"><i class="bx bx-id-card me-1"></i> CRM: {{ $medico->crm }}</small><br>
                                                        <small class="text-muted"><i class="bx bx-building me-1"></i> Clínica: {{ $medico->clinica }}</small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="{{ route('medicos.autenticar', $medico->id) }}" class="btn btn-sm btn-success">
                                                        Autenticar
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0 text-center">Nenhum médico pendente de autenticação no momento.</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /Conteúdo -->
            </div>
        </div>
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
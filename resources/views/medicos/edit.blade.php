<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Editar Perfil</title>

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
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
                            Editar Agenda
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

        <!-- Layout container -->
        <div class="layout-page">

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">Editar Perfil</h4>
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
                <div class="card-body">
                    <form action="{{ route('medicos.update', $medico->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Dados Pessoais</h5>
                        </div>
                        <div class="card-body">
                            {{-- Foto de Perfil --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="profile_photo">Foto de Perfil</label>
                                <div class="col-sm-10">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $medico->usuario->profile_photo_path ? asset('storage/' . $medico->usuario->profile_photo_path) : asset('assets/img/foto_padrao.jpg') }}" 
                                            alt="Foto de Perfil" class="rounded-circle me-3" width="80" height="80">
                                        <input type="file" id="profile_photo" name="profile_photo" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            {{-- Nome --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nome">Nome</label>
                                <div class="col-sm-10">
                                    <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $medico->usuario->name) }}" required/>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="email">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $medico->usuario->email) }}" required/>
                                </div>
                            </div>

                            {{-- Telefone --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="telefone">Telefone</label>
                                <div class="col-sm-10">
                                    <input type="text" id="telefone" name="telefone" class="form-control phone-mask" value="{{ old('telefone', $medico->usuario->telefone) }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Dados Profissionais</h5>
                            <span class="badge bg-info text-dark">Status atual: {{ ucfirst($medico->status) }}</span>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                Alterar Especialidade, CRM ou Clínica fará com que o status da sua conta seja definido como <strong>pendente</strong> de avaliação.
                            </div>

                            {{-- Especialidade --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="especialidade">Especialidade</label>
                                <div class="col-sm-10">
                                    <input type="text" id="especialidade" name="especialidade" class="form-control" value="{{ old('especialidade', $medico->especialidade) }}" />
                                </div>
                            </div>

                            {{-- CRM --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="crm">CRM</label>
                                <div class="col-sm-10">
                                    <input type="text" id="crm" name="crm" class="form-control" value="{{ old('crm', $medico->crm) }}" />
                                </div>
                            </div>

                            {{-- Clínica --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="clinica">Clínica</label>
                                <div class="col-sm-10">
                                    <input type="text" id="clinica" name="clinica" class="form-control" value="{{ old('clinica', $medico->clinica) }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Botão --}}
                    <div class="row mb-5">
                        <div class="col d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">Salvar Alterações</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Voltar</a>
                        </div>
                    </div>
                </form>
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
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>

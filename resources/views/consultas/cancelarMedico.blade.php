<!DOCTYPE html>
<html lang="pt-br" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Cancelar Consulta</title>

  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico')}}" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

  <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <!-- Menu lateral -->
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
            <li class="menu-item">
                <a href="{{ route('agendas.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    Editar Agenda
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Consultas</span>
            </li>
            <li class="menu-item active">
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
      <!-- /Menu lateral -->

      <!-- Layout principal -->
      <div class="layout-page">
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="fw-bold py-3 mb-4">Cancelar Consulta</h4>

            {{-- Mensagem de sucesso --}}
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            {{-- Mensagem de erro --}}
            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            <div class="card mb-4">
              <div class="card-header">
                <h5>Detalhes da Consulta</h5>
              </div>
              <div class="card-body">
                <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($consulta->data)->format('d/m/Y') }}</p>
                <p><strong>Horário:</strong> {{ $consulta->hora_inicio }} - {{ $consulta->hora_fim }}</p>
                <p><strong>Médico:</strong> {{ $consulta->agenda->medico->usuario->name }}</p>
                <p><strong>Especialidade:</strong> {{ $consulta->agenda->medico->especialidade->especialidade }}</p>
                @if(isset($consulta->paciente))
                  <p><strong>Paciente:</strong> {{ $consulta->paciente->usuario->name }}</p>
                @endif
              </div>
            </div>

            <form action="{{ route('consultas.cancelar', $consulta->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="card mb-4">
                <div class="card-header">
                  <h5>Confirmação</h5>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label for="observacao" class="form-label">Motivo do Cancelamento (opcional)</label>
                    <textarea class="form-control" id="observacao" name="observacao" rows="3" placeholder="Descreva o motivo, se desejar."></textarea>
                  </div>
                  <p class="text-danger">Tem certeza de que deseja cancelar esta consulta? Esta ação não poderá ser desfeita.</p>
                </div>
              </div>

              <div class="row mb-5">
                <div class="col d-flex justify-content-end">
                  <button type="submit" class="btn btn-danger me-2">Confirmar Cancelamento</button>
                  <a href="{{ route('consultas.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>

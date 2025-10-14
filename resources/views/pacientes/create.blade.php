<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-1/3 max-w-md shadow-xl p-8 bg-gradient-to-r from-blue-500 to-indigo-600 mt-2">
            <div class="bg-white rounded-lg p-6">
                <div class="text-center mb-6">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="mx-auto h-16 w-16">
                    <h1 class="text-2xl font-bold text-gray-800 mt-2">Quase pronto</h1>
                    <p class="text-sm text-gray-500">Entre com seus dados para se cadastrar como médico</p>
                </div>
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('pacientes.store') }}">
                    @csrf

                    <!-- Especialidade -->
                    <div>
                        <x-label for="data_nascimento" value="{{ __('Data de Nascimento') }}" />
                        <x-input id="data_nascimento" class="block mt-1 w-full" type="date" name="data_nascimento" required autofocus/>
                    </div>

                    <!-- crm -->
                    <div class="mt-4">
                        <x-label for="endereco" value="{{ __('Endereço') }}" />
                        <x-input id="endereco" class="block mt-1 w-full" type="text" name="endereco" required/>
                    </div>

                    <!-- Id do Usuário -->
                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

                    <!-- Botão Cadastrar e Link Login -->
                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ms-4">
                            {{ __('Cadastrar') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

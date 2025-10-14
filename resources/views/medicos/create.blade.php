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

                <form method="POST" action="{{ route('medicos.store') }}">
                    @csrf

                    <!-- Especialidade -->
                    <div class="mt-4">
                        <x-label for="especialidade_id" value="{{ __('Especialidade') }}" />
                        <select id="especialidade_id" name="especialidade_id" class="block mt-1 w-full" required>
                            <option value="">Selecione uma especialidade</option>
                            @foreach($especialidades as $esp)
                                <option value="{{ $esp->id }}">{{ $esp->especialidade }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- crm -->
                    <div class="mt-4">
                        <x-label for="crm" value="{{ __('CRM') }}" />
                        <x-input id="crm" class="block mt-1 w-full" type="text" name="crm" required/>
                    </div>

                    <!-- Clínica -->
                    <div class="mt-4">
                        <x-label for="clinica" value="{{ __('Clínica') }}" />
                        <x-input id="clinica" class="block mt-1 w-full" type="text" name="clinica" required/>
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

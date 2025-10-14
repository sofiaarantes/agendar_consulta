<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-1/3 max-w-md shadow-xl p-8 bg-gradient-to-r from-blue-500 to-indigo-600 mt-2">
            <div class="bg-white rounded-lg p-6">
                <div class="text-center mb-6">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="mx-auto h-16 w-16">
                    <h1 class="text-2xl font-bold text-gray-800 mt-2">Registre-se!</h1>
                    <p class="text-sm text-gray-500">Entre com seus dados para criar sua conta</p>
                </div>
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Nome -->
                    <div>
                        <x-label for="name" value="{{ __('Nome') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>

                    <!-- Senha -->
                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Senha') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <!-- Confirmar Senha -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirmar Senha') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    <!-- Telefone -->
                    <div class="mt-4">
                        <x-label for="telefone" value="{{ __('Telefone') }}" />
                        <x-input id="telefone" class="block mt-1 w-full" type="number" name="telefone" required />
                    </div>

                    <!-- Tipo de Usuário -->
                    <div class="mt-4 text-center">
                        <span class="text-gray-700 font-medium mb-2 block">Tipo de usuário</span>
                        <div class="flex justify-center mt-2 space-x-8">
                            <label class="inline-flex items-center">
                                <input type="radio" name="tipo_usuario" value="1" class="form-radio" checked>
                                <span class="ml-2">Paciente</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="tipo_usuario" value="2" class="form-radio">
                                <span class="ml-2">Médico</span>
                            </label>
                        </div>
                    </div>

                    <!-- Foto de Perfil -->
                    <div class="mt-4">
                        <x-label for="profile_photo" value="{{ __('Foto de Perfil (opcional)') }}" />
                        <x-input id="profile_photo" class="block mt-1 w-full" type="file" name="profile_photo"/>
                    </div>

                    <!-- Botão Cadastrar e Link Login -->
                    <div class="flex items-center justify-end mt-6">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Já é cadastrado?') }}
                        </a>

                        <x-button class="ms-4">
                            {{ __('Cadastrar') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

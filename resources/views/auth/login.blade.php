<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-1/3 max-w-md shadow-xl p-8 bg-gradient-to-r from-blue-500 to-indigo-600">
            <div class="bg-white rounded-lg p-6">
                <div class="text-center mb-6">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="mx-auto h-16 w-16">
                    <h1 class="text-2xl font-bold text-gray-800 mt-2">Bem-vindo!</h1>
                    <p class="text-sm text-gray-500">Entre com suas credenciais para acessar o sistema</p>
                </div>

                    <x-validation-errors class="mb-4" />

                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-label for="email" value="{{ __('Usuário') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Senha') }}" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('registerUser') }}">
                                {{ __('Ainda não tem uma conta? Registre-se!') }}
                            </a>
                            <x-button class="ms-4">
                                {{ __('Entrar') }}
                            </x-button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</x-guest-layout>

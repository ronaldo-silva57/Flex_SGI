<x-guest-layout>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">
            Configuração inicial
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            Cadastre o administrador e a empresa para iniciar o sistema.
        </p>
    </div>

    <form method="POST" action="{{ route('setup.store') }}">
        @csrf

        {{-- ========================================== --}}
        {{-- ADMINISTRADOR                              --}}
        {{-- ========================================== --}}

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-user-shield text-indigo-600 mr-2"></i>
                Administrador do sistema
            </h3>

            {{-- Nome --}}
            <div>
                <x-input-label for="name" :value="__('Nome')" />

                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"/>

                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>

            {{-- E-mail --}}
            <div class="mt-4">
                <x-input-label for="email" :value="__('E-mail')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username"/>

                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            {{-- Senha --}}
            <div class="mt-4">
                <x-input-label for="password" :value="__('Senha')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"/>

                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            {{-- Confirmar senha --}}
            <div class="mt-4">
                <x-input-label
                    for="password_confirmation"
                    :value="__('Confirmar senha')"
                />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password"/>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
            </div>

            {{-- Nível --}}
            <div class="mt-4">
                <x-input-label value="Nível de acesso" />

                <div class="mt-2 rounded-md bg-gray-100 px-4 py-3">
                    <span class="font-semibold text-gray-800">
                        Administrador
                    </span>

                    <p class="text-xs text-gray-600 mt-1">
                        O primeiro usuário recebe automaticamente
                        o nível de Administrador.
                    </p>
                </div>
            </div>
        </div>


        {{-- ========================================== --}}
        {{-- EMPRESA                                    --}}
        {{-- ========================================== --}}

        <div class="border-t pt-6">

            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-building text-indigo-600 mr-2"></i>
                Dados da empresa
            </h3>

            {{-- Razão Social --}}
            <div>
                <x-input-label for="razao_social" :value="__('Razão Social')"/>

                <x-text-input id="razao_social" class="block mt-1 w-full" type="text" name="razao_social" :value="old('razao_social')" required/>

                <x-input-error
                    :messages="$errors->get('razao_social')"
                    class="mt-2"
                />
            </div>

            {{-- Nome Fantasia --}}
            <div class="mt-4">
                <x-input-label
                    for="nome_fantasia"
                    :value="__('Nome Fantasia')"
                />

                <x-text-input id="nome_fantasia" class="block mt-1 w-full" type="text" name="nome_fantasia" :value="old('nome_fantasia')"/>

                <x-input-error
                    :messages="$errors->get('nome_fantasia')"
                    class="mt-2"
                />
            </div>

            {{-- CNPJ / IE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                <div>
                    <x-input-label
                        for="cnpj"
                        :value="__('CNPJ')"
                    />

                    <x-text-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" :value="old('cnpj')"/>

                    <x-input-error
                        :messages="$errors->get('cnpj')"
                        class="mt-2"
                    />
                </div>

                <div>
                    <x-input-label
                        for="ie"
                        :value="__('Inscrição Estadual')"
                    />

                    <x-text-input id="ie" class="block mt-1 w-full" type="text" name="ie" :value="old('ie')"/>

                    <x-input-error
                        :messages="$errors->get('ie')"
                        class="mt-2"
                    />
                </div>

            </div>

            {{-- Endereço --}}
            <div class="mt-4">
                <x-input-label
                    for="endereco"
                    :value="__('Endereço')"
                />

                <x-text-input id="endereco" class="block mt-1 w-full" type="text" name="endereco" :value="old('endereco')"/>

                <x-input-error
                    :messages="$errors->get('endereco')"
                    class="mt-2"
                />
            </div>

            {{-- Cidade / Estado / CEP --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">

                <div>
                    <x-input-label
                        for="cidade"
                        :value="__('Cidade')"
                    />

                    <x-text-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" :value="old('cidade')"/>
                </div>

                <div>
                    <x-input-label
                        for="estado"
                        :value="__('UF')"
                    />

                    <x-text-input id="estado" class="block mt-1 w-full uppercase" type="text" name="estado" maxlength="2" :value="old('estado')"/>
                </div>

                <div>
                    <x-input-label
                        for="cep"
                        :value="__('CEP')"
                    />

                    <x-text-input id="cep" class="block mt-1 w-full" type="text" name="cep" :value="old('cep')"/>
                </div>

            </div>

            {{-- Telefone / E-mail --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                <div>
                    <x-input-label
                        for="telefone"
                        :value="__('Telefone')"
                    />

                    <x-text-input id="telefone" class="block mt-1 w-full" type="text" name="telefone" :value="old('telefone')"/>
                </div>

                <div>
                    <x-input-label
                        for="email_empresa"
                        :value="__('E-mail da empresa')"
                    />

                    <x-text-input id="email_empresa" class="block mt-1 w-full" type="email" name="email_empresa" :value="old('email_empresa')"/>
                </div>

            </div>

        </div>


        {{-- BOTÃO --}}

        <div class="flex items-center justify-end mt-8">

            <a
                href="{{ route('login') }}"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
                Voltar para o login
            </a>

            <x-primary-button class="ms-4">
                <i class="fas fa-check mr-2"></i>
                Finalizar configuração
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>

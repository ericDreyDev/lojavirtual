<!-- Formulário -->
                    <form action="{{ url('/suppliers') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Tipo de Pessoa -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tipo de Pessoa</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <input id="tipo_f" name="tipo" type="radio" value="F" 
                                           {{ old('tipo') === 'F' ? 'checked' : '' }}
                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700" 
                                           onchange="updateDocumentLabel()">
                                    <label for="tipo_f" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Pessoa Física
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="tipo_j" name="tipo" type="radio" value="J" 
                                           {{ old('tipo') === 'J' ? 'checked' : '' }}
                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700" 
                                           onchange="updateDocumentLabel()">
                                    <label for="tipo_j" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Pessoa Jurídica
                                    </label>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                        </div>

                        <!-- Dados Básicos -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Dados Básicos</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="nome_razao" id="nome_label" value="Nome/Razão Social *" />
                                    <x-text-input id="nome_razao" name="nome_razao" type="text" 
                                                 value="{{ old('nome_razao') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="Digite o nome ou razão social"
                                                 required />
                                    <x-input-error :messages="$errors->get('nome_razao')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="cpf_cnpj" id="documento_label" value="CPF/CNPJ *" />
                                    <x-text-input id="cpf_cnpj" name="cpf_cnpj" type="text" 
                                                 value="{{ old('cpf_cnpj') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="000.000.000-00 ou 00.000.000/0000-00"
                                                 required />
                                    <x-input-error :messages="$errors->get('cpf_cnpj')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-6">
                                <x-input-label for="telefone" value="Telefone *" />
                                <x-text-input id="telefone" name="telefone" type="text" 
                                             value="{{ old('telefone') }}" 
                                             class="mt-1 block w-full" 
                                             placeholder="(00) 00000-0000"
                                             maxlength="15"
                                             required />
                                <x-input-error :messages="$errors->get('telefone')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Exibir todos os erros de validação -->
                        @if ($errors->any())
                            <div class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Ops! Algo deu errado:</strong>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Botões de ação -->
                        <div class="flex items-center justify-between space-x-4">
                            <a href="{{ url('/suppliers') }}">
                                <x-secondary-button>
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Voltar
                                </x-secondary-button>
                            </a>
                            
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Salvar Fornecedor
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para atualizar labels baseado no tipo selecionado
        function updateDocumentLabel() {
            const tipoF = document.getElementById('tipo_f').checked;
            const tipoJ = document.getElementById('tipo_j').checked;
            const nomeLabel = document.getElementById('nome_label');
            const documentoLabel = document.getElementById('documento_label');
            const cpfCnpjInput = document.getElementById('cpf_cnpj');
            
            if (tipoF) {
                nomeLabel.textContent = 'Nome Completo *';
                documentoLabel.textContent = 'CPF *';
                cpfCnpjInput.placeholder = '000.000.000-00';
                cpfCnpjInput.maxLength = 14;
            } else if (tipoJ) {
                nomeLabel.textContent = 'Razão Social *';
                documentoLabel.textContent = 'CNPJ *';
                cpfCnpjInput.placeholder = '00.000.000/0000-00';
                cpfCnpjInput.maxLength = 18;
            }
        }

        // Máscara para CPF/CNPJ baseada no tipo
        document.getElementById('cpf_cnpj').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            const tipoF = document.getElementById('tipo_f').checked;
            
            if (tipoF) {
                // Máscara CPF: 000.000.000-00
                value = value.replace(/^(\d{3})(\d)/, '$1.$2');
                value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
                value = value.replace(/\.(\d{3})(\d)/, '.$1-$2');
            } else {
                // Máscara CNPJ: 00.000.000/0000-00
                value = value.replace(/^(\d{2})(\d)/, '$1.$2');
                value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
                value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });

        // Máscara para telefone
        document.getElementById('telefone').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length === 11) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else {
                value = value.replace(/^(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            }
            e.target.value = value;
        });

        // Atualizar labels na carga da página se algum tipo estiver selecionado
        document.addEventListener('DOMContentLoaded', function() {
            updateDocumentLabel();
        });

        // Adicionar listeners para os radio buttons
        document.getElementById('tipo_f').addEventListener('change', updateDocumentLabel);
        document.getElementById('tipo_j').addEventListener('change', updateDocumentLabel);
    </script>
</x-app-layout><x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Adicionar Novo Fornecedor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Breadcrumb -->
                    <nav class="flex mb-6" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ url('/suppliers') }}" class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    Fornecedores
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2">Adicionar</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <!-- Formulário -->
                    <form action="{{ url('/suppliers') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Dados Básicos -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Dados Básicos</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="name" value="Nome da Empresa *" />
                                    <x-text-input id="name" name="name" type="text" 
                                                 value="{{ old('name') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="Digite o nome da empresa"
                                                 required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="cnpj" value="CNPJ *" />
                                    <x-text-input id="cnpj" name="cnpj" type="text" 
                                                 value="{{ old('cnpj') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="00.000.000/0000-00"
                                                 maxlength="18"
                                                 required />
                                    <x-input-error :messages="$errors->get('cnpj')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <x-input-label for="email" value="Email *" />
                                    <x-text-input id="email" name="email" type="email" 
                                                 value="{{ old('email') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="contato@empresa.com.br"
                                                 required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="phone" value="Telefone *" />
                                    <x-text-input id="phone" name="phone" type="text" 
                                                 value="{{ old('phone') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="(00) 00000-0000"
                                                 maxlength="15"
                                                 required />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Endereço</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="address" value="Endereço *" />
                                    <x-text-input id="address" name="address" type="text" 
                                                 value="{{ old('address') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="Rua, número, bairro"
                                                 required />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="zipcode" value="CEP *" />
                                    <x-text-input id="zipcode" name="zipcode" type="text" 
                                                 value="{{ old('zipcode') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="00000-000"
                                                 maxlength="9"
                                                 required />
                                    <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="city" value="Cidade *" />
                                    <x-text-input id="city" name="city" type="text" 
                                                 value="{{ old('city') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="Nome da cidade"
                                                 required />
                                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="state" value="Estado *" />
                                    <x-text-input id="state" name="state" type="text" 
                                                 value="{{ old('state') }}" 
                                                 class="mt-1 block w-full" 
                                                 placeholder="UF"
                                                 maxlength="2"
                                                 style="text-transform: uppercase"
                                                 required />
                                    <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div>
                            <x-input-label for="observations" value="Observações" />
                            <textarea id="observations" name="observations" 
                                     class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                     rows="3"
                                     placeholder="Informações adicionais sobre o fornecedor (opcional)">{{ old('observations') }}</textarea>
                            <x-input-error :messages="$errors->get('observations')" class="mt-2" />
                        </div>

                        <!-- Exibir todos os erros de validação -->
                        @if ($errors->any())
                            <div class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Ops! Algo deu errado:</strong>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Botões de ação -->
                        <div class="flex items-center justify-between space-x-4">
                            <a href="{{ url('/suppliers') }}">
                                <x-secondary-button>
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Voltar
                                </x-secondary-button>
                            </a>
                            
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Salvar Fornecedor
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Máscara para CNPJ
        document.getElementById('cnpj').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/^(\d{2})(\d)/, '$1.$2');
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Máscara para telefone
        document.getElementById('phone').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length === 11) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else {
                value = value.replace(/^(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            }
            e.target.value = value;
        });

        // Máscara para CEP
        document.getElementById('zipcode').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/^(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Converter estado para maiúsculo
        document.getElementById('state').addEventListener('input', function (e) {
            e.target.value = e.target.value.toUpperCase();
        });
    </script>
</x-app-layout>
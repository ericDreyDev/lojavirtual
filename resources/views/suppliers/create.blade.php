<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Adicionar Novo Fornecedor') }}
        </h2>
    </x-slot>

    <div class="py-4 px-2">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
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
                                <x-secondary-button>Voltar</x-secondary-button>
                            </a>
                            
                            <x-primary-button>Salvar Fornecedor</x-primary-button>
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
</x-app-layout>
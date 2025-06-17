<x-app-layout>
    <x-slot name="header">
        <h3 class="font-semibold text-gray-800 dark:text-gray-200 ">
            {{ __('Manutenção de Fornecedores') }}
        </h3>
    </x-slot>

    <div class="py-4 px-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Ações principais --}}
            <div class="flex justify-between items-center">
                {{-- Botão Voltar --}}
                <a href="{{ url('/catalog') }}">
                    <x-secondary-button>Voltar</x-secondary-button>
                </a>

                {{-- Botão Adicionar --}}
                <a href="{{ url('/suppliers/new') }}">
                    <x-primary-button>Novo Fornecedor</x-primary-button>
                </a>
            </div>

            {{-- Mensagem de sucesso --}}
            @if ($message = Session::get('success'))
                <div class="p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 rounded">
                    {{ $message }}
                </div>
            @endif

            {{-- Mensagem de erro --}}
            @if ($message = Session::get('error'))
                <div class="p-4 bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100 rounded">
                    {{ $message }}
                </div>
            @endif

            {{-- Formulário de busca --}}
            <form action="{{ url('/suppliers') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div>
                    <x-input-label for="search" value="Pesquisar fornecedor" />
                    <x-text-input id="search" name="search" type="text" value="{{ $filter ?? '' }}"
                        class="mt-1" placeholder="Nome/Razão Social ou CPF/CNPJ" />
                </div>
                <div class="flex gap-2 self-end">
                    <x-primary-button type="submit">Pesquisar</x-primary-button>
                    <a href="{{ url('/suppliers') }}">
                        <x-secondary-button>Limpar</x-secondary-button>
                    </a>
                </div>
            </form>

            {{-- Tabela de fornecedores --}}
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="border-b border-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nome/Razão Social
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                CPF/CNPJ
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Telefone
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($suppliers as $supplier)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $supplier->tipo === 'F' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                        {{ $supplier->tipo_full }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $supplier->nome_razao }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $supplier->formatted_cpf_cnpj }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $supplier->formatted_telefone }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 space-x-2">
                                    {{-- Botão Editar --}}
                                    <a href="{{ url('/suppliers/edit/' . $supplier->id) }}">
                                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                                            Editar
                                        </x-primary-button>
                                    </a>
                                    
                                    {{-- Botão Excluir com confirmação --}}
                                    <form action="{{ url('/suppliers/delete/' . $supplier->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <x-danger-button type="submit" 
                                                        onclick="return confirm('Tem certeza que deseja excluir o fornecedor {{ $supplier->nome_razao }}?\n\nEsta ação não pode ser desfeita.')">
                                            Excluir
                                        </x-danger-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{-- Mensagem quando não há fornecedores --}}
                @if($suppliers->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-gray-500 dark:text-gray-400">
                            @if($filter)
                                <p>Nenhum fornecedor encontrado para "{{ $filter }}".</p>
                            @else
                                <p>Nenhum fornecedor cadastrado.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
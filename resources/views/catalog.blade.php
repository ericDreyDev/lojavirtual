<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Catálogo de Produtos
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (!Auth::check())
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Login</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                @endif
            </div>
            @endif

            {{-- Filtro por Tipo --}}
            <form action="{{ route('catalog') }}" method="GET" class="mb-6">
                <label for="type" class="block text-gray-700 dark:text-gray-200 mb-1">Filtrar por tipo:</label>
                <select name="type" id="type" onchange="this.form.submit()" class="rounded px-3 py-2 dark:bg-gray-800 dark:text-white">
                    <option value="">Todos os tipos</option>
                    @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ $selectedType == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                    @endforeach
                </select>
            </form>

            {{-- Lista de Produtos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded shadow p-4">
                    <img src="{{ $imageLinks[$product->id] }}" alt="Imagem de {{ $product->name }}" class="w-full h-40 object-cover mb-4 rounded">

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $product->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $product->type->name ?? 'Sem Tipo' }}</p>
                    <p class="text-gray-800 dark:text-gray-100">Preço: R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                    <p class="text-gray-800 dark:text-gray-100">Estoque: {{ $product->quantity }}</p>
                </div>
                @empty
                <p class="text-gray-700 dark:text-gray-300">Nenhum produto disponível.</p>
                @endforelse
            </div>


        </div>
    </div>
</x-app-layout>
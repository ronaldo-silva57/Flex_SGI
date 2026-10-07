<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-building text-indigo-600"></i>
                Empresas
            </h2>
            <div class="flex space-x-4">
                <a
                    href="{{ route('cadastros.dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a
                    href="{{ route('empresas.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Nova empresa
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Mensagem de sucesso --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>
                    {{ session('success') }}
                </span>
            </div>
        @endif

        {{-- Filtro --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form
                method="GET"
                action="{{ route('empresas.index') }}"
                class="flex flex-wrap gap-3 items-end"
            >
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">
                        Buscar
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar por Razão Social, CNPJ ou Código..."
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                </div>

                {{-- Buscar --}}
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition"
                >
                    <i class="fas fa-search mr-2"></i>
                    Buscar
                </button>

                {{-- Limpar --}}
                @if(request('search'))

                    <a
                        href="{{ route('empresas.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition"
                    >
                        <i class="fas fa-times mr-2"></i>
                        Limpar
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    {{-- Cabeçalho --}}
                    <thead class="bg-gray-100">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"
                            >
                                <i class="fas fa-hashtag mr-1"></i>
                                Código
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"
                            >
                                <i class="fas fa-building mr-1"></i>
                                Razão Social / Fantasia
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"
                            >
                                <i class="fas fa-id-card mr-1"></i>
                                CNPJ
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"
                            >
                                <i class="fas fa-toggle-on mr-1"></i>
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-tools mr-1"></i>Ações
                            </th>
                        </tr>
                    </thead>

                    {{-- Corpo --}}
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($empresas as $empresa)
                            <tr
                                class="odd:bg-white even:bg-gray-50 hover:bg-indigo-50 transition duration-150"
                            >
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $empresa->codigo ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $empresa->razao_social }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $empresa->nome_fantasia ?: '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $empresa->cnpj ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($empresa->ativo)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                        >
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Ativa
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800"
                                        >
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Inativa
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 texgt-right">
                                    <div class="inline-flex gap-1">
                                        <a href="{{ route('empresas.show', $empresa) }}"
                                        class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                        title="Visualizar">
                                            <i class="fas fa-eye"></i>Visualizar
                                        </a>
                                        <a href="{{ route('empresas.edit', $empresa) }}"
                                        class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                        title="Editar">
                                            <i class="fas fa-edit"></i>Editar
                                        </a>
                                        <form action="{{ route('empresas.destroy', $empresa) }}"
                                            method="POST"
                                            onsubmit="return confirm('Excluir esta avaliação?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-2 py-1 bg-red-50 text-red-700 rounded hover:bg-red-100"
                                                title="Excluir">
                                                <i class="fas fa-trash"></i>Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="5"
                                    class="px-6 py-10 text-center text-gray-500"
                                >
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-building text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-sm font-medium text-gray-600">
                                            Nenhuma empresa encontrada.
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Tente alterar os filtros ou cadastre uma nova empresa.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($empresas->total() > 0)
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            {{ $empresas->links() }}
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


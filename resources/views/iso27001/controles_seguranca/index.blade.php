<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-shield-halved text-indigo-600"></i>
                Controles de Segurança da Informação
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('iso27001.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition shadow-sm border border-blue-100">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>
                <a href="{{ route('controles_seguranca.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Controle
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Mensagem de sucesso --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-200 text-green-700">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Barra de pesquisa --}}
            <div class="mb-6">
                <form method="GET"
                      action="{{ route('controles_seguranca.index') }}"
                      class="flex flex-wrap gap-3 items-center">
                    <div class="flex-1 min-w-[220px]">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Buscar por código, título ou descrição..."
                            >
                        </div>
                    </div>

                    {{-- Filtro implementação --}}
                    <select
                        name="implementado"
                        class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="">Todos</option>
                        <option value="1"
                            {{ request('implementado') === '1' ? 'selected' : '' }}>
                            Implementados
                        </option>
                        <option value="0"
                            {{ request('implementado') === '0' ? 'selected' : '' }}>
                            Não implementados
                        </option>
                    </select>
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                    >
                        <i class="fas fa-filter mr-2"></i>
                        Filtrar
                    </button>
                    @if(request('search') !== null || request('implementado') !== null)
                        <a href="{{ route('controles_seguranca.index') }}"
                           class="text-sm text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times-circle mr-1"></i>
                            Limpar
                        </a>
                    @endif
                </form>
            </div>

            {{-- Tabela --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Código
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Controle
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ativo
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Implementação
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Responsável
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($controles as $controle)
                            <tr class="hover:bg-gray-50">
                                {{-- Código --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono text-sm font-semibold text-indigo-700">
                                        {{ $controle->codigo_anexo_a ?? '-' }}
                                    </span>
                                </td>
                                {{-- Título --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $controle->titulo }}
                                    </div>
                                    @if($controle->descricao)
                                        <div class="text-xs text-gray-500 mt-1 max-w-md whitespace-normal break-words">
                                            {{ $controle->descricao }}
                                        </div>>
                                    @endif
                                </td>
                                {{-- Ativo --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    @if($controle->ativo)
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-server text-gray-400 mr-2"></i>
                                            {{ $controle->ativo->nome }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">
                                            Não vinculado
                                        </span>
                                    @endif
                                </td>
                                {{-- Implementação --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($controle->implementado)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Implementado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Não implementado
                                        </span>
                                    @endif
                                </td>
                                {{-- Responsável --}}
                                <td class="px-6 py-4 whitespace-normal break-words text-sm text-gray-700">
                                    {{ $controle->responsavel?->name ?? 'N/I' }}
                                </td>
                                {{-- Ações --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <a
                                            href="{{ route('controles_seguranca.show', $controle) }}"
                                            class="text-blue-600 hover:text-blue-900"
                                            title="Visualizar"
                                        >
                                            <i class="fas fa-eye"></i>
                                            <span>Visualizar</span>
                                        </a>
                                        <a
                                            href="{{ route('controles_seguranca.edit', $controle) }}"
                                            class="text-indigo-600 hover:text-indigo-900"
                                            title="Editar"
                                        >
                                            <i class="fas fa-edit"></i>
                                            <span>Editar</span>
                                        </a>
                                        <form
                                            action="{{ route('controles_seguranca.destroy', $controle) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este controle?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                <i class="fas fa-trash"></i>
                                                <span>Excluir</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-shield-halved text-4xl text-gray-300 mb-3"></i>
                                    <p>
                                        Nenhum controle de segurança cadastrado.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Paginação --}}
            <div class="mt-6">
                {{ $controles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
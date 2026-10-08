<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-clipboard-check text-purple-600"></i>
                Detalhes do Controle SoA: {{ $soaControle->codigo_anexo_a }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('soa_controles.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('soa_controles.edit', $soaControle) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Cabeçalho --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código Anexo A</span>
                    <span class="mt-1 text-lg font-bold text-purple-700">{{ $soaControle->codigo_anexo_a }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Domínio</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $soaControle->dominio }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Aplicável</span>
                    @if($soaControle->aplicavel)
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-check mr-1"></i> Sim
                        </span>
                    @else
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-200 text-gray-700">
                            <i class="fas fa-ban mr-1"></i> Não
                        </span>
                    @endif
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status de Implementação</span>
                    @php
                        $statusColors = [
                            'Não iniciado'     => 'bg-gray-100 text-gray-800',
                            'Em implementacao' => 'bg-yellow-100 text-yellow-800',
                            'Implementado'     => 'bg-green-100 text-green-800',
                            'Não aplicável'    => 'bg-slate-100 text-slate-800',
                        ];
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$soaControle->status_implementacao] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $soaControle->status_implementacao }}
                    </span>
                </div>
            </div>

            {{-- Título --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500">Título</span>
                <p class="text-gray-800 font-semibold text-lg">{{ $soaControle->titulo }}</p>
            </div>

            {{-- Descrição --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500">Descrição</span>
                <p class="text-gray-700 whitespace-pre-line">{{ $soaControle->descricao ?? 'Nenhuma descrição fornecida.' }}</p>
            </div>

            {{-- Justificativas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Justificativa de Inclusão</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $soaControle->justificativa_inclusao ?? '—' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Justificativa de Exclusão</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $soaControle->justificativa_exclusao ?? '—' }}</p>
                </div>
            </div>

            {{-- Responsável / Controle vinculado --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <p class="text-gray-700">{{ $soaControle->responsavel->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Controle de Segurança Vinculado</span>
                    <p class="text-gray-700">
                        @if($soaControle->controleSeguranca)
                            <a href="{{ route('controles_seguranca.show', $soaControle->controleSeguranca) }}"
                               class="text-blue-600 hover:underline">
                                {{ $soaControle->controleSeguranca->nome ?? $soaControle->controleSeguranca->titulo }}
                            </a>
                        @else
                            —
                        @endif
                    </p>
                </div>
            </div>

            {{-- Evidência (texto) --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500">Evidência (descrição)</span>
                <p class="text-gray-700 whitespace-pre-line">{{ $soaControle->evidencia ?? 'Nenhuma evidência descrita.' }}</p>
            </div>

            {{-- Arquivo de evidência (opcional) --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-paperclip text-purple-600"></i>Arquivo de Evidência
                </h3>

                @if(!empty($soaControle->evidencia_path))
                    <div class="flex items-center gap-3 mb-3 p-3 bg-gray-50 rounded border border-gray-200">
                        <i class="fas fa-file-alt text-blue-500 text-xl"></i>
                        <span class="text-sm text-gray-700 flex-1">{{ basename($soaControle->evidencia_path) }}</span>
                        <a href="{{ route('soa_controles.download-evidencia', $soaControle) }}"
                           class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            <i class="fas fa-download mr-1"></i> Baixar
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-sm mb-3">Nenhum arquivo anexado.</p>
                @endif

                <form action="{{ route('soa_controles.upload-evidencia', $soaControle) }}"
                      method="POST" enctype="multipart/form-data"
                      class="flex flex-wrap items-center gap-3">
                    @csrf
                    <input type="file" name="evidencia_file" required
                           accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.zip"
                           class="block text-sm text-gray-700 file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 text-sm">
                        <i class="fas fa-upload mr-2"></i> Enviar Evidência
                    </button>
                    @error('evidencia_file') <p class="text-sm text-red-600 w-full">{{ $message }}</p> @enderror
                </form>
            </div>

            {{-- Rodapé ações --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $soaControle->created_at?->format('d/m/Y H:i') }}
                    @if($soaControle->updated_at && $soaControle->updated_at != $soaControle->created_at)
                        • Atualizado em: {{ $soaControle->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                <form action="{{ route('soa_controles.destroy', $soaControle) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este controle SoA?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
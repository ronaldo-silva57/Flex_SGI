<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-eye text-blue-500"></i>Detalhes do Documento
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('documentos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('documentos.edit', $documento) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->codigo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Título</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->titulo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold">
                        {{ $documento->empresa->nome_fantasia ?? $documento->empresa->razao_social ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Processo</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->processo->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Norma</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->norma->codigo ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->responsavel->name ?? 'Não definido' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 text-lg font-semibold">
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $documento->tipo }}
                        </span>
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Versão</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->versao }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusClasses = [
                            'Rascunho' => 'bg-gray-100 text-gray-800',
                            'Em revisão' => 'bg-yellow-100 text-yellow-800',
                            'Aprovado' => 'bg-green-100 text-green-800',
                            'Obsoleto' => 'bg-red-100 text-red-800',
                        ][$documento->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses }}">
                        {{ $documento->status }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Aprovação</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->data_aprovacao ? $documento->data_aprovacao->format('d/m/Y') : '---' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Revisão</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->data_revisao ? $documento->data_revisao->format('d/m/Y') : '---' }}</span>
                </div>
                @if($documento->arquivo_path)
                    <div class="md:col-span-2">
                        <span class="block text-sm font-medium text-gray-500">Arquivo</span>
                        <a href="{{ asset('storage/' . $documento->arquivo_path) }}" target="_blank"
                           class="mt-1 text-blue-600 hover:underline inline-flex items-center gap-2">
                            <i class="fas fa-file-download"></i> Baixar arquivo
                        </a>
                    </div>
                @endif
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Conteúdo</span>
                    <p class="mt-1 text-gray-800">{{ $documento->conteudo ?? 'Não informado' }}</p>
                </div>
            </div>

            {{-- Secção de Anexos Adicionais --}}
            <div class="mt-8 bg-gray-50 p-4 rounded-lg border">
                <h4 class="text-md font-semibold text-gray-800 mb-3">
                    <i class="fas fa-paperclip mr-2 text-blue-600"></i>Anexos Complementares
                </h4>
                
                <ul class="divide-y divide-gray-200 mb-4">
                    @forelse($documento->anexos as $anexo)
                        <li class="py-2 flex justify-between items-center text-sm">
                            <a href="{{ Storage::url($anexo->arquivo_path) }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-2">
                                <i class="fas fa-file-alt text-gray-500"></i> {{ $anexo->nome_arquivo }}
                            </a>
                            <form action="{{ route('documentos.anexos.destroy', $anexo) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este anexo?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-xs inline-flex items-center gap-1 bg-red-50 px-2 py-1 rounded border border-red-200">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </li>
                    @empty
                        <p class="text-xs text-gray-500 italic">Nenhum anexo complementar registado.</p>
                    @endforelse
                </ul>

                {{-- Formulário de Envio de Anexo --}}
                <form action="{{ route('documentos.anexos.store', $documento) }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap gap-3 items-end pt-3 border-t border-gray-200">
                    @csrf
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nome do Anexo</label>
                        <input type="text" id="nome_arquivo_anexo" name="nome_arquivo" placeholder="Ex: Instrução de Apoio .txt" class="w-full text-sm rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Selecionar Arquivo (.txt, PDF, etc.)</label>
                        <input type="file" id="arquivo_input" name="arquivo" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" required>
                    </div>
                    
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-upload"></i> Enviar Anexo
                    </button>
                </form>
            </div>

            {{-- Secção de Histórico de Revisões (Requisito ISO) --}}
            <div class="mt-8">
                <h4 class="text-md font-semibold text-gray-800 mb-3"><i class="fas fa-code-branch mr-2 text-indigo-600"></i>Histórico de Versões e Revisões</h4>
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Versão</th>
                            <th class="px-4 py-2 text-left">Alterações Realizadas</th>
                            <th class="px-4 py-2 text-left">Responsável</th>
                            <th class="px-4 py-2 text-left">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($documento->revisoes as $revisao)
                            <tr>
                                <td class="px-4 py-2 font-medium">{{ $revisao->versao }}</td>
                                <td class="px-4 py-2 text-gray-600">{{ $revisao->alteracoes_realizadas }}</td>
                                <td class="px-4 py-2">{{ $revisao->responsavel->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $revisao->data_revisao ? $revisao->data_revisao->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Confirmação de Leitura pelo Utilizador Logado (ISO 9001 / 27001) --}}
            <div class="mt-8 flex justify-between items-center bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div>
                    <h5 class="font-semibold text-blue-900">Ciência e Confirmação de Leitura</h5>
                    <p class="text-xs text-blue-700">As normas exigem que os colaboradores leiam e confirmem os procedimentos aplicáveis.</p>
                </div>
                <form action="{{ route('documentos.ler', $documento) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 shadow-sm flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> Confirmar que Li e Compreendi
                    </button>
                </form>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('documentos.destroy', $documento) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este documento?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
<script>
    // Preenche automaticamente o nome do anexo com base no arquivo selecionado
    document.getElementById('arquivo_input').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const fullFileName = e.target.files[0].name;
            // Remove a extensão do arquivo para sugerir um título limpo
            const nameWithoutExt = fullFileName.substring(0, fullFileName.lastIndexOf('.')) || fullFileName;
            const nomeInput = document.getElementById('nome_arquivo_anexo');
            
            if (!nomeInput.value) {
                nomeInput.value = nameWithoutExt;
            }
        }
    });
</script>
</x-app-layout>
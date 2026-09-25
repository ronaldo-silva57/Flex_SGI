<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Empresa ID (Oculto ou Fixo baseado no seu Multi-tenant) -->
    <input type="hidden" name="empresa_id" value="{{ auth()->user()->empresa_id ?? 1 }}">

    <!-- Tipo de Documento -->
    <div>
        <label for="tipo_documento" class="block text-sm font-medium text-gray-700">Tipo de Cliente</label>
        <select name="tipo_documento" id="tipo_documento" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Selecione...</option>
            <option value="cpf" {{ old('tipo_documento', $cliente->tipo_documento ?? '') == 'cpf' ? 'selected' : '' }}>Pessoa Física (CPF)</option>
            <option value="cnpj" {{ old('tipo_documento', $cliente->tipo_documento ?? '') == 'cnpj' ? 'selected' : '' }}>Pessoa Jurídica (CNPJ)</option>
        </select>
        @error('tipo_documento') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
    </div>

    <!-- Documento (CPF/CNPJ) -->
    <div>
        <label for="documento" class="block text-sm font-medium text-gray-700">Documento (CPF / CNPJ)</label>
        <input type="text" name="documento" id="documento" value="{{ old('documento', $cliente->documento ?? '') }}"
               placeholder="Apenas números ou com máscara"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        @error('documento') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
    </div>

    <!-- Status Compliance -->
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Status Compliance SGI</label>
        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            <option value="ativo" {{ old('status', $cliente->status ?? 'ativo') == 'ativo' ? 'selected' : '' }}>Ativo</option>
            <option value="inativo" {{ old('status', $cliente->status ?? '') == 'inativo' ? 'selected' : '' }}>Inativo</option>
            <option value="bloqueado_sgi" {{ old('status', $cliente->status ?? '') == 'bloqueado_sgi' ? 'selected' : '' }}>Bloqueado SGI (Bloqueia tratativas)</option>
        </select>
        @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
    </div>

    <!-- Nome / Nome Fantasia -->
    <div class="md:col-span-2">
        <label Lyfor="nome" id="label_nome" class="block text-sm font-medium text-gray-700">Nome Completo / Nome Fantasia *</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome', $cliente->nome ?? '') }}" required
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        @error('nome') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
    </div>

    <!-- Razão Social (Aparece condicionalmente para PJ) -->
    <div id="campo_razao_social">
        <label for="razao_social" class="block text-sm font-medium text-gray-700">Razão Social</label>
        <input type="text" name="razao_social" id="razao_social" value="{{ old('razao_social', $cliente->razao_social ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        @error('razao_social') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
    </div>
</div>

<div class="border-t border-gray-200 my-6 pt-6">
    <h3 class="text-md font-semibold text-gray-700 mb-4 flex items-center gap-2">
        <i class="fas fa-address-book text-gray-400"></i> Contato e Localização
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Contato Principal -->
        <div>
            <label for="contato_principal" class="block text-sm font-medium text-gray-700">Pessoa de Contato / Focal</label>
            <input type="text" name="contato_principal" id="contato_principal" value="{{ old('contato_principal', $cliente->contato_principal ?? '') }}"
                   placeholder="Ex: Gerente de Qualidade"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- E-mail -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail de Notificação</label>
            <input type="email" name="email" id="email" value="{{ old('email', $cliente->email ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Telefone -->
        <div>
            <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone / Ramal</label>
            <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $cliente->telefone ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Cidade -->
        <div class="md:col-span-2">
            <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
            <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $cliente->cidade ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Estado -->
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado (UF)</label>
            <input type="text" name="estado" id="estado" value="{{ old('estado', $cliente->estado ?? '') }}" maxlength="2" placeholder="Ex: SP"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase">
            @error('estado') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Endereço Completo -->
        <div class="md:col-span-3">
            <label for="endereco_completo" class="block text-sm font-medium text-gray-700">Logradouro / Endereço Técnico</label>
            <textarea name="endereco_completo" id="endereco_completo" rows="2" 
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('endereco_completo', $cliente->endereco_completo ?? '') }}</textarea>
        </div>
    </div>
</div>

<div class="border-t border-gray-200 my-6 pt-6">
    <h3 class="text-md font-semibold text-gray-700 mb-4 flex items-center gap-2">
        <i class="fas fa-gavel text-gray-400"></i> Histórico & Notas de Compliance (Auditoria ISO)
    </h3>
    <div>
        <label for="observacoes_compliance" class="block text-sm font-medium text-gray-700">Observações de Risco ou Governança</label>
        <textarea name="observacoes_compliance" id="observacoes_compliance" rows="3" placeholder="Insira restrições do cliente, criticidade para a ISO 9001, histórico de auditorias internas ou apontamentos de ESG..."
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('observacoes_compliance', $cliente->observacoes_compliance ?? '') }}</textarea>
    </div>
</div>

{{-- Script de Comportamento Dinâmico (PF/PJ) --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectTipo = document.getElementById('tipo_documento');
        const campoRazao = document.getElementById('campo_razao_social');
        const labelNome = document.getElementById('label_nome');

        function ajustarFormulario() {
            if (selectTipo.value === 'cpf') {
                campoRazao.style.display = 'none';
                labelNome.innerText = 'Nome Completo *';
            } else if (selectTipo.value === 'cnpj') {
                campoRazao.style.display = 'block';
                labelNome.innerText = 'Nome Fantasia *';
            } else {
                campoRazao.style.display = 'block';
                labelNome.innerText = 'Nome do Cliente *';
            }
        }

        selectTipo.addEventListener('change', ajustarFormulario);
        ajustarFormulario(); // Executa na carga da página (caso seja edição ou erro de validação)
    });
</script>

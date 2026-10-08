<?php

namespace App\Http\Controllers;

use App\Models\Treinamento;
use App\Models\TreinamentoUsuario;
use App\Models\User;
use App\Http\Requests\StoreTreinamentoUsuarioRequest;
use App\Http\Requests\UpdateTreinamentoUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TreinamentoUsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = TreinamentoUsuario::with(['treinamento', 'usuario']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('treinamento', fn ($t) => $t->where('titulo', 'ilike', "%{$search}%"))
                  ->orWhereHas('usuario', fn ($u) => $u->where('name', 'ilike', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($treinamentoId = $request->input('treinamento_id')) {
            $query->where('treinamento_id', $treinamentoId);
        }

        $participacoes  = $query->latest()->paginate(15)->withQueryString();
        $treinamentos   = Treinamento::orderBy('titulo')->get(['id', 'titulo']);

        return view('cadastros.treinamentos_usuarios.index',
            compact('participacoes', 'treinamentos'));
    }
    public function create()
    {
        $treinamentos = Treinamento::where('status', 'Ativo')->orderBy('titulo')->get();
        $usuarios     = User::orderBy('name')->get();

        return view('cadastros.treinamentos_usuarios.create',
            compact('treinamentos', 'usuarios'));
    }

    public function store(StoreTreinamentoUsuarioRequest $request)
    {
        $data = $request->validated();
        $data = $this->handleCertificado($request, $data);
        $data = $this->calcularValidadeAutomatica($data);

        TreinamentoUsuario::create($data);

        return redirect()->route('treinamentos_usuarios.index')
            ->with('success', 'Participação registrada com sucesso.');
    }

    public function show(TreinamentoUsuario $treinamentosUsuario)
    {
        $treinamentosUsuario->load(['treinamento', 'usuario']);

        return view('cadastros.treinamentos_usuarios.show',
            ['participacao' => $treinamentosUsuario]);
    }

    public function edit(TreinamentoUsuario $treinamentosUsuario)
    {
        $treinamentos = Treinamento::orderBy('titulo')->get();
        $usuarios     = User::orderBy('name')->get();

        return view('cadastros.treinamentos_usuarios.edit', [
            'participacao' => $treinamentosUsuario,
            'treinamentos' => $treinamentos,
            'usuarios'     => $usuarios,
        ]);
    }

   public function update(UpdateTreinamentoUsuarioRequest $request, TreinamentoUsuario $treinamentosUsuario)
    {
        $data = $request->validated();
        $data = $this->handleCertificado($request, $data, $treinamentosUsuario);
        $data = $this->calcularValidadeAutomatica($data);

        $treinamentosUsuario->update($data);

        return redirect()->route('treinamentos_usuarios.index')
            ->with('success', 'Participação atualizada com sucesso.');
    }

    public function destroy(TreinamentoUsuario $treinamentosUsuario)
    {
        if ($treinamentosUsuario->certificado_path) {
            Storage::disk('public')->delete($treinamentosUsuario->certificado_path);
        }

        $treinamentosUsuario->delete();

        return redirect()->route('treinamentos_usuarios.index')
            ->with('success', 'Participação excluída com sucesso.');
    }

    /**
     *  Helpers privados
     */
    private function handleCertificado(Request $request, array $data, ?TreinamentoUsuario $existing = null): array
    {
        if ($request->hasFile('certificado')) {
            if ($existing && $existing->certificado_path) {
                Storage::disk('public')->delete($existing->certificado_path);
            }
            $data['certificado_path'] = $request->file('certificado')->store('certificados', 'public');
        }

        // Não deixa o arquivo entrar no fill
        unset($data['certificado']);

        return $data;
    }

    private function calcularValidadeAutomatica(array $data): array
    {
        if (empty($data['validade_ate']) && !empty($data['data_conclusao']) && !empty($data['treinamento_id'])) {
            $treinamento = Treinamento::find($data['treinamento_id']);
            if ($treinamento && $treinamento->validade_meses) {
                $data['validade_ate'] = Carbon::parse($data['data_conclusao'])
                    ->addMonths((int) $treinamento->validade_meses)
                    ->toDateString();
            }
        }
        return $data;
    }

}
<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SetupController extends Controller
{
    /**
     * Exibe a configuração inicial.
     */
    public function create()
    {
        // Se já existe usuário e empresa,
        // a configuração inicial já foi realizada.
        if (User::exists() || Empresa::exists()) {
            return redirect()->route('login');
        }

        return view('auth.setup');
    }

    /**
     * Grava o primeiro usuário e a primeira empresa.
     */
    public function store(Request $request)
    {
        // Segurança adicional:
        // não permite executar a configuração novamente.
        if (User::exists() || Empresa::exists()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            // Usuário
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required','email','max:255','unique:users,email',],
            'password' => ['required','confirmed','min:8',],
            // Empresa
            'razao_social' => ['required', 'string', 'max:255',],
            'nome_fantasia' => ['nullable', 'string', 'max:255',],
            'cnpj' => ['nullable', 'string', 'max:20', 'unique:empresas,cnpj',],
            'ie' => ['nullable', 'string', 'max:20',],
            'endereco' => ['nullable','string',],
            'cidade' => ['nullable', 'string', 'max:100',],
            'estado' => ['nullable', 'string', 'size:2',],
            'cep' => ['nullable', 'string', 'max:10',],
            'telefone' => ['nullable', 'string', 'max:20',],
            'email_empresa' => ['nullable','email', 'max:255',],
        ]);

        DB::transaction(function () use ($validated) {

        // Primeiro usuário = Administrador
        $user = User::create([
            'codigo' => 'USR-0001',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'administrador',
        ]);

        // Primeira empresa
        $empresa = Empresa::create([
            'codigo' => 'EMP-0001',
            'razao_social' => $validated['razao_social'],
            'nome_fantasia' => $validated['nome_fantasia'] ?? null,
            'cnpj' => $validated['cnpj'] ?? null,
            'ie' => $validated['ie'] ?? null,
            'endereco' => $validated['endereco'] ?? null,
            'cidade' => $validated['cidade'] ?? null,
            'estado' => $validated['estado'] ?? null,
            'cep' => $validated['cep'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'email' => $validated['email_empresa'] ?? null,
            'ativo' => true,
        ]);

            // Vincula o usuário à empresa criada
            $user->empresa_id = $empresa->id;
            $user->save();

            // Autentica o administrador automaticamente
            auth()->login($user);
        });

        return redirect()
            ->route('dashboard')
            ->with('status', 'Sistema configurado com sucesso!');
    }
}
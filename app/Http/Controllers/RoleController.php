<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        // Apenas administradores podem acessar esse controller
       // $this->middleware('role:admin');
    }

    /**
     * Lista todos os usuários com seus papéis e permissões
     */
    public function index()
    {
        $usuarios = User::with('roles', 'permissions')->get();
        return view('cadastro.roles.index', compact('usuarios'));
    }

    /**
     * Tela de edição de papéis e permissões de um usuário
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();

        return view('cadastro.roles.edit', compact('usuario', 'roles', 'permissions'));
    }

    /**
     * Atualiza papéis e permissões de um usuário
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        // Atualiza roles
        $usuario->syncRoles($request->input('roles', []));

        // Atualiza permissions
        $usuario->syncPermissions($request->input('permissions', []));

        return redirect()->route('roles.index')
            ->with('success', 'Papéis e permissões atualizados com sucesso!');
    }
}

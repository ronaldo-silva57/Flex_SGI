<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'acesso_total',
            'acesso_parcial',
            'leitura',
            'criar_nao_conformidade',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $roles = [
            'administrador' => ['acesso_total'],
            'qualidade'     => ['acesso_total'],
            'gerente'       => ['acesso_parcial'],
            'supervisor'    => ['acesso_parcial'],
            'usuario'       => [
                'leitura',
                'criar_nao_conformidade',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($rolePermissions);
        }

        /*
         * Sincroniza o campo users.role com os papéis do Spatie.
         */
        foreach (User::all() as $user) {
            if (
                $user->role &&
                Role::where('name', $user->role)
                    ->where('guard_name', 'web')
                    ->exists()
            ) {
                $user->syncRoles([$user->role]);
            }
        }
    }
}
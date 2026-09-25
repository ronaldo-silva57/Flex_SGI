<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NaoConformidade;

class NaoConformidadePolicy
{
    public function viewAny(User $user)
    {
        return $user->can('leitura');
    }

    public function view(User $user, NaoConformidade $naoConformidade)
    {
        return $user->can('leitura');
    }

    public function create(User $user)
    {
        return $user->can('criar_nao_conformidade');
    }

    public function update(User $user, NaoConformidade $naoConformidade)
    {
        return $user->can('acesso_total');
    }

    public function delete(User $user, NaoConformidade $naoConformidade)
    {
        return $user->can('acesso_total');
    }
}

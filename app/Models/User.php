<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\Auditavel;

//#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, Auditavel, HasRoles;
    //use HasFactory, Notifiable, HasRoles, Auditavel;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $fillable = [
        'codigo',
        'name',
        'email',
        'password',
        'role',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // relacionamento com processos
    public function processosResponsaveis(): HasMany
    {
        return $this->hasMany(Processo::class, 'responsavel_id');
    }

    /**
     * Verifica se o usuário possui determinado nível.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Verifica se o usuário possui um dos níveis informados.
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    /**
     * Verifica se o usuário é administrador.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'administrador';
    }

    public function treinamentosParticipacoes(): HasMany
    {
        return $this->hasMany(TreinamentoUsuario::class, 'usuario_id');
    }

    /**
     * Competencias
     */
    public function competencias(): BelongsToMany
    {
        return $this->belongsToMany(Competencia::class, 'usuario_competencias')
                    ->withPivot(['nivel_atual', 'data_obtencao', 'validade', 'observacoes'])
                    ->withTimestamps();
    }

    public function comunicacoesLidas(): BelongsToMany
    {
        return $this->belongsToMany(ComunicacaoInterna::class, 'comunicacao_leituras', 'user_id', 'comunicacao_id')
                    ->using(ComunicacaoLeitura::class)
                    ->withPivot(['id', 'lido_em']);
    }
}

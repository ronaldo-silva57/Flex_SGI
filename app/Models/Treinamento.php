<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditavel;

class Treinamento extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'titulo',
        'descricao',
        'conteudo',
        'carga_horaria',
        'tipo',
        'validade_meses',
        'status',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'treinamentos_usuarios', 'treinamento_id', 'usuario_id')
                    ->withPivot(['id', 'data_conclusao', 'validade_ate', 'nota', 'certificado_path', 'status'])
                    ->withTimestamps()
                    ->whereNull('treinamentos_usuarios.deleted_at');
    }

    public function participacoes(): HasMany
    {
        return $this->hasMany(TreinamentoUsuario::class, 'treinamento_id');
    }
}
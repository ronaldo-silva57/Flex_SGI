<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditavel;

class Projeto extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'projetos';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'codigo',
        'nome',
        'descricao',
        'data_inicio',
        'data_fim_prevista',
        'data_fim_real',
        'status',
        'progresso_percentual',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim_prevista' => 'date',
        'data_fim_real' => 'date',
        'progresso_percentual' => 'integer',
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

    public function tarefas(): HasMany
    {
        return $this->hasMany(ProjetoTarefa::class, 'projeto_id');
    }
}

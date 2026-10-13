<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class ProjetoTarefa extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'projeto_tarefas';

    protected $fillable = [
        'projeto_id',
        'responsavel_id',
        'titulo',
        'descricao',
        'status_kanban',
        'prioridade',
        'data_inicio',
        'data_vencimento',
        'ordem',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_vencimento' => 'date',
        'ordem' => 'integer',
    ];

    /**
     * Relacionamentos
     */
    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projeto::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}

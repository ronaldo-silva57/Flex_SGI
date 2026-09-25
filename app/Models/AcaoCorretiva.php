<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class AcaoCorretiva extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'acoes_corretivas';

    protected $fillable = [
        'nao_conformidade_id', 'responsavel_id', 'etapa', 'descricao',
        'prazo', 'data_execucao', 'eficaz', 'evidencia', 'status',
    ];

    protected $casts = [
        'prazo'         => 'date',
        'data_execucao' => 'date',
        'eficaz'        => 'boolean',
    ];

    /**
     * Relacionamentos
     */

    public function naoConformidade(): BelongsTo
    {
        return $this->belongsTo(NaoConformidade::class, 'nao_conformidade_id');
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}

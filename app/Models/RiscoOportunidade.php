<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class RiscoOportunidade extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'riscos_oportunidades';

    protected $fillable = [
        'empresa_id',
        'processo_id',
        'responsavel_id',
        'tipo',
        'descricao',
        'causa',
        'consequencia',
        'probabilidade',
        'impacto',
        'tratamento',
        'plano_acao',
        'prazo',
        'status',
        'evidencia',
    ];

    protected $casts = [
        'prazo'         => 'date',
        'probabilidade' => 'integer',
        'impacto'       => 'integer',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    } 

    public function processo(): BelongsTo
    {
        return $this->belongsTo(Processo::class, 'processo_id');
    }

    public function responsavel(): BelongsTo
        {
            return $this->belongsTo(User::class, 'responsavel_id');
        }
}

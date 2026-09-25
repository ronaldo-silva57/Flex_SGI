<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class PerigoRisco extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'perigos_riscos';

    protected $fillable = [
        'empresa_id',
        'processo_id',
        'responsavel_id',
        'descricao_perigo',
        'risco_associado',
        'exposicao',
        'probabilidade',
        'severidade',
        'medida_controle',
        'necessita_acao',
        'status',
    ];

    protected $casts = [
        'probabilidade' => 'integer',
        'severidade' => 'integer',
        'necessita_acao' => 'boolean',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function processo(): BelongsTo
    {
        return $this->belongsTo(Processo::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}

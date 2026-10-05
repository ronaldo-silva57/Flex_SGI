<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class AvaliacaoFornecedor extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'avaliacoes_fornecedores';

    protected $fillable = [
        'empresa_id',
        'fornecedor_id',
        'avaliador_id',
        'periodo_referencia',
        'nota_qualidade',
        'nota_prazo',
        'nota_atendimento',
        'nota_esg_ambiental',
        'nota_final',
        'status_qualificacao',
        'observacoes',
        'plano_acao_exigido',
    ];

    protected $casts = [
        'nota_qualidade'     => 'float',
        'nota_prazo'         => 'float',
        'nota_atendimento'   => 'float',
        'nota_esg_ambiental' => 'float',
        'nota_final'         => 'float',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function avaliador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'avaliador_id');
    }
}

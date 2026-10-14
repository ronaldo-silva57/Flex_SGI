<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;
use App\Models\Empresa;
use App\Models\User;

class EsgProjetoSocial extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'esg_projetos_sociais';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'nome_projeto',
        'descricao',
        'localidade',
        'data_inicio',
        'data_fim',
        'orcamento_investido',
        'beneficiarios_diretos',
        'status',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'orcamento_investido' => 'decimal:6',
        'beneficiarios_diretos' => 'integer',
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
}

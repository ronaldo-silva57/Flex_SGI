<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Empresa;
use App\Models\Fornecedor;
use App\Models\User;
use App\Traits\Auditavel;

class ProdutoQuimico extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'produtos_quimicos';

    public const ESTADOS_FISICOS = ['Sólido', 'Líquido', 'Gasoso', 'Pastoso', 'Outros'];

    public const STATUS_ATIVO = 'Ativo';
    public const STATUS_INATIVO = 'Inativo';
    public const STATUS_DESCONTINUADO = 'Descontinuado';

    protected $fillable = [
        'empresa_id',
        'fornecedor_id',
        'responsavel_id',
        'nome',
        'fabricante',
        'numero_fispq',
        'numero_cas',
        'estado_fisico',
        'composicao',
        'perigos_ghs',
        'palavra_advertencia',
        'pictogramas',
        'primeiros_socorros',
        'combate_incendio',
        'medidas_derramamento',
        'manuseio_armazenamento',
        'epi_necessario',
        'epc_necessario',
        'localizacao',
        'quantidade_estoque',
        'unidade_medida',
        'data_validade',
        'arquivo_fispq_path',
        'status',
    ];

    protected $casts = [
        'quantidade_estoque' => 'decimal:3',
        'data_validade' => 'date',
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

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    /**
     * Scopes
     */

    public function scopeAtivos($query)
    {
        return $query->where('status', self::STATUS_ATIVO);
    }

    public function scopeVencidos($query)
    {
        return $query->where('data_validade', '<', now()->toDateString());
    }
}
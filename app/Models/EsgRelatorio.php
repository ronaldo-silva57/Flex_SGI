<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;
use App\Models\Empresa;
use App\Models\User;

class EsgRelatorio extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table ='esg_relatorios';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'titulo',
        'framework',
        'ano_referencia',
        'status',
        'data_publicacao',
        'arquivo_path',
        'observacoes',
    ];

    protected $casts = [
        'ano_referencia'    => 'integer',
        'data_publicacao'   => 'date',
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

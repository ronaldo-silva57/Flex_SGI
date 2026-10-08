<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class SoaControle extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'soa_controles';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'codigo_anexo_a',
        'dominio',
        'titulo',
        'descricao',
        'aplicavel',
        'justificativa_inclusao',
        'justificativa_exclusao',
        'status_implementacao',
        'evidencia',
        'controle_id',
    ];

    protected $casts = [
        'aplicavel' => 'boolean',
    ];

    /**
     * Relacionamentos
     */

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function controle(): BelongsTo
    {
        return $this->belongsTo(ControleSeguranca::class, 'controle_id');
    }

    public function controleSeguranca(): BelongsTo
    {
        return $this->belongsTo(ControleSeguranca::class, 'controle_id');
    }
}

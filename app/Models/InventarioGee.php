<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class InventarioGee extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'inventario_gee';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'codigo',
        'ano_referencia',
        'escopo',
        'categoria',
        'fonte_emissao',
        'quantidade',
        'unidade',
        'fator_emissao',
        'emissao_tco2e',
        'metodologia',
        'referencia_fator',
        'evidencia',
        'status',
    ];

    protected $casts = [
        'ano_referencia' => 'integer',
        'quantidade'     => 'decimal:3',
        'fator_emissao'  => 'decimal:6',
        'emissao_tco2e'  => 'decimal:6',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}

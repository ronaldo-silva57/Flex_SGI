<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class CipaReuniao extends Model
{
use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'cipa_reunioes';

    protected $fillable = [
        'empresa_id',
        'presidente_id',
        'secretario_id',
        'gestao_ano',
        'tipo',
        'data_reuniao',
        'pauta_principal',
        'pauta_detalhada',
        'deliberacoes',
        'ata_arquivo_path',
        'status',
    ];

    protected $casts = [
        'data_reuniao' => 'date',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function presidente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'presidente_id');
    }

    public function secretario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'secretario_id');
    }
}

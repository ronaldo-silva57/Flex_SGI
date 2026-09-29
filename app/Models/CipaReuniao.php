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
        'presidida_por_id',
        'secretariada_por_id',
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
        return $this->belongsTo(Empresa::class);
    }

    public function presidente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'presidida_por_id');
    }

    public function secretario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'secretariada_por_id');
    }
}

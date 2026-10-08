<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class Calibracao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'calibracoes';

    protected $fillable = [
        'equipamento_id',
        'responsavel_id',
        'data_calibracao',
        'data_validade',
        'laboratorio',
        'certificado_numero',
        'certificado_path',
        'resultado',
        'observacoes',
    ];

    protected $casts = [
        'data_calibracao' => 'date',
        'data_validade'   => 'date',
    ];

    /**
     * Relacionamentos
     */
    public function equipamento(): BelongsTo
    {
        return $this->belongsTo(EquipamentoMedicao::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function estaVencida(): bool
    {
        return $this->data_validade?->isPast() ?? false;
    }
}

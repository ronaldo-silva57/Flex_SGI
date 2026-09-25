<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class AuditoriaItem extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'auditorias_itens';

    protected $fillable = [
        'auditoria_id',
        'clausula_id',
        'processo_id',
        'auditor_id',
        'descricao_verificacao',
        'evidencia_coletada',
        'conformidade',
        'observacoes',
    ];

    /**
     * Relacionamentos
     */
    public function auditoria(): BelongsTo
    {
        return $this->belongsTo(Auditoria::class);
    }

    public function clausula(): BelongsTo
    {
        return $this->belongsTo(Clausula::class);
    }

    public function processo(): BelongsTo
    {
        return $this->belongsTo(Processo::class);
    }

    public function auditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Empresa;
use App\Traits\Auditavel;

class EsgGovernancaMembro extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'esg_governanca_membros';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'nome',
        'orgao',
        'cargo',
        'independente',
        'inicio_mandato',
        'fim_mandato',
        'ativo',
    ];

    protected $casts = [
        'independente'      => 'boolean',
        'inicio_mandato'    => 'date',
        'fim_mandato'       => 'date',
        'ativo'             => 'boolean'
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

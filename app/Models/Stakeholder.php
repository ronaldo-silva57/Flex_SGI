<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class Stakeholder extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'stakeholders';

    protected $fillable = [
        'empresa_id',
        'nome',
        'tipo',
        'contato',
        'expectativas',
        'necessidades',
        'prioridade',
        'ativo',
    ];

    protected $casts = [
        'prioridade' => 'integer',
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamentos
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    // Escopos
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopePrioridade($query, $nivel)
    {
        return $query->where('prioridade', $nivel);
    }
}

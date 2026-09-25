<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class Auditoria extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $fillable = [
        'empresa_id',
        'norma_id',
        'auditor_lider_id',
        'tipo',
        'escopo',
        'objetivo',
        'data_inicio',
        'data_fim',
        'status',
        'relatorio',
    ];

    protected $casts = [
        'data_inicio'   => 'date',
        'data_fim'      => 'date',
    ];

    /**
     * Relacionamentos
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function norma()
    {
        return $this->belongsTo(Norma::class);
    }

    public function auditorLider()
    {
        return $this->belongsTo(User::class, 'auditor_lider_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class IncidenteSeguranca extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'incidentes_seguranca';

    protected $fillable = [
        'empresa_id',
        'ativo_id',
        'responsavel_id',
        'data_ocorrencia',
        'tipo',
        'descricao',
        'impacto',
        'acao_imediata',
        'investigacao',
        'status',
    ];

    protected $casts = [
        'data_ocorrencia' => 'datetime',
    ];

    /**
     * Relacionamentos
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function ativo()
    {
        return $this->belongsTo(AtivoInformacao::class, 'ativo_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}
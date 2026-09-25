<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class ControleSeguranca extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'controles_seguranca';

    protected $fillable = [
        'empresa_id',
        'ativo_id',
        'codigo_anexo_a',
        'titulo',
        'descricao',
        'implementado',
        'evidencia',
        'responsavel_id',
        'data_implementacao',
    ];

    protected $casts = [
        'implementado' => 'boolean',
        'data_implementacao' => 'date',
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
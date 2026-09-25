<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class AtivoInformacao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'ativos_informacao';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'nome',
        'descricao',
        'tipo',
        'localizacao',
        'proprietario_id',
        'classificacao',
        'valor',
        'status',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
    ];

    /**
     * Relacionamentos
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function proprietario()
    {
        return $this->belongsTo(User::class, 'proprietario_id');
    }

    public function controles()
    {
        return $this->hasMany(ControleSeguranca::class, 'ativo_id');
    }

    public function incidentes()
    {
        return $this->hasMany(IncidenteSeguranca::class, 'ativo_id');
    }
}
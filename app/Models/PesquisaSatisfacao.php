<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class PesquisaSatisfacao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'pesquisas_satisfacao';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'responsavel_id',
        'codigo',
        'titulo',
        'descricao',
        'tipo',
        'canal',
        'data_inicio',
        'data_fim',
        'status',
        'nota_media',
        'total_respostas',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim'    => 'date',
    ];

    /**
     * Relacionamentos
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
    
    public function respostas()
    {
        return $this->hasMany(PesquisaSatisfacaoResposta::class, 'pesquisa_id');
    }
}
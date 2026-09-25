<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnaliseCausaResposta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'analise_causa_respostas';

    protected $fillable = [
        'analise_causa_id', 
        'ordem', 
        'pergunta', 
        'resposta',
        'evidencia', 
        'eh_causa_raiz',
    ];

    protected $casts = [
        'eh_causa_raiz' => 'boolean',
        'ordem'         => 'integer',
    ];

    /**
     * Relacionamentos
     */

    public function analiseCausa() 
    { 
        return $this->belongsTo(AnaliseCausa::class); 
    }
}
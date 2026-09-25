<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IshikawaCausa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ishikawa_causas';

    protected $fillable = [
        'analise_ishikawa_id', 
        'responsavel_validacao_id', 
        'categoria',
        'descricao', 
        'evidencia', 
        'confirmada', 
        'causa_raiz',
    ];

    protected $casts = [
        'confirmada' => 'boolean',
        'causa_raiz' => 'boolean',
    ];

    /**
     * Relacionamentos
     */

    public function analiseIshikawa()      
    { 
        return $this->belongsTo(AnaliseIshikawa::class); 
    }

    public function responsavelValidacao() 
    { 
        return $this->belongsTo(User::class, 'responsavel_validacao_id'); 
    }
}
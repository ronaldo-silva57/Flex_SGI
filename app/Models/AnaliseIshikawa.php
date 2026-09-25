<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnaliseIshikawa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'analises_ishikawa';

    protected $fillable = [
        'analise_causa_id', 
        'responsavel_id', 
        'efeito_analisado',
        'conclusao', 
        'data_inicio', 
        'data_conclusao',
    ];

    protected $casts = [
        'data_inicio'    => 'date',
        'data_conclusao' => 'date',
    ];

    /**
     * Relacionamentos
     */

    public function analiseCausa() 
    { 
        return $this->belongsTo(AnaliseCausa::class); 
    }

    public function responsavel()  
    { 
        return $this->belongsTo(User::class, 'responsavel_id'); 
    }

    public function causas()       
    { 
        return $this->hasMany(IshikawaCausa::class); 
    }
}
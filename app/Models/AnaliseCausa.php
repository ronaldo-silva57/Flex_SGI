<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnaliseCausa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'analises_causa';

    protected $fillable = [
        'nao_conformidade_id', 
        'responsavel_id', 
        'metodo', 
        'status',
        'objetivo', 
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

    public function naoConformidade() 
	{
		return $this->belongsTo(NaoConformidade::class); 
	}
	
    public function responsavel()     
	{ 
		return $this->belongsTo(User::class, 'responsavel_id'); 
	}
	
    public function respostas()       
	{ 
		return $this->hasMany(AnaliseCausaResposta::class); 
	}
	
    public function ishikawa()        
	{ 
		return $this->hasOne(AnaliseIshikawa::class); 
	}
}
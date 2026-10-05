<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class MudancaGestao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'mudancas_gestao';

    protected $fillable = [
        'empresa_id', 'solicitante_id', 'responsavel_aprovacao_id', 'processo_id',
        'codigo', 'titulo', 'tipo',
        'descricao_mudanca', 'justificativa',
        'impacto_qualidade', 'impacto_ambiental', 'impacto_sso', 'impacto_seguranca_informacao',
        'data_prevista', 'data_implementacao',
        'status', 'parecer_aprovacao',
    ];

    protected $casts = [
        'data_prevista'      => 'date',
        'data_implementacao' => 'date',
    ];

    public function empresa(): BelongsTo              
    { 
        return $this->belongsTo(Empresa::class); 
    }

    public function solicitante(): BelongsTo          
    { 
        return $this->belongsTo(User::class, 'solicitante_id'); 
    }

    public function responsavelAprovacao(): BelongsTo 
    { 
        return $this->belongsTo(User::class, 'responsavel_aprovacao_id'); 
    }
    
    public function processo(): BelongsTo             
    { 
        return $this->belongsTo(Processo::class); 
    }
}
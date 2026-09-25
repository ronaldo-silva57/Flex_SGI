<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class AspectoAmbiental extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'aspectos_ambientais';

    protected $fillable = [
        'empresa_id',
        'processo_id',
        'responsavel_id',
        'descricao',
        'tipo',
        'impacto_associado',
        'significancia',
        'controle_existente',
        'programa_gestao',
        'status',
    ];

    protected $casts = [
        'significancia' => 'integer',
    ];

    /**
     * Relaconamentos
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}
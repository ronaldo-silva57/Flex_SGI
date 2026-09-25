<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditavel;

class IndicadorAmbiental extends Model
{
    use  HasFactory, SoftDeletes, Auditavel;

    protected $table = 'indicadores_ambientais';
    
    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'codigo',
        'nome',
        'descricao',
        'categoria',
        'formula',
        'meta',
        'unidade_medida',
        'frequencia',
        'tipo_meta',
        'ativo',
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

    public function monitoramentos()
    {
        return $this->hasMany(MonitoramentoAmbiental::class);
    }
}

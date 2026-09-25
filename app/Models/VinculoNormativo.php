<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditavel;

class VinculoNormativo extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'vinculos_normativos';

    protected $fillable = [
        'norma_id',
        'clausula_id',
        'processo_id',
        'documento_id',
        'indicador_id',
        'risco_id',
        'requisito_legal_id',
        'esg_indicador_id',
        'observacao',
    ];

    /**
     * Relacionamentos
     */
    public function norma()
    {
        return $this->belongsTo(Norma::class);
    }

    public function clausula()
    {
        return $this->belongsTo(Clausula::class);
    }

    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function indicador()
    {
        return $this->belongsTo(Indicador::class);
    }

    public function risco()
    {
        return $this->belongsTo(RiscoOportunidade::class, 'risco_id');
    }

    public function requisitoLegal()
    {
        return $this->belongsTo(RegistroLegal::class, 'requisito_legal_id');
    }

    public function esgIndicador()
    {
        return $this->belongsTo(EsgIndicador::class);
    }
}

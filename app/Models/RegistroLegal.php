<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class RegistroLegal extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'registros_legais';

    protected $fillable = [
        'empresa_id',
        'norma_id',
        'numero',
        'orgao',
        'descricao',
        'tipo',
        'data_publicacao',
        'data_vigencia',
        'status',
        'arquivo_path',
    ];

    protected $casts = [
        'data_publicacao' => 'date',
        'data_vigencia'   => 'date',
    ];

    /**
     * Relacionamentos
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function norma()
    {
        return $this->belongsTo(Norma::class);
    }
}
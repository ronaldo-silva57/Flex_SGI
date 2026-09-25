<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class Documento extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'documentos';

    protected $fillable = [
        'empresa_id',
        'processo_id',
        'norma_id',
        'responsavel_id',
        'codigo',
        'titulo',
        'tipo',
        'versao',
        'conteudo',
        'arquivo_path',
        'status',
        'data_aprovacao',
        'data_revisao',  
    ];

    protected $casts = [
        'data_aprovacao' => 'date',
        'data_revisao' => 'date',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function processo(): BelongsTo
    {
        return $this->belongsTo(Processo::class);
    }

    public function norma(): BelongsTo
    {
        return $this->belongsTo(Norma::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}

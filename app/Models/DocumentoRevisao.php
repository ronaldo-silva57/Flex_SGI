<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class DocumentoRevisao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'documento_revisoes';

    protected $fillable = [
        'documento_id',
        'versao',
        'alteracoes_realizadas',
        'responsavel_id',
        'arquivo_path',
        'data_revisao',
    ];

    protected $casts = [
        'data_revisao' => 'datetime',
    ];

    /**
     * Relacionamentos
     */
    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}

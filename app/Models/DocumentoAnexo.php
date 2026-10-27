<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class DocumentoAnexo extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'documento_anexos';

    protected $fillable = [
        'documento_id',
        'nome_arquivo',
        'arquivo_path',
        'usuario_id',
    ];

    /**
     * Relacionamentos
     */
    protected function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);
    }

    protected function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

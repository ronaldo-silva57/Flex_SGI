<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class DocumentoAprovacao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'documento_aprovacoes';

    protected $fillable = [
        'documento_id',
        'aprovador_id',
        'status',
        'observacoes',
    ];

    /**
     * Relacionamentos
     */
    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);
    }

    public function aprovador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprovador_id');
    }
}

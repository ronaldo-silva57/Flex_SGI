<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class DocumentoLeitura extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'documento_leituras';

    protected $fillable = [
        'documento_id',
        'usuario_id',
        'data_leitura',
        'ip_address',
    ];

    protected $casts = [
        'data_leitura' => 'datetime',
    ];

    /**
     * Relacionamentos
     */

    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

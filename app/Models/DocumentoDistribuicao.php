<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class DocumentoDistribuicao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'documento_distribuicoes';

    protected $fillable = [
        'documento_id',
        'usuario_id',
        'departamento_id',
        'obrigatorio',
        'data_distribuicao',
    ];

    protected $casts = [
        'obrigatorio'       => 'boolean',
        'data_distribuicao' => 'datetime',
    ];

    /**
     * Relacionamento
     */
    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::Class);
    }
}

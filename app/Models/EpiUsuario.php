<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class EpiUsuario extends Model
{
    use HasFactory, SoftDeletes, Auditavel;
    
    protected $table = 'epis_usuarios';

    protected $fillable = [
        'epi_id',
        'usuario_id',
        'data_entrega',
        'data_vencimento',
        'quantidade',
        'responsavel_entrega_id',
        'status',
    ];

    protected $casts = [
        'data_entrega' => 'date',
        'data_vencimento' => 'date',
        'quantidade' => 'integer',
    ];

    /**
     * Relacionamentos
     */
    public function epi(): BelongsTo
    {
        return $this->belongsTo(Epi::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function responsavelEntrega(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_entrega_id');
    }
}

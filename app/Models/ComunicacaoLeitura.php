<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class ComunicacaoLeitura extends Model
{
use HasFactory, Auditavel;

    public $timestamps = false;

    protected $table = 'comunicacao_leituras';

    protected $fillable = [
        'comunicacao_id',
        'user_id',
        'lido_em',
    ];

    protected $casts = [
        'lido_em' => 'datetime',
    ];

    /**
     * Relacionamentos
     */
    public function comunicacao(): BelongsTo
    {
        return $this->belongsTo(ComunicacaoInterna::class, 'comunicacao_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

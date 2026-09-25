<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoAlteracao extends Model
{
    protected $table = 'historico_alteracoes';

    /**
     * A tabela possui apenas created_at (sem updated_at).
     */
    public $timestamps = false;

    protected $fillable = [
        'tabela',
        'registro_id',
        'acao',
        'dados_anteriores',
        'dados_novos',
        'usuario_id',
        'ip_address',
    ];

    protected $casts = [
        'dados_anteriores' => 'array',
        'dados_novos'      => 'array',
        'created_at'       => 'datetime',
    ];

    /**
     * Usuário que realizou a alteração.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Rótulo legível da ação.
     */
    public function getAcaoLabelAttribute(): string
    {
        return match ($this->acao) {
            'insert' => 'Inserção',
            'update' => 'Atualização',
            'delete' => 'Exclusão',
            default  => ucfirst($this->acao),
        };
    }
}
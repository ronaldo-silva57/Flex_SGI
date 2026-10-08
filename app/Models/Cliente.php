<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'empresa_id',
        'tipo_documento',
        'documento',
        'nome',
        'razao_social',
        'contato_principal',
        'email',
        'telefone',
        'cidade',
        'estado',
        'endereco_completo',
        'status',
        'observacoes_compliance',
    ];

    /**
     * Relacionamento
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}

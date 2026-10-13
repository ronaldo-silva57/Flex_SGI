<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class UsuarioCompetencia extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'usuario_competencias';

    protected $fillable = [
        'user_id',
        'competencia_id',
        'nivel_atual',
        'data_obtencao',
        'validade',
        'observacoes',
    ];

    protected $casts = [
        'data_obtencao' => 'date',
        'validade' => 'date',
    ];

    /**
     * Relacionamentos
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function competencia(): BelongsTo
    {
        return $this->belongsTo(Competencia::class);
    }
}

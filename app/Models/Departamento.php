<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditavel;

class Departamento extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $fillable = [
        'codigo',
        'empresa_id',
        'nome',
        'descricao',
        'responsavel_id',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class); 
    }

    public function responsabel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function processos(): HasMany
    {
        return $this->hasMany(Processo::class, 'departamento_id');
    }
}

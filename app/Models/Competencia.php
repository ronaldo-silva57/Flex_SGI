<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\Auditavel;

class Competencia extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'competencias';

    protected $fillable = [
        'empresa_id',
        'codigo',
        'nome',
        'descricao',
        'tipo',
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

    public function cargos(): BelongsToMany
    {
        return $this->belongsToMany(
            Cargo::class,
            'cargo_competencia',
            'competencia_id',
            'cargo_id'
        )
        ->withPivot('nivel_exigido')
        ->withTimestamps()
        ->wherePivotNull('deleted_at');
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'usuario_competencias')
                    ->withPivot(['nivel_atual', 'data_obtencao', 'validade', 'observacoes'])
                    ->withTimestamps();
    }
}

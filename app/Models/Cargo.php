<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\Auditavel;

class Cargo extends Model
{
    use HasFactory, SoftDeletes, Auditavel;
    
    protected $table = 'cargos';

    protected $fillable = [
        'empresa_id',
        'departamento_id',
        'codigo',
        'nome',
        'descricao',
        'requisitos',
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

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    public function competencias(): BelongsToMany
    {
        return $this->belongsToMany(
            Competencia::class,
            'cargo_competencia',
            'cargo_id',
            'competencia_id'
        )
        ->withPivot('nivel_exigido')
        ->withTimestamps()
        ->wherePivotNull('deleted_at');
    }

}

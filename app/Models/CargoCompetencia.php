<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Traits\Auditavel;

class CargoCompetencia extends Model
{
    use HasFactory, SoftDeletes, Auditavel;
   
    protected $table = 'cargo_competencia';

    protected $fillable = [
        'cargo_id',
        'competencia_id',
        'nivel_exigido',
    ];

    public $incrementing = true; 

    /**
     * Relacionamentos
     */
    public function cargos(): BelongsToMany
    {
        return $this->belongsToMany(
            Cargo::class,
            'cargo_competencia',
            'competencia_id',
            'cargo_id'
        )->withPivot('nivel_exigido')
        ->withTimestamps();
    }

    public function competencia(): BelongsTo
    {
        return $this->belongsTo(Competencia::class);
    }
}
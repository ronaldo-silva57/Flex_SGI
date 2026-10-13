<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class CalendarioEvento extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'calendario_eventos';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'titulo',
        'descricao',
        'data_inicio',
        'data_fim',
        'dia_inteiro',
        'categoria',
        'cor',
        'status',
    ];

    protected $casts = [
        'data_inicio'   => 'datetime',
        'data_fim'      => 'datetime',
        'dia_inteiro'   => 'boolean',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}

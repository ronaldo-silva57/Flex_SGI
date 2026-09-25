<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class ReuniaoGestao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'reunioes_gestao';

    protected $fillable = [
        'empresa_id',
        'responsavel_id',
        'data_reuniao',
        'tipo',
        'pauta',
        'decisoes',
        'acoes_definidas',
        'proxima_reunião',
        'ata',
    ];

    protected $casts = [
        'data_reuniao' => 'date',
        'proxima_reuniao' => 'date',
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

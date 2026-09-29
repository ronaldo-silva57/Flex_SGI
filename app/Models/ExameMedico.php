<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class ExameMedico extends Model
{
use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'exames_medicos';

    protected $fillable = [
        'empresa_id',
        'usuario_id',
        'medico_examinador_id',
        'tipo_aso',
        'data_realizacao',
        'data_vencimento',
        'resultado',
        'restricoes',
        'crm_medico',
        'medico_nome',
        'arquivo_aso_path',
        'status',
    ];

    protected $casts = [
        'data_realizacao' => 'date',
        'data_vencimento' => 'date',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function medicoExaminador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'medico_examinador_id');
    }
}

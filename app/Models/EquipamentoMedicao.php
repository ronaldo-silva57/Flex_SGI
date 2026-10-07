<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditavel;
use App\Models\Empresa;
use App\Models\User;

class EquipamentoMedicao extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'equipamentos_medicao';

    protected $fillable = [
        'empresa_id', 
        'responsavel_id', 
        'codigo', 
        'nome', 
        'marca', 
        'modelo',
        'numero_serie', 
        'faixa_medicao', 
        'resolucao', 
        'localizacao',
        'periodicidade_calibracao_meses', 
        'ultima_calibracao',
        'proxima_calibracao', 
        'status',
    ];

    protected $casts = [
        'ultima_calibracao'  => 'date',
        'proxima_calibracao' => 'date',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function calibracoes(): HasMany
    {
        return $this->hasMany(Calibracao::class, 'equipamento_id')->orderByDesc('data_calibracao');
    }

    public function ultimaCalibracaoRegistrada(): ?Calibracao
    {
        return $this->calibracoes()->first();
    }

    public function scopeDaEmpresa($q, $empresaId = null)
    {
        return $q->where('empresa_id', $empresaId ?? auth()->user()->empresa_id);
    }

    public function getDiasParaProximaCalibracaoAttribute(): ?int
    {
        return $this->proxima_calibracao
            ? now()->startOfDay()->diffInDays($this->proxima_calibracao, false)
            : null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;
use Carbon\Carbon;

class TreinamentoUsuario extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'treinamentos_usuarios';

    protected $fillable = [
        'treinamento_id',
        'usuario_id',
        'data_conclusao',
        'validade_ate',
        'nota',
        'certificado_path',
        'status',
    ];

    protected $casts = [
        'data_conclusao' => 'date',
        'validade_ate' => 'date',
        'nota' => 'decimal:2',
    ];

    /**
     * Relacionamentos
     */
    public function treinamento(): BelongsTo
    {
        return $this->belongsTo(Treinamento::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Helpers / Accessors
     */
    //Verifica se o registro está vencido com base na valodade_ate
    public function getEstaVencidoAttribute(): bool
    {
        return $this->validade_ate && $this->validade_ate->isPast();
    }

    /**
     * Calcula automaticamente a validade a partir do treinamento.
     */
    public function calcularValidade(): ?Carbon
    {
        if (!$this->data_conclusao) {
            return null;
        }

        $treinamento = $this->treinamento ?? Treinamento::find($this->treinamento_id);

        if ($treinamento && $treinamento->validade_meses) {
            return Carbon::parse($this->data_conclusao)
                ->addMonths((int) $treinamento->validade_meses);
        }

        return null;
    }

    /**
     * Badge de cor para a view conforme status.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Concluído'    => 'bg-green-100 text-green-800',
            'Em andamento' => 'bg-blue-100 text-blue-800',
            'Vencido'      => 'bg-red-100 text-red-800',
            default        => 'bg-yellow-100 text-yellow-800',
        };
    }
}
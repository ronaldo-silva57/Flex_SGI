<?php

namespace App\Models;

use App\Models\Empresa;
use App\Models\Processo;
use App\Models\User;
use App\Traits\Auditavel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestaoResiduo extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'gestao_residuos';

    public const CLASSES = ['Classe I', 'Classe II-A', 'Classe II-B'];

    public const TIPOS = [
        'Reciclável', 'Não reciclável', 'Perigoso', 'Inerte', 'Orgânico', 'Outros',
    ];

    public const FREQUENCIAS = [
        'Diária', 'Semanal', 'Mensal', 'Trimestral', 'Semestral', 'Anual', 'Esporádica',
    ];

    public const DESTINOS = [
        'Reutilização', 'Reciclagem', 'Coprocessamento', 'Aterro Industrial',
        'Aterro Sanitário', 'Incineração', 'Compostagem', 'Outros',
    ];

    public const STATUS_ATIVO   = 'Ativo';
    public const STATUS_INATIVO = 'Inativo';

    protected $fillable = [
        'empresa_id',
        'processo_id',
        'responsavel_id',
        'codigo',
        'descricao',
        'classe',
        'tipo',
        'fonte_geradora',
        'quantidade_gerada',
        'unidade_medida',
        'frequencia_geracao',
        'forma_armazenamento',
        'destino_final',
        'transportador',
        'destinador',
        'numero_mtr',
        'observacoes',
        'status',
    ];

    protected $casts = [
        'quantidade_gerada' => 'decimal:3',

    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function processo(): BelongsTo
    {
        return $this->belongsTo(Processo::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    /**
     * Scopes
     */
    public function scopeAtivos($query)
    {
        return $query->where('status', self::STATUS_ATIVO);
    }

    public function scopePerigosos($query)
    {
        return $query->where('classe', 'Classe I');
    }

    public function scopeDaEmpresa($query, int $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }
}

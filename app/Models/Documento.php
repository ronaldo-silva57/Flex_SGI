<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditavel;

class Documento extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'documentos';

    protected $fillable = [
        'empresa_id',
        'processo_id',
        'norma_id',
        'responsavel_id',
        'codigo',
        'titulo',
        'tipo',
        'versao',
        'conteudo',
        'arquivo_path',
        'status',
        'data_aprovacao',
        'data_revisao',  
    ];

    protected $casts = [
        'data_aprovacao'    => 'date',
        'data_revisao'      => 'date',
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

    public function norma(): BelongsTo
    {
        return $this->belongsTo(Norma::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function revisoes(): HasMany
    {
        return $this->hasMany(DocumentoRevisao::class)->orderByDesc('data_revisao');
    }

    public function aprovacoes(): HasMany
    {
        return $this->hasMany(DocumentoAprovacao::class);
    }

    public function distribuicoes(): HasMany
    {
        return $this->hasMany(DocumentoDistribuicao::class);
    }

    public function leituras(): HasMany
    {
        return $this->hasMany(DocumentoLeitura::class);
    }

    public function anexos(): HasMany
    {
        return $this->hasMany(DocumentoAnexo::class);
    }

    /**
     * Helpers de workflw
     */
    public function podeSerAprovado(): bool
    {
        return $this->aprovacoes()->where('status', 'Pendente')->count() === 0
            && $this->aprocacoes()->where('status', 'Rejeitado')->count() === 0
            && $this->aprocacoes()->count() > 0;
    }

    public function estaAprovado(): bool
    {
        return $this->status === 'Aprovado';
    }

    public function proximaVersao(): string
    {
        [$maior, $menor] = array_pad(explode('.', $this->versao), 2, 0);
        return $maior . '.' . ((int)$menor + 1);
    }
}

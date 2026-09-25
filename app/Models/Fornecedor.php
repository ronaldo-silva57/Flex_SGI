<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class Fornecedor extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'fornecedores';

    protected $fillable = [
        'codigo',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'contato_nome',
        'contato_email',
        'contato_telefone',
        'endereco',
        'categoria',
        'avaliacao_risco',
        'ativo',
    ];

    protected $casts = [
        'ativo'             => 'boolean',
        'avaliacao_risco'   => 'integer',
    ];

    /**
     * Relacionamentos
     */

    //Escopo para registros ativos
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    //Escopo para busca por CNPJ
    public function scopeCnpj($query)
    {
        return $query->where('cnpj', $cnpj);
    }
}

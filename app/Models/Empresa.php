<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditavel;

class Empresa extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'empresas';  

    protected $fillable = [
        'codigo',
        'empresa_id',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'ie',
        'endereco',
        //'contato_email',
        'cidade',
        'estado',
        'cep',
        'telefone',
        'email',
        'ativo',
    ];

    protected $casts = [
        'ativo'      => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relacionamentos
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function processos(): HasMany
    {
        return $this->hasMany(Processo::class, 'empresa_id');
    }
}
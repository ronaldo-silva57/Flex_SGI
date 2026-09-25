<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditavel;

class Norma extends Model
{
    use HasFactory, SoftDeletes, Auditavel;

    protected $table = 'normas';

    protected $fillable = [
        'codigo',
        'nome',
        'versao',
        'descricao',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];
}

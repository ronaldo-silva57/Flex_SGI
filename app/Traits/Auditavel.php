<?php

namespace App\Traits;

use App\Models\HistoricoAlteracao;
use Illuminate\Support\Facades\Auth;

trait Auditavel
{
    public static function bootAuditavel(): void
    {
        static::created(function ($model) {
            self::registrarAuditoria($model, 'insert');
        });

        static::updated(function ($model) {
            self::registrarAuditoria($model, 'update');
        });

        static::deleted(function ($model) {
            self::registrarAuditoria($model, 'delete');
        });
    }

    protected static function registrarAuditoria($model, string $acao): void
    {
        $dadosAnteriores = null;
        $dadosNovos = null;

        if ($acao === 'insert') {
            $dadosNovos = $model->getAttributes();
        } elseif ($acao === 'update') {
            $dadosAnteriores = [];
            $dadosNovos = [];
            foreach ($model->getChanges() as $campo => $novo) {
                $dadosAnteriores[$campo] = $model->getOriginal($campo);
                $dadosNovos[$campo]       = $novo;
            }
        } elseif ($acao === 'delete') {
            $dadosAnteriores = $model->getAttributes();
        }

        HistoricoAlteracao::create([
            'tabela'           => $model->getTable(),
            'registro_id'      => $model->getKey(),
            'acao'             => $acao,
            'dados_anteriores' => $dadosAnteriores,
            'dados_novos'      => $dadosNovos,
            'usuario_id'       => Auth::id(),
            'ip_address'       => request()->ip(),
            'created_at'       => now(),
        ]);
    }
}
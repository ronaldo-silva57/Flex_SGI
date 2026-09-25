<?php
// app/Jobs/EnviarAlertasVencimento.php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EnviarAlertasVencimento implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $vencendo = DB::table('vw_agenda_vencimentos')
            ->whereBetween('dias_restantes', [0, 7])
            ->orderBy('dias_restantes')
            ->get();

        if ($vencendo->isNotEmpty()) {
            Mail::raw(
                "Você tem {$vencendo->count()} itens vencendo em até 7 dias:\n\n" .
                $vencendo->map(fn($v) =>
                    "- [{$v->modulo}] {$v->item} ({$v->dias_restantes}d)"
                )->implode("\n"),
                fn($m) => $m->to('gestor@apextech.com.br')
                           ->subject('⏰ Alertas de Vencimento SGI')
            );
        }
    }
}
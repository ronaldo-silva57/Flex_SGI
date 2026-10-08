<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\NaoConformidadeAmbiental;
use App\Models\Processo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            EmpresaSeeder::class,
            DepartamentoSeeder::class,
            ClienteSeeder::class,
            FornecedorSeeder::class,
            ClausulaSeeder::class,
            LicencaAmbientalSeeder::class, 
            AdminUserSeeder::class,
        ]);

    // Cria um usuário admin padrão sempre que rodar o migrate:fresh --seed
        //\App\Models\User::factory()->create([
        //    'name' => 'Administrador',
        //    'email' => 'admin@gmail.com',
        //    'password' => bcrypt('Maru#13579'),
        //]);

        $this->call([
            ProcessoSeeder::class,    
            IndicadorSeeder::class,   
            RiscoOportunidadeSeeder::class,
            MonitoramentoSeeder::class,
            NaoConformidadeSeeder::class,
            AcaoCorretivaSeeder::class,
            AuditoriaSeeder::class,
            AuditoriaItemSeeder::class,
            ReuniaoGestaoSeeder::class,
            DocumentoSeeder::class,
            TreinamentoSeeder::class,
            RegistroLegalSeeder::class,
            AspectoAmbientalSeeder::class,
            EpiSeeder::class,
            EpiUsuarioSeeder::class,
            PerigoRiscoSeeder::class, 
            IncidenteAcidenteSeeder::class,
            AtivosInformacaoSeeder::class,     
            ControlesSegurancaSeeder::class, 
            IncidenteSegurancaSeeder::class, 
            EsgIndicadorSeeder::class,
            EsgMonitoramentoSeeder::class,
            StakeholderSeeder::class,
            MaterialidadeSeeder::class,
            VinculoNormativoSeeder::class,
            MudancaGestaoSeeder::class,
            NaoConformidadeAmbientalSeeder::class,

            CipaReuniaoSeeder::class,

            PlanoAcaoSeeder::class,
            AvaliacaoFornecedorSeeder::class,

            PesquisaSatisfacaoSeeder::class,
            PesquisaSatisfacaoRespostaSeeder::class, 

            EquipamentoMedicaoSeeder::class,
            CalibracaoSeeder::class, 
            
            GestaoResiduoSeeder::class,                
            ObjetivoAmbientalSeeder::class, 
            
            ProdutoQuimicoSeeder::class,            
            IndicadorAmbientalSeeder::class,
            MonitoramentoAmbientalSeeder::class,

            ExameMedicoSeeder::class,

            AnaliseRiscoTiSeeder::class,

            SoaControleSeeder::class,
        ]);
    }
}

//$this->call(RolesAndPermissionsSeeder::class);

# Flex SGI — Sistema de Gestão Integrado

**Sistema de Gestão Integrado (SGI)** desenvolvido com Laravel, PostgreSQL e Tailwind CSS, voltado à organização de processos e registros relacionados às normas **ISO 9001, ISO 14001, ISO 45001 e ISO/IEC 27001**, além de indicadores **ESG** (ambientais, sociais e de governança).

> ⚠️ **Status: em desenvolvimento.** Os módulos e fluxos ainda estão em implementação e podem mudar. O projeto não deve ser considerado pronto para uso em produção.

## Objetivo

Centralizar informações e apoiar a gestão de processos, documentos, riscos, fornecedores, não conformidades, ações corretivas e indicadores em uma única aplicação. O software é uma ferramenta de apoio: sua utilização, por si só, **não garante conformidade ou certificação** em nenhuma norma.

## Funcionalidades e módulos

O escopo do projeto inclui, em diferentes estágios de desenvolvimento:

- **Estrutura organizacional:** empresas, departamentos, processos, normas e cláusulas.
- **ISO 9001 — Qualidade:** documentos, fornecedores, não conformidades, análise de causas, ações corretivas e verificação de eficácia.
- **ISO 14001 — Meio ambiente:** aspectos ambientais, indicadores e monitoramentos.
- **ISO 45001 — Saúde e segurança ocupacional:** controles de segurança e EPIs.
- **ISO/IEC 27001 — Segurança da informação:** módulos de gestão previstos no escopo do SGI.
- **ESG:** indicadores, materialidade e monitoramentos.
- **Gestão e acompanhamento:** riscos e oportunidades, reuniões de gestão e painéis.

As funcionalidades disponíveis podem variar conforme o estágio de implementação de cada módulo.

## Tecnologias

| Tecnologia | Utilização |
| --- | --- |
| [Laravel 13](https://laravel.com/) | Framework PHP |
| [PHP 8.3](https://www.php.net/) | Linguagem de programação |
| [PostgreSQL 16](https://www.postgresql.org/) | Banco de dados |
| [Tailwind CSS](https://tailwindcss.com/) | Estilização da interface |
| [Laravel Breeze](https://laravel.com/docs/starter-kits) | Autenticação (dependência de desenvolvimento) |
| [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) | Papéis e permissões |
| [Laravel DOMPDF](https://github.com/barryvdh/laravel-dompdf) | Geração de documentos PDF |
| [Vite](https://vite.dev/) | Compilação e servidor de assets |
| [Pest PHP](https://pestphp.com/) | Testes automatizados |

## Pré-requisitos

| Ferramenta | Versão mínima / requisito | Ambiente utilizado no desenvolvimento |
| --- | --- | --- |
| PHP | 8.3 | 8.3.6 |
| Composer | Compatível com as dependências | 2.7.1 |
| Node.js e npm | Compatíveis com `package.json` | Verificar no ambiente |
| PostgreSQL | Compatível com as migrações | 16.15 |
| Git | Versão atual compatível | — |

Extensões PHP usuais do Laravel e do PostgreSQL: `pdo_pgsql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath` e `fileinfo`.

Verifique seu ambiente:

```bash
php -v
composer --version
php artisan --version
node -v
npm -v
psql --version
```

O ambiente de desenvolvimento utiliza Ubuntu no WSL. A instalação também pode ser adaptada a outros ambientes compatíveis com Laravel.

## Instalação local

### 1. Clonar o repositório

Substitua a URL abaixo pela URL definitiva do repositório depois de criá-lo no GitHub:

```bash
git clone https://github.com/ronaldo-silva57/Flex_SGI.git
```

### 2. Instalar as dependências PHP

```bash
composer install
```

### 3. Preparar o arquivo de ambiente

```bash
cp .env.example .env
```

Configure o PostgreSQL no `.env`:

```dotenv
APP_NAME="Flex SGI"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=flex_sgi
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

Crie previamente o banco `flex_sgi` no PostgreSQL e configure um usuário com as permissões necessárias. **Nunca publique seu arquivo `.env` nem credenciais reais.**

### 4. Gerar a chave e executar as migrações

```bash
php artisan key:generate
php artisan migrate
```

Se o projeto precisar de dados iniciais, verifique os seeders existentes antes de executar `php artisan db:seed`.

### 5. Instalar e compilar os assets

```bash
npm install
npm run build
```

### 6. Iniciar a aplicação

Em um terminal:

```bash
php artisan serve
```

Para trabalhar com o Vite em tempo real, execute em outro terminal:

```bash
npm run dev
```

Acesse **http://localhost:8000**.

## Instalação por script Composer

O `composer.json` inclui:

```bash
composer run setup
```

O script instala dependências, cria o `.env` caso não exista, gera a chave, executa as migrações com `--force`, instala dependências npm com `--ignore-scripts` e compila os assets.

**Antes de executá-lo**, configure o PostgreSQL e o `.env`. Como as migrações usam `--force`, confira o banco de destino, especialmente se já houver dados.

## Inicialização com PM2 (opcional)

Para desenvolvimento com os scripts `iniciarnpm.sh` e `pararnpm.sh`, instale e configure o [PM2](https://pm2.keymetrics.io/) no ambiente. O script de inicialização executa Vite e Laravel em segundo plano:

```bash
chmod +x iniciarnpm.sh pararnpm.sh
./iniciarnpm.sh
pm2 list
```

Para visualizar logs:

```bash
pm2 logs flex_sgi_laravel
pm2 logs flex_sgi_npm
```

Para encerrar os dois processos:

```bash
./pararnpm.sh
```

**Atenção:** `iniciarnpm.sh` inicia o Laravel com `--host=0.0.0.0`, expondo a porta 8000 nas interfaces de rede acessíveis. Use somente em ambiente de desenvolvimento controlado. O servidor `artisan serve` e o Vite não substituem uma configuração adequada de produção.

## Comandos úteis

| Comando | Finalidade |
| --- | --- |
| `composer run setup` | Instalação automatizada prevista no projeto |
| `composer run dev` | Executa `php artisan dev`, conforme o script Composer |
| `composer run test` | Limpa o cache de configuração e executa os testes |
| `php artisan migrate` | Executa as migrações pendentes |
| `php artisan route:list` | Lista as rotas registradas |
| `php artisan test` | Executa os testes |
| `npm run dev` | Inicia o Vite para desenvolvimento |
| `npm run build` | Compila os assets |

## Segurança e contribuição

O projeto está em desenvolvimento. Antes de publicar o repositório, revise arquivos de configuração, dados de teste, backups SQL e outros artefatos para evitar a exposição de senhas, dados pessoais ou informações de clientes. Mantenha o `.env` fora do versionamento e disponibilize somente configurações de exemplo sem segredos.

Sugestões, relatos de problemas e contribuições podem ser enviados por *issues* e *pull requests*, conforme a disponibilidade de manutenção do projeto.

## Licença

Distribuído sob a **Licença MIT**, desde que o arquivo [LICENSE](LICENSE) esteja presente no repositório com o aviso de direitos autorais e os termos correspondentes.

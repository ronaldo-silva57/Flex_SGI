# Migrations incrementais do SGI

Este pacote foi elaborado para uma base Laravel/PostgreSQL que já possui as tabelas do dump analisado e utiliza `SoftDeletes` nos models.

## Objetivo

As migrations adicionam governança e módulos faltantes sem recriar as tabelas existentes. Elas cobrem:

- anexos, comentários, aprovações e ações reutilizáveis;
- versionamento documental;
- programas e equipes de auditoria;
- avaliação de requisitos legais e licenças;
- riscos e avaliações de controles da ISO 27001;
- inspeções ambientais e de SST;
- clientes, reclamações e avaliação de fornecedores para ISO 9001;
- metadados e validação de indicadores ESG;
- índices e campos complementares nas tabelas existentes.

## Ordem

As migrations devem ser copiadas para `database/migrations` mantendo a ordem dos nomes. A ordem foi desenhada para executar depois das migrations atuais que criaram `users`, `empresas`, `documentos`, `auditorias`, `indicadores`, `normas`, `processos`, `fornecedores`, `registros_legais`, `esg_indicadores`, `ativos_informacao`, `controles_seguranca` e `treinamentos`.

Antes de executar em produção:

1. Faça backup do PostgreSQL.
2. Execute `php artisan migrate --pretend`.
3. Revise os índices `unique`, principalmente se já houver registros duplicados.
4. Execute em homologação com uma cópia dos dados.
5. Ajuste os nomes de colunas caso as migrations originais do projeto usem nomes diferentes.

## Premissas

- As tabelas principais existentes usam chave `bigint` e coluna `id`.
- Os usuários estão em `users`.
- A empresa está em `empresas`.
- O projeto usa Laravel com `Schema` e PostgreSQL.
- A exclusão lógica já está configurada nos models existentes.
- As novas tabelas também recebem `softDeletes` quando representam evidências ou registros de negócio.

## Observação sobre exclusões

As migrations não removem automaticamente os `ON DELETE CASCADE` já existentes, porque isso pode exigir nomes exatos das constraints e decisão sobre dados históricos. Em produção, recomenda-se uma migration específica, após inventário e backup, para trocar cascatas de entidades de evidência por `RESTRICT` ou `SET NULL`.

## Comandos

```bash
cp /caminho/das/migrations-sgi/*.php database/migrations/
php artisan migrate --pretend
php artisan migrate
php artisan migrate:status
```

Depois das migrations, os models correspondentes devem usar os casts e relações indicados no código da aplicação. Para `morphs`, use os nomes de relacionamento definidos no pacote: `attachable`, `commentable`, `approvable` e `source`.

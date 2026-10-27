#!/bin/bash

# Verifica se o PostgreSQL está aceitando conexões
if ! pg_isready -q; then
    echo "PostgreSQL está fora do ar. Iniciando o serviço..."
    sudo service postgresql start
    
    # Aguarda até 5 segundos para o banco subir completamente
    for i in {1..5}; do
        if pg_isready -q; then
            echo "PostgreSQL iniciado com sucesso!"
            break
        fi
        sleep 1
    done
else
    echo "PostgreSQL já está rodando."
fi

# Limpa processos anteriores do Laravel
pm2 delete flex_sgi_laravel 2>/dev/null || true
pm2 delete flex_sgi_npm 2>/dev/null || true

# Inicia o VITE / NPM em segundo plano
pm2 start npm --name "flex_sgi_npm" -- run dev

# Inicia o servidor Laravel em segundo plano
pm2 start "php artisan serve --host=0.0.0.0 --port=8000" --name "flex_sgi_laravel"

# Mostra status dos serviços
pm2 list

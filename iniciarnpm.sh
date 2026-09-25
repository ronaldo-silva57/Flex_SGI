#!/bin/bash

# Limpa processos anteriores do Laravel
pm2 delete flex_sgi_laravel 2>/dev/null || true
pm2 delete flex_sgi_npm 2>/dev/null || true

# Inicia o VITE / NPM em segundo plano
pm2 start npm --name "flex_sgi_npm" -- run dev

# Inicia o servidor Laravel em segundo plano
pm2 start "php artisan serve --host=0.0.0.0 --port=8000" --name "flex_sgi_laravel"

# Mostra status dos serviços
pm2 list

#!/bin/bash

# Define o nome do arquivo de saída
ARQUIVO_SAIDA="migrations.txt"

# Limpa o arquivo de saída caso ele já exista para não duplicar dados
> "$ARQUIVO_SAIDA"

# Loop por todos os arquivos do diretório atual
for arquivo in *; do
    # Verifica se é um arquivo comum (ignora pastas)
    if [ -f "$arquivo" ]; then
        # Evita que o próprio script ou o resultado entrem na lista
        if [ "$arquivo" != "juntar.sh" ] && [ "$arquivo" != "$ARQUIVO_SAIDA" ]; then
            
            # 1. Escreve o cabeçalho com o nome do arquivo
            echo "=== NOME DO ARQUIVO: $arquivo ===" >> "$ARQUIVO_SAIDA"
            echo "" >> "$ARQUIVO_SAIDA"
            
            # 2. Copia o conteúdo do arquivo
            cat "$arquivo" >> "$ARQUIVO_SAIDA"
            
            # 3. Adiciona uma linha divisória no final
            echo -e "\n\n========================================\n" >> "$ARQUIVO_SAIDA"
        fi
    fi
done

echo "Pronto! O arquivo '$ARQUIVO_SAIDA' foi gerado com sucesso."

#!/bin/bash

echo "🔧 Iniciando script de entrada (entrypoint.sh)..."

# Esperar a que la base de datos esté disponible
echo "⏳ Esperando a que PostgreSQL esté listo..."
until nc -z -v -w30 db 5432
do
  echo "🔁 Esperando a la base de datos..."
  sleep 5
done
echo "✅ PostgreSQL está disponible."

# Instalar dependencias si no existe /vendor
echo "📦 Instalando dependencias..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Copiando .env desde .env.example..."
cp .env.example .env

echo "🔑 Generando APP_KEY..."
php artisan key:generate --show --force

# Ejecutar migraciones forzadas
echo "📂 Ejecutando migraciones..."
php artisan migrate:refresh  --force --seed 

exec php-fpm

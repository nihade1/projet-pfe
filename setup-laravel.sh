#!/bin/bash

# Laravel Docker Setup Script
# This script runs necessary commands after Docker containers are up

set -e  # Exit on any error

echo "🚀 Starting Laravel application setup..."

# Function to run command with error handling
run_command() {
    local description="$1"
    local command="$2"
    
    echo "$description"
    if $command; then
        echo "✅ Success: $description"
    else
        echo "❌ Error: Failed to $description"
        exit 1
    fi
    echo ""
}

# Check if container is running
echo "🔍 Checking if laravel_app container is running..."
if ! docker ps | grep -q laravel_app; then
    echo "❌ Error: laravel_app container is not running!"
    echo "Please run 'docker-compose up -d' first"
    exit 1
fi

# Wait for containers to be fully ready
echo "⏳ Waiting for containers to be ready..."
sleep 10

# Install Composer dependencies
run_command "📦 Installing Composer dependencies..." "docker exec laravel_app composer install --no-dev --optimize-autoloader"

# Run database migrations
run_command "🗄️ Running database migrations..." "docker exec laravel_app php artisan migrate --force"

# Install NPM dependencies
run_command "📦 Installing NPM dependencies..." "docker exec laravel_app npm install"

# Build frontend assets
run_command "🏗️ Building frontend assets..." "docker exec laravel_app npm run build"

# Seed the database
run_command "🌱 Seeding the database..." "docker exec laravel_app php artisan db:seed --force"

# Create storage symbolic link
run_command "🔗 Creating storage symbolic link..." "docker exec laravel_app php artisan storage:link"

echo "✅ Laravel application setup completed successfully!"
echo "🎉 Your application is ready to use!"

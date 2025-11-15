#!/bin/bash

echo "🚀 CRM Platform - İlk Kurulum Başlıyor..."

# Docker container'ları başlat
echo "📦 Docker container'ları başlatılıyor..."
docker-compose up -d

# Composer dependencies kur
echo "📚 Composer bağımlılıkları yükleniyor..."
docker-compose exec app composer install

# Node dependencies kur
echo "📦 NPM paketleri yükleniyor..."
docker-compose exec app npm install

# .env dosyasını kopyala
if [ ! -f .env ]; then
    echo "⚙️  .env dosyası oluşturuluyor..."
    cp .env.example .env
fi

# Uygulama anahtarı oluştur
echo "🔑 Uygulama anahtarı oluşturuluyor..."
docker-compose exec app php artisan key:generate

# Storage link oluştur
echo "🔗 Storage link oluşturuluyor..."
docker-compose exec app php artisan storage:link

# Database bekle
echo "⏳ Veritabanı hazır olana kadar bekleniyor..."
sleep 10

# Migrations çalıştır
echo "🗄️  Migrations çalıştırılıyor..."
docker-compose exec app php artisan migrate:fresh

# Seed data
echo "🌱 Seed data ekleniyor..."
docker-compose exec app php artisan db:seed

# Permissions cache temizle
echo "🧹 Cache temizleniyor..."
docker-compose exec app php artisan permission:cache-reset
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# IDE Helper
echo "💡 IDE Helper dosyaları oluşturuluyor..."
docker-compose exec app php artisan ide-helper:generate
docker-compose exec app php artisan ide-helper:models --nowrite
docker-compose exec app php artisan ide-helper:meta

# Assets build
echo "🎨 Frontend assets derleniyor..."
docker-compose exec app npm run build

echo "✅ Kurulum tamamlandı!"
echo ""
echo "📋 Erişim Bilgileri:"
echo "   - Uygulama: http://localhost:8080"
echo "   - Adminer (DB): http://localhost:8081"
echo "   - Mailhog: http://localhost:8025"
echo "   - RabbitMQ: http://localhost:15672 (admin/admin)"
echo ""
echo "👤 Varsayılan Admin:"
echo "   - Email: admin@crmplatform.test"
echo "   - Şifre: password"
#!/bin/bash

echo "🚀 CRM Platform - İlk Kurulum Başlıyor..."

# Docker container'ları build ve başlat
echo "📦 Docker container'ları build ediliyor ve başlatılıyor..."
docker-compose up -d --build

# Container'ların hazır olmasını bekle
echo "⏳ Container'ların hazır olması bekleniyor..."
sleep 15

# Container'ların çalıştığını kontrol et
echo "🔍 Container'lar kontrol ediliyor..."
docker-compose ps

# Composer dependencies kur
echo "📚 Composer bağımlılıkları yükleniyor..."
docker-compose exec app composer install

# Node dependencies kur
echo "📦 NPM paketleri yükleniyor..."
docker-compose exec app npm install

# .env dosyasını kontrol et
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

# Migrations çalıştır
echo "🗄️  Migrations çalıştırılıyor..."
docker-compose exec app php artisan migrate:fresh --seed --force

# Permissions cache temizle
echo "🧹 Cache temizleniyor..."
docker-compose exec app php artisan permission:cache-reset
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# IDE Helper
echo "💡 IDE Helper dosyaları oluşturuluyor..."
docker-compose exec app php artisan ide-helper:generate || true
docker-compose exec app php artisan ide-helper:models --nowrite || true
docker-compose exec app php artisan ide-helper:meta || true

# Assets build
echo "🎨 Frontend assets derleniyor..."
docker-compose exec app npm run build

echo "✅ Kurulum tamamlandı!"
echo ""
echo "📋 Erişim Bilgileri:"
echo "   - Uygulama: http://localhost:8080"
echo "   - Adminer (DB): http://localhost:8081"
echo "   - Mailhog: http://localhost:8025"
echo ""
echo "👤 Varsayılan Admin:"
echo "   - Email: admin@crmplatform.test"
echo "   - Şifre: password"
echo ""
echo "🔍 Container durumunu kontrol et: docker-compose ps"
echo "📝 Logları takip et: docker-compose logs -f"
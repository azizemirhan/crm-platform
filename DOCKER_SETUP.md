# 🐳 Multi-Tenant CRM - Docker Kurulum ve Çalıştırma Rehberi

## 📋 Genel Bakış

Bu proje **Docker** üzerinde çalışmaktadır. Docker Compose ile tüm servisler (PostgreSQL, Redis, Nginx, PHP-FPM) otomatik olarak ayağa kalkar.

## 🏗️ Docker Servisleri

```yaml
├── app (PHP 8.2 + Laravel)         → Port: -
├── nginx (Nginx Web Server)        → Port: 8080
├── postgres (PostgreSQL 16)        → Port: 5432
├── redis (Redis 7)                 → Port: 6379
├── mailhog (Email Testing)         → Port: 1025, 8025
└── adminer (DB GUI)                → Port: 8081
```

## 🚀 Hızlı Başlangıç

### 1. Ön Gereksinimler

```bash
# Docker ve Docker Compose kurulu olmalı
docker --version
docker-compose --version
```

### 2. Environment Ayarları

```bash
# .env dosyasını oluştur
cp .env.example .env
```

**.env dosyasını düzenle:**

```env
APP_NAME="Multi-Tenant CRM"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8080
APP_DOMAIN=localhost

# Central Domain (Multi-Tenancy için)
CENTRAL_DOMAIN=localhost
CENTRAL_DOMAIN_WWW=www.localhost

# Database (Docker PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=crm_platform
DB_USERNAME=crm_user
DB_PASSWORD=secret

# Redis (Docker)
REDIS_HOST=redis
REDIS_PASSWORD=redispass
REDIS_PORT=6379

# Mail (MailHog)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@yourcrm.com"
MAIL_FROM_NAME="${APP_NAME}"

# Queue
QUEUE_CONNECTION=redis

# Session
SESSION_DRIVER=redis
CACHE_STORE=redis
```

### 3. Container'ları Başlat

```bash
# Container'ları build et ve başlat
make up

# VEYA
docker-compose up -d
```

### 4. Bağımlılıkları Yükle

```bash
# Composer dependencies
docker-compose exec app composer install

# NPM dependencies
docker-compose exec app npm install
```

### 5. Uygulama Key Oluştur

```bash
docker-compose exec app php artisan key:generate
```

### 6. Database Migration'ları Çalıştır

```bash
# Central (Master) migrations
docker-compose exec app php artisan migrate

# Çıktı:
# ✓ create_cache_table
# ✓ create_jobs_table
# ✓ create_tenants_table          ← TENANT TABLOSU
# ✓ create_domains_table          ← SUBDOMAIN TABLOSU
# ✓ create_subscriptions_table    ← SUBSCRIPTION TABLOSU
# ✓ create_super_admins_table     ← SUPER ADMIN TABLOSU
```

### 7. Super Admin Oluştur

```bash
docker-compose exec app php artisan tinker

# Tinker içinde:
>>> App\Models\SuperAdmin::create([
    'name' => 'Super Admin',
    'email' => 'admin@yourcrm.com',
    'password' => bcrypt('password123'),
    'is_active' => true,
    'permissions' => ['*']
]);

>>> exit
```

### 8. Frontend Build

```bash
# Development mode
docker-compose exec app npm run dev

# Production build
docker-compose exec app npm run build
```

### 9. Uygulamayı Aç

```
🌐 Ana Uygulama:     http://localhost:8080
🔐 Super Admin:      http://localhost:8080/super-admin/login
📧 MailHog:          http://localhost:8025
💾 Adminer:          http://localhost:8081
```

---

## 🎯 Multi-Tenant Test Senaryosu

### Senaryo 1: İlk Tenant'ı Oluştur

#### Yöntem 1: Manuel (Tinker ile)

```bash
docker-compose exec app php artisan tinker
```

```php
// Tenant oluştur
$tenant = App\Models\Tenant::create([
    'id' => 'acme-corp',
    'name' => 'Acme Corporation',
    'slug' => 'acme-corp',
    'email' => 'admin@acme.com',
    'schema_name' => 'tenant_acme_corp',
    'owner_name' => 'John Doe',
    'owner_email' => 'john@acme.com',
    'plan' => 'trial',
    'status' => 'active',
    'trial_ends_at' => now()->addDays(14),
    'max_users' => 3,
    'max_contacts' => 100,
    'max_storage_mb' => 500,
]);

// Subdomain ekle
$tenant->domains()->create([
    'domain' => 'acme-corp.localhost',
]);

// Tenant migration'larını çalıştır
echo "Tenant schema oluşturuluyor...\n";

// Tenant context'inde çalış
$tenant->run(function () {
    // Owner user oluştur
    App\Models\User::create([
        'name' => 'John Doe',
        'email' => 'john@acme.com',
        'password' => bcrypt('password123'),
        'email_verified_at' => now(),
        'is_owner' => true,
    ]);

    // Default team
    App\Models\Team::create([
        'name' => 'Default Team',
        'slug' => 'default',
    ]);
});

echo "Tenant oluşturuldu! Domain: acme-corp.localhost\n";
exit
```

#### Yöntem 2: Artisan Komutu (Daha Kolay)

Önce bir artisan komutu oluşturalım:

```bash
docker-compose exec app php artisan make:command CreateTenantCommand
```

### Senaryo 2: Tenant Migration'larını Çalıştır

```bash
# Tüm tenant'lar için migration çalıştır
docker-compose exec app php artisan tenants:migrate

# Belirli bir tenant için
docker-compose exec app php artisan tenants:run acme-corp migrate

# Migration rollback
docker-compose exec app php artisan tenants:migrate:rollback
```

### Senaryo 3: Local Domain Testleri

Docker'da subdomain testi için `/etc/hosts` düzenleme:

```bash
# Linux/Mac
sudo nano /etc/hosts

# Windows
# C:\Windows\System32\drivers\etc\hosts

# Ekle:
127.0.0.1  localhost
127.0.0.1  acme-corp.localhost
127.0.0.1  demo.localhost
127.0.0.1  test.localhost
```

Şimdi tarayıcıda test edin:

```
✅ http://localhost:8080                    → Central (Landing page)
✅ http://localhost:8080/register           → Tenant Registration
✅ http://localhost:8080/super-admin/login  → Super Admin Login
✅ http://acme-corp.localhost:8080/login    → Tenant Login (Acme Corp)
```

---

## 🛠️ Makefile Komutları

### Temel Komutlar

```bash
make help           # Tüm komutları listele
make up             # Container'ları başlat
make down           # Container'ları durdur
make restart        # Container'ları yeniden başlat
make logs           # Logları göster
make shell          # App container'a bağlan
```

### Database Komutları

```bash
make migrate        # Central migration'ları çalıştır
make migrate-fresh  # DB'yi sıfırla
make seed           # Seed data ekle
make tinker         # Laravel Tinker
```

### Frontend Komutları

```bash
make npm-dev        # Assets compile (dev)
make npm-build      # Assets compile (production)
make npm-watch      # Watch mode
```

### Utility Komutları

```bash
make cache-clear    # Cache temizle
make test           # Testleri çalıştır
make pint           # Code style düzelt
make db-backup      # Database backup
```

---

## 📦 Multi-Tenant Özel Komutlar

Makefile'a eklenebilecek multi-tenant komutları:

```makefile
# Makefile'a ekle:

tenant-migrate: ## Tüm tenant migration'larını çalıştır
	docker-compose exec app php artisan tenants:migrate

tenant-migrate-fresh: ## Tüm tenant'ları sıfırla
	docker-compose exec app php artisan tenants:migrate:fresh

tenant-list: ## Tenant'ları listele
	docker-compose exec app php artisan tinker --execute="App\Models\Tenant::all(['id','name','email','plan','status'])"

tenant-seed: ## Tenant seed data ekle
	docker-compose exec app php artisan tenants:seed

create-super-admin: ## Super admin oluştur
	docker-compose exec app php artisan tinker --execute="App\Models\SuperAdmin::create(['name'=>'Admin','email'=>'admin@test.com','password'=>bcrypt('password'),'is_active'=>true,'permissions'=>['*']])"
```

---

## 🐛 Troubleshooting

### Problem 1: PostgreSQL Bağlantı Hatası

```bash
# PostgreSQL container'ın hazır olup olmadığını kontrol et
docker-compose ps postgres

# Health check
docker-compose exec postgres pg_isready -U crm_user

# Logları kontrol et
docker-compose logs postgres
```

### Problem 2: Permission Hatası

```bash
# Storage ve cache klasörlerine izin ver
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### Problem 3: Composer/NPM Çalışmıyor

```bash
# Container'ı yeniden build et
docker-compose down
docker-compose build --no-cache app
docker-compose up -d

# Dependencies yeniden yükle
docker-compose exec app composer install
docker-compose exec app npm install
```

### Problem 4: Subdomain Çalışmıyor

```bash
# Nginx config kontrol
docker-compose exec nginx nginx -t

# Nginx restart
docker-compose restart nginx

# Nginx logs
docker-compose logs nginx
```

### Problem 5: Migration Hataları

```bash
# Database bağlantısını test et
docker-compose exec app php artisan tinker
>>> DB::connection()->getPdo();

# Migration status
docker-compose exec app php artisan migrate:status

# Hata logları
docker-compose logs app
tail -f storage/logs/laravel.log
```

---

## 🔄 Günlük Geliştirme Workflow

### Sabah (Proje Başlatma)

```bash
# Container'ları başlat
make up

# Logları izle (opsiyonel)
make logs
```

### Geliştirme Sırasında

```bash
# Frontend watch (başka terminal)
make npm-watch

# Queue worker (başka terminal)
make queue-work

# Değişiklikleri test et
make test

# Code style düzelt
make pint
```

### Akşam (Kapanış)

```bash
# Container'ları durdur
make down

# VEYA sadece duraklat (veriler kalır)
docker-compose stop
```

---

## 📊 Database Yönetimi

### Adminer ile DB Görüntüleme

```
URL:      http://localhost:8081
System:   PostgreSQL
Server:   postgres
Username: crm_user
Password: secret
Database: crm_platform
```

Tenant schema'larını görmek için:
1. Adminer'da login ol
2. Sol menüden "Select schema" seç
3. Tüm tenant schema'larını göreceksin:
   - `public` (central/master)
   - `tenant_acme_corp`
   - `tenant_demo_company`
   - vb.

### Database Backup

```bash
# Manuel backup
make db-backup

# VEYA
docker-compose exec postgres pg_dump -U crm_user crm_platform > backup.sql

# Restore
docker-compose exec -T postgres psql -U crm_user crm_platform < backup.sql
```

### Schema İçeriğini Göster

```bash
docker-compose exec app php artisan tinker
```

```php
// Tüm tenant'ları listele
App\Models\Tenant::all(['id', 'name', 'schema_name', 'plan']);

// Belirli tenant'ın schema'sına bak
$tenant = App\Models\Tenant::find('acme-corp');
$tenant->run(function() {
    echo "Users: " . App\Models\User::count() . "\n";
    echo "Leads: " . App\Models\Lead::count() . "\n";
    echo "Contacts: " . App\Models\Contact::count() . "\n";
});
```

---

## 🚀 Production Deployment (Docker)

### 1. Production Docker Compose

```bash
# Production için
docker-compose -f docker-compose.prod.yml up -d
```

### 2. Environment Variables

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourcrm.com

# Database
DB_HOST=your-postgres-host
DB_DATABASE=crm_production
DB_USERNAME=crm_prod_user
DB_PASSWORD=strong-password-here

# Redis
REDIS_HOST=your-redis-host
REDIS_PASSWORD=strong-redis-password

# Mail (SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
```

### 3. Optimize

```bash
# Config cache
docker-compose exec app php artisan config:cache

# Route cache
docker-compose exec app php artisan route:cache

# View cache
docker-compose exec app php artisan view:cache

# Production build
docker-compose exec app npm run build
```

---

## 🎓 Örnek Kullanım

### Komple Kurulum (Sıfırdan)

```bash
# 1. Container'ları başlat
make up

# 2. Dependencies
docker-compose exec app composer install
docker-compose exec app npm install

# 3. Environment
docker-compose exec app php artisan key:generate

# 4. Central migrations
make migrate

# 5. Super admin oluştur
docker-compose exec app php artisan tinker
>>> App\Models\SuperAdmin::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password'), 'is_active' => true, 'permissions' => ['*']]);
>>> exit

# 6. Frontend build
make npm-build

# 7. Test et
curl http://localhost:8080
```

### İlk Tenant Oluşturma

```bash
docker-compose exec app php artisan tinker
```

```php
$tenant = App\Models\Tenant::create([
    'id' => 'demo-company',
    'name' => 'Demo Company',
    'slug' => 'demo-company',
    'email' => 'admin@demo.com',
    'schema_name' => 'tenant_demo_company',
    'owner_name' => 'Demo Admin',
    'owner_email' => 'admin@demo.com',
    'plan' => 'professional',
    'status' => 'active',
    'max_users' => 25,
    'max_contacts' => 10000,
    'max_storage_mb' => 10000,
]);

$tenant->domains()->create(['domain' => 'demo-company.localhost']);

$tenant->run(function () {
    App\Models\User::create([
        'name' => 'Demo Admin',
        'email' => 'admin@demo.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
        'is_owner' => true,
    ]);

    App\Models\Team::create([
        'name' => 'Sales Team',
        'slug' => 'sales',
    ]);
});

echo "Tenant created! Login at: http://demo-company.localhost:8080/login\n";
exit
```

---

## 📚 Ek Kaynaklar

- **Docker Compose Docs**: https://docs.docker.com/compose/
- **Laravel Tenancy**: https://tenancyforlaravel.com/docs/
- **PostgreSQL Schemas**: https://www.postgresql.org/docs/current/ddl-schemas.html

---

## ✅ Kontrol Listesi

Kurulum tamamlandıktan sonra kontrol edin:

```bash
# ✅ Container'lar çalışıyor mu?
docker-compose ps

# ✅ Database bağlantısı var mı?
docker-compose exec app php artisan tinker --execute="DB::connection()->getPdo()"

# ✅ Migrations çalıştı mı?
docker-compose exec app php artisan migrate:status

# ✅ Super admin var mı?
docker-compose exec app php artisan tinker --execute="App\Models\SuperAdmin::count()"

# ✅ Nginx çalışıyor mu?
curl -I http://localhost:8080

# ✅ Redis çalışıyor mu?
docker-compose exec redis redis-cli ping
```

---

**🎉 Hazırsınız! Multi-Tenant CRM platformunuz Docker'da çalışıyor!**

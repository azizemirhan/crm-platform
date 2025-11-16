# Database Setup Guide

Bu rehber, CRM Platform için PostgreSQL veritabanını başlatmanızı ve migration'ları çalıştırmanızı sağlar.

## 🚀 Hızlı Başlangıç

### 1. Docker Desktop'ı Başlatın

MacBook'unuzda Docker Desktop uygulamasını açın ve çalıştığından emin olun.

### 2. PostgreSQL'i Başlatın

Terminal'de proje klasöründeyken:

```bash
./start-db.sh
```

Bu script:
- ✅ Docker'ın çalışıp çalışmadığını kontrol eder
- ✅ PostgreSQL container'ını başlatır
- ✅ Bağlantı bilgilerini gösterir
- ✅ Migration'ları çalıştırmak ister (opsiyonel)

### 3. Migration'ları Manuel Çalıştırın (opsiyonel)

Eğer script ile migration çalıştırmadıysanız:

```bash
# Ana migration'lar
php artisan migrate

# Tenant migration'lar (is_vip kolonunu ekler)
php artisan tenants:migrate
```

### 4. PostgreSQL'i Durdurun

İşiniz bittiğinde:

```bash
./stop-db.sh
```

## 📝 Manuel Kullanım

### PostgreSQL'i Başlatma

```bash
docker-compose -f docker-compose.local.yml up -d
```

### PostgreSQL'i Durdurma

```bash
docker-compose -f docker-compose.local.yml down
```

### Log'ları Görme

```bash
docker-compose -f docker-compose.local.yml logs -f
```

### Container Durumunu Kontrol Etme

```bash
docker-compose -f docker-compose.local.yml ps
```

## 🔌 Bağlantı Bilgileri

PostgreSQL başlatıldıktan sonra şu bilgilerle bağlanabilirsiniz:

| Parametre | Değer |
|-----------|-------|
| Host | `localhost` veya `127.0.0.1` |
| Port | `5432` |
| Database | `crm_platform` |
| Username | `crm_user` |
| Password | `secret` |

## 🛠️ Sorun Giderme

### "Docker is not running" Hatası

**Çözüm:** Docker Desktop uygulamasını başlatın ve birkaç saniye bekleyin.

### "could not translate host name postgres" Hatası

**Çözüm:**
1. `./start-db.sh` script'ini çalıştırın
2. PostgreSQL'in başladığından emin olun
3. Migration'ları tekrar deneyin

### Port 5432 Kullanımda

Eğer başka bir PostgreSQL zaten çalışıyorsa:

**Seçenek 1:** Mevcut PostgreSQL'i durdurun
```bash
# macOS Homebrew ile kurulu ise
brew services stop postgresql
```

**Seçenek 2:** `docker-compose.local.yml` dosyasında portu değiştirin:
```yaml
ports:
  - "5433:5432"  # 5432 yerine 5433 kullan
```

Sonra `.env` dosyasını güncelleyin:
```
DB_PORT=5433
```

## 📦 Veri Yönetimi

### Verileri Koruma

Veritabanı verileri Docker volume'de saklanır. Container'ı durdurup başlattığınızda verileriniz korunur.

### Verileri Tamamen Silme

```bash
docker-compose -f docker-compose.local.yml down -v
```

⚠️ **DİKKAT:** Bu komut tüm veritabanı verilerini siler!

## 🎯 is_vip Kolonu Migration'ı

Bu kurulumda oluşturulan önemli migration:

**Dosya:** `database/migrations/tenant/2025_11_16_173043_add_is_vip_to_contacts_table.php`

**Ne yapar:**
- `contacts` tablosuna `is_vip` boolean kolonu ekler
- Varsayılan değer: `false`
- "column is_vip does not exist" hatasını çözer

**Çalıştırma:**
```bash
php artisan tenants:migrate
```

## 💡 İpuçları

1. **Otomatik başlatma:** Her proje açışında `./start-db.sh` çalıştırın
2. **Bilgisayar kapanmadan önce:** Verileri korumak için durdurmaya gerek yok, Docker Desktop kapanınca otomatik durur
3. **Performans:** Docker Desktop'ın memory ayarlarını kontrol edin (Preferences > Resources)

## 🔗 İlgili Dosyalar

- `docker-compose.local.yml` - Sadece PostgreSQL için compose dosyası
- `docker-compose.yml` - Tüm servisler için tam compose dosyası
- `start-db.sh` - PostgreSQL başlatma script'i
- `stop-db.sh` - PostgreSQL durdurma script'i
- `.env` - Veritabanı bağlantı ayarları

## 📚 Daha Fazla Bilgi

- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [PostgreSQL Documentation](https://www.postgresql.org/docs/)
- [Laravel Migrations](https://laravel.com/docs/migrations)

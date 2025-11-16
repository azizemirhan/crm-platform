# 🚀 Multi-Tenant CRM - Docker Hızlı Başlangıç

## ⚡ 5 Dakikada Kurulum

### Adım 1: Repository'yi Clone Et (zaten yaptınız)
```bash
cd crm-platform
```

### Adım 2: Environment Dosyasını Oluştur
```bash
cp .env.example .env
```

**.env dosyasını aç ve şunları kontrol et:**
```env
DB_CONNECTION=pgsql
DB_HOST=postgres          # Docker service adı
DB_PORT=5432
DB_DATABASE=crm_platform
DB_USERNAME=crm_user
DB_PASSWORD=secret

REDIS_HOST=redis          # Docker service adı
REDIS_PASSWORD=redispass
```

### Adım 3: Tek Komutla Kur! 🎉
```bash
make install
```

Bu komut:
- ✅ Container'ları başlatır
- ✅ Composer ve NPM bağımlılıklarını yükler
- ✅ Application key oluşturur
- ✅ Central migration'ları çalıştırır
- ✅ Super Admin oluşturur
- ✅ Demo tenant oluşturur (Acme Corporation)
- ✅ Frontend assets'leri build eder

**İşlem ~2-3 dakika sürer** ☕

### Adım 4: /etc/hosts Ayarı (Opsiyonel ama Önerilen)
```bash
# Linux/Mac
sudo nano /etc/hosts

# Ekle:
127.0.0.1  acme-corp.localhost
127.0.0.1  demo.localhost
```

### Adım 5: Giriş Yap! 🎊

| Platform | URL | Email | Şifre |
|----------|-----|-------|-------|
| **Super Admin** | http://localhost:8080/super-admin/login | admin@test.com | password |
| **Demo Tenant** | http://acme-corp.localhost:8080/login | john@acme.com | password |
| **Adminer (DB)** | http://localhost:8081 | crm_user | secret |
| **MailHog** | http://localhost:8025 | - | - |

---

## 📦 Yeni Tenant Oluşturma

### Yöntem 1: Web Üzerinden (Registration Form)
```
http://localhost:8080/register
```

### Yöntem 2: Make Komutu ile
```bash
# Demo tenant (Acme Corporation)
make create-demo-tenant

# Kendi tenant'ınızı oluşturmak için tinker kullanın
make tinker
```

### Yöntem 3: Tinker ile (Custom)
```bash
make tinker
```

```php
$tenant = App\Models\Tenant::create([
    'id' => 'my-company',
    'name' => 'My Company',
    'slug' => 'my-company',
    'email' => 'admin@mycompany.com',
    'schema_name' => 'tenant_my_company',
    'owner_name' => 'Jane Doe',
    'owner_email' => 'jane@mycompany.com',
    'plan' => 'professional',
    'status' => 'active',
    'max_users' => 25,
    'max_contacts' => 10000,
    'max_storage_mb' => 10000,
]);

$tenant->domains()->create(['domain' => 'my-company.localhost']);

$tenant->run(function () {
    App\Models\User::create([
        'name' => 'Jane Doe',
        'email' => 'jane@mycompany.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);
});

echo "Tenant created! Login: http://my-company.localhost:8080/login\n";
exit
```

---

## 🛠️ Sık Kullanılan Komutlar

### Temel Komutlar
```bash
make help              # Tüm komutları göster
make up                # Container'ları başlat
make down              # Container'ları durdur
make logs              # Logları izle
make shell             # Container'a bağlan
```

### Multi-Tenant Komutlar
```bash
make tenant-list       # Tenant'ları listele
make tenant-info       # Detaylı tenant bilgileri
make tenant-migrate    # Tenant migration'larını çalıştır
make create-super-admin # Yeni super admin
```

### Database Komutlar
```bash
make migrate           # Central migrations
make migrate-fresh     # DB'yi sıfırla
make db-backup         # Backup al
make tinker            # Laravel Tinker
```

### Frontend Komutlar
```bash
make npm-dev           # Development build
make npm-build         # Production build
make npm-watch         # Watch mode
```

---

## 🔄 Günlük Kullanım

### Sabah (Başlarken)
```bash
make up
```

### Geliştirme Sırasında
```bash
# Terminal 1: Frontend watch
make npm-watch

# Terminal 2: Logları izle
make logs

# Terminal 3: Queue worker (gerekirse)
make queue-work
```

### Akşam (Bitirirken)
```bash
make down
```

---

## 🐛 Sorun Giderme

### Container çalışmıyor mu?
```bash
docker-compose ps
docker-compose logs app
```

### Database bağlantı hatası?
```bash
docker-compose logs postgres
make tinker
>>> DB::connection()->getPdo();
```

### Migration hatası?
```bash
make migrate
docker-compose logs app
```

### Subdomain çalışmıyor?
```bash
# /etc/hosts kontrol et
cat /etc/hosts | grep localhost

# Nginx restart
docker-compose restart nginx
```

---

## 📚 Detaylı Dokümantasyon

| Dosya | İçerik |
|-------|--------|
| `DOCKER_SETUP.md` | Detaylı Docker kurulum ve kullanım |
| `MULTI_TENANT_SETUP.md` | Multi-tenant mimari açıklaması |
| `README.md` | Genel proje bilgisi |

---

## ✅ Kontrol Listesi

Kurulumun başarılı olduğunu test et:

```bash
# ✅ Container'lar çalışıyor mu?
docker-compose ps

# ✅ Super admin var mı?
make tinker
>>> App\Models\SuperAdmin::count()

# ✅ Tenant var mı?
make tenant-list

# ✅ Web çalışıyor mu?
curl -I http://localhost:8080
```

---

## 🎓 İlk Adımlar

1. **Super Admin Paneline Gir**
   ```
   http://localhost:8080/super-admin/login
   Email: admin@test.com
   Pass: password
   ```

2. **Tenant'ları Görüntüle**
   - Dashboard'da tenant istatistiklerini gör
   - "Tenants" menüsünden tüm tenant'ları listele

3. **Demo Tenant'ı Test Et**
   ```
   http://acme-corp.localhost:8080/login
   Email: john@acme.com
   Pass: password
   ```

4. **CRM Özelliklerini Dene**
   - Lead ekle
   - Contact oluştur
   - Opportunity yarat
   - Task yönet

5. **Impersonation Dene**
   - Super admin panelinde
   - Tenant listesinde "Impersonate" butonuna tıkla
   - Tenant kullanıcısı olarak CRM'i kullan

---

## 🎉 Tamamdır!

Multi-Tenant CRM platformunuz Docker'da çalışıyor!

**Soru ve sorunlar için:**
- `DOCKER_SETUP.md` - Detaylı rehber
- `MULTI_TENANT_SETUP.md` - Mimari açıklama
- `make help` - Tüm komutlar

---

**💡 İpucu:** `make install` komutu yalnızca ilk kurulumda çalıştırılır. Sonraki kullanımlarda sadece `make up` yeterlidir.

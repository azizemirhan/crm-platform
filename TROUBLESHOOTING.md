# Troubleshooting Guide

## Issue: "Class 'Stancl\Tenancy\Database\Models\Tenant' not found"

### Cause
This error occurs when the composer autoloader hasn't been refreshed after installing dependencies.

### Solution

**Option 1: Use the fix script (Recommended)**

```bash
./fix-and-setup.sh
```

This script will:
- Refresh the composer autoloader
- Clear all Laravel caches
- Run tenant migrations
- Create the demo tenant

**Option 2: Use Makefile commands**

```bash
# First, refresh the autoloader
make fix-autoload

# Then create the demo tenant
make create-demo-tenant

# Or run the complete setup
make setup-multi-tenant
```

**Option 3: Manual commands**

```bash
# 1. Refresh autoloader
docker-compose exec app composer dump-autoload -o

# 2. Clear caches
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear

# 3. Create demo tenant
make create-demo-tenant
```

---

## Common Issues

### 1. Database Connection Refused

**Error**: `SQLSTATE[08006] [7] connection to server at "127.0.0.1", port 5432 failed`

**Solution**: Update `.env` file to use Docker service names:

```env
DB_HOST=postgres          # NOT 127.0.0.1
DB_USERNAME=crm_user      # NOT postgres
DB_PASSWORD=secret
REDIS_HOST=redis          # NOT 127.0.0.1
MAIL_HOST=mailhog         # NOT 127.0.0.1
```

### 2. Subdomain Not Working

**Error**: `acme-corp.localhost:8080` shows 404 or doesn't work

**Solution**:

**For Linux/Mac**, add to `/etc/hosts`:
```
127.0.0.1 acme-corp.localhost
127.0.0.1 localhost
```

**For Windows**, add to `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1 acme-corp.localhost
127.0.0.1 localhost
```

**Alternative**: Use the tenant ID directly:
```
http://localhost:8080/login?tenant=acme-corp
```

### 3. Tenant Migrations Not Running

**Error**: Tenant database schema not created

**Solution**:

```bash
# Run tenant migrations
make tenant-migrate

# Or manually
docker-compose exec app php artisan tenants:migrate
```

### 4. Super Admin Login Not Working

**Error**: Invalid credentials

**Solution**:

```bash
# Recreate super admin
make create-super-admin

# Default credentials:
# Email: admin@test.com
# Password: password
```

### 5. Frontend Assets Not Loading

**Error**: CSS/JS not loading

**Solution**:

```bash
# Build frontend assets
make npm-build

# Or for development with hot reload
make npm-dev
```

---

## Verification Steps

After setup, verify everything works:

### 1. Check Tenants

```bash
make tenant-list
```

Should show:
```
acme-corp - Acme Corporation (professional) - active
```

### 2. Check Tenant Details

```bash
make tenant-info
```

Should display tenant information including:
- ID, Name, Email
- Plan, Status
- Domain
- Schema name

### 3. Access Points

Verify you can access:

- ✅ **Landing Page**: http://localhost:8080
- ✅ **Super Admin Login**: http://localhost:8080/super-admin/login
- ✅ **Super Admin Dashboard**: Login with admin@test.com / password
- ✅ **Tenant Login**: http://acme-corp.localhost:8080/login
- ✅ **Tenant Dashboard**: Login with john@acme.com / password
- ✅ **Adminer (DB Tool)**: http://localhost:8081
- ✅ **MailHog (Email)**: http://localhost:8025

---

## Debug Commands

### Check Docker containers

```bash
docker-compose ps
```

All services should be "Up":
- app
- nginx
- postgres
- redis
- adminer
- mailhog

### Check logs

```bash
# All logs
make logs

# App logs only
docker-compose logs -f app

# Database logs
docker-compose logs -f postgres
```

### Access shell

```bash
# App container shell
make shell

# Or
docker-compose exec app /bin/sh
```

### Laravel Tinker

```bash
make tinker

# Then test:
App\Models\Tenant::all();
App\Models\SuperAdmin::all();
```

### Database access

**Via Adminer** (http://localhost:8081):
- System: PostgreSQL
- Server: postgres
- Username: crm_user
- Password: secret
- Database: crm_platform

**Via CLI**:
```bash
docker-compose exec postgres psql -U crm_user -d crm_platform
```

---

## Reset Everything

If you need to start fresh:

```bash
# Stop and remove containers
make down

# Remove volumes (WARNING: deletes all data)
docker-compose down -v

# Start fresh
make install
```

---

## Need Help?

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check Docker logs: `make logs`
3. Verify `.env` configuration
4. Ensure all Docker services are running: `docker-compose ps`
5. Try clearing all caches: `make cache-clear`

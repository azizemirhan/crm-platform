# Multi-Tenant SaaS CRM - Setup Guide

## 📋 Overview

This is a **Multi-Tenant SaaS CRM Platform** built with Laravel 11 and using the **PostgreSQL Schema-Based** tenancy approach. Each customer (tenant) gets their own isolated database schema for complete data isolation.

## 🏗️ Architecture

```
┌─────────────────────────────────────────────────────┐
│              POSTGRESQL DATABASE                     │
│                                                      │
│  ┌────────────┐  ┌────────────┐  ┌────────────┐   │
│  │  public    │  │  tenant_1  │  │  tenant_2  │   │
│  │  (master)  │  │  (schema)  │  │  (schema)  │   │
│  │            │  │            │  │            │   │
│  │ - tenants  │  │ - leads    │  │ - leads    │   │
│  │ - domains  │  │ - contacts │  │ - contacts │   │
│  │ - subscr.. │  │ - accounts │  │ - accounts │   │
│  │ - super_.. │  │ - opport.. │  │ - opport.. │   │
│  └────────────┘  └────────────┘  └────────────┘   │
└─────────────────────────────────────────────────────┘
```

### Key Features

✅ **PostgreSQL Schema-Based Tenancy** - Each tenant has isolated schema
✅ **Automatic Tenant Provisioning** - Sign up creates tenant + domain + database schema
✅ **Multi-Plan Support** - Trial, Starter, Professional, Enterprise
✅ **Super Admin Panel** - Manage all tenants, impersonate users, view analytics
✅ **Subdomain Routing** - Each tenant gets `company.yourcrm.com`
✅ **Usage Tracking** - Monitor users, contacts, storage per tenant
✅ **Subscription Management** - Integrated billing & plan limits

## 🚀 Installation

### Prerequisites

- PHP 8.2+
- PostgreSQL 14+
- Composer
- Node.js & NPM

### Step 1: Clone and Install Dependencies

```bash
git clone <repository-url>
cd crm-platform
composer install
npm install
```

### Step 2: Environment Configuration

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

Update the following in `.env`:

```env
APP_NAME="Your CRM"
APP_URL=http://localhost
APP_DOMAIN=localhost

# Database (PostgreSQL required for multi-tenancy)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=crm_platform
DB_USERNAME=postgres
DB_PASSWORD=your_password

# Central domain (where landing page and registration live)
CENTRAL_DOMAIN=yourcrm.com
CENTRAL_DOMAIN_WWW=www.yourcrm.com

# Session & Queue
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

### Step 3: Generate Application Key

```bash
php artisan key:generate
```

### Step 4: Run Migrations

```bash
# Run central/master database migrations
php artisan migrate

# Create your first super admin
php artisan tinker
>>> App\Models\SuperAdmin::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'is_active' => true, 'permissions' => ['*']]);
>>> exit
```

### Step 5: Build Frontend Assets

```bash
npm run build
# or for development
npm run dev
```

### Step 6: Start Development Server

```bash
php artisan serve
```

## 📁 Project Structure

```
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Central/             # Landing pages, registration
│   │       │   └── TenantRegistrationController.php
│   │       ├── SuperAdmin/          # Super admin controllers
│   │       │   ├── AuthController.php
│   │       │   ├── DashboardController.php
│   │       │   ├── TenantController.php
│   │       │   └── ImpersonateController.php
│   │       ├── Tenant/              # Tenant auth
│   │       │   └── AuthController.php
│   │       └── [CRM Controllers]    # Leads, Contacts, etc.
│   └── Models/
│       ├── Tenant.php               # Custom tenant model
│       ├── Subscription.php
│       ├── SuperAdmin.php
│       └── [CRM Models]
│
├── database/
│   ├── migrations/                  # Central migrations
│   │   ├── 2019_09_15_000010_create_tenants_table.php
│   │   ├── 2019_09_15_000020_create_domains_table.php
│   │   ├── 2025_11_16_*_create_subscriptions_table.php
│   │   └── 2025_11_16_*_create_super_admins_table.php
│   └── migrations/tenant/           # Tenant-specific migrations (CRM tables)
│       ├── *_create_users_table.php
│       ├── *_create_leads_table.php
│       ├── *_create_contacts_table.php
│       └── [22 total tenant migrations]
│
├── routes/
│   ├── web.php                      # Central routes (landing, registration)
│   ├── tenant.php                   # Tenant routes (CRM app)
│   ├── tenant-auth.php              # Tenant authentication
│   └── super-admin.php              # Super admin panel
│
└── config/
    ├── tenancy.php                  # Tenancy configuration
    └── auth.php                     # Auth guards (web, super-admin)
```

## 🔐 Authentication

### Three Separate Auth Systems:

1. **Tenant Users** (`web` guard)
   - Login: `http://tenant.yourcrm.com/login`
   - Model: `App\Models\User`
   - Database: Tenant schema

2. **Super Admins** (`super-admin` guard)
   - Login: `http://yourcrm.com/super-admin/login`
   - Model: `App\Models\SuperAdmin`
   - Database: Public schema (central)

3. **Impersonation**
   - Super admins can impersonate tenant users
   - Session-based switching

## 🎯 User Flows

### 1. Tenant Registration

```
1. Visit http://yourcrm.com/register
2. Fill form (company name, email, password, plan)
3. System creates:
   - Tenant record in public.tenants
   - Subdomain: company.yourcrm.com
   - PostgreSQL schema: tenant_company_xxx
   - Owner user in tenant schema
   - Default team
4. Redirect to http://company.yourcrm.com/login
5. Login and use CRM
```

### 2. Super Admin Management

```
1. Visit http://yourcrm.com/super-admin/login
2. Login with super admin credentials
3. Dashboard shows:
   - Total tenants, revenue, trials
   - Recent signups
   - Expiring trials
4. Manage tenants:
   - View details
   - Suspend/activate
   - Cancel subscriptions
   - Impersonate users
```

### 3. Impersonation Flow

```
1. Super admin clicks "Impersonate" on tenant
2. System:
   - Stores super admin ID in session
   - Initializes tenant context
   - Logs in as tenant owner
3. Redirect to tenant dashboard
4. Super admin sees tenant's CRM
5. Click "Leave Impersonation" to return
```

## 📊 Database Schema

### Central Database (public schema)

**tenants**
- id (primary), name, slug, email, schema_name
- owner_name, owner_email
- plan, status, trial_ends_at
- max_users, max_contacts, max_storage_mb
- current_users, current_contacts, current_storage_mb
- features (JSON), settings (JSON)

**domains**
- id, tenant_id, domain

**subscriptions**
- id, tenant_id, plan, status
- amount, currency, billing_period
- stripe_subscription_id

**super_admins**
- id, name, email, password
- permissions (JSON), is_active

### Tenant Database (per-schema)

Each tenant schema contains all CRM tables:
- users, teams, roles, permissions
- leads, contacts, accounts, opportunities
- activities, tasks, notes, meetings
- tags, media, custom_fields, webhooks

## 🔧 Configuration

### Tenancy Config (`config/tenancy.php`)

```php
'database' => [
    'central_connection' => 'pgsql',
    'managers' => [
        'pgsql' => PostgreSQLSchemaManager::class, // Schema-based
    ],
],

'central_domains' => [
    'yourcrm.com',
    'www.yourcrm.com',
    'localhost',
],
```

### Plans & Limits

| Plan          | Users | Contacts | Storage | Price/mo |
|---------------|-------|----------|---------|----------|
| Trial         | 3     | 100      | 500 MB  | $0       |
| Starter       | 5     | 1,000    | 2 GB    | $29      |
| Professional  | 25    | 10,000   | 10 GB   | $79      |
| Enterprise    | 100   | 50,000   | 50 GB   | $199     |

## 🛠️ Artisan Commands

```bash
# Run tenant migrations
php artisan tenants:migrate

# Rollback tenant migrations
php artisan tenants:migrate:rollback

# Seed tenant databases
php artisan tenants:seed

# Run command for specific tenant
php artisan tenants:run <tenant-id> <command>

# List all tenants
php artisan tinker
>>> App\Models\Tenant::all()
```

## 🚨 Important Notes

### DNS Configuration

For production, configure DNS wildcard:

```
*.yourcrm.com  →  your-server-ip
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name ~^(?<tenant>.+)\.yourcrm\.com$;
    root /var/www/crm-platform/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Security Considerations

1. ✅ Each tenant has isolated database schema
2. ✅ Middleware prevents cross-tenant access
3. ✅ Subdomain routing ensures tenant context
4. ⚠️ Use HTTPS in production
5. ⚠️ Implement rate limiting
6. ⚠️ Add CSRF protection to forms

## 📚 API Endpoints

### Central Routes

- `GET /` - Landing page
- `GET /pricing` - Pricing page
- `GET /register` - Tenant registration form
- `POST /register` - Create new tenant
- `GET /super-admin/login` - Super admin login
- `GET /super-admin/dashboard` - Super admin dashboard
- `GET /super-admin/tenants` - List all tenants
- `POST /super-admin/tenants/{id}/impersonate` - Impersonate tenant

### Tenant Routes (Subdomain)

- `GET /login` - Tenant login
- `GET /dashboard` - CRM dashboard
- `GET /leads` - Leads list
- `GET /contacts` - Contacts list
- `GET /opportunities` - Opportunities list
- [All CRM routes]

## 🐛 Troubleshooting

### Issue: Migrations fail

```bash
# Ensure PostgreSQL is running
sudo systemctl status postgresql

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Issue: Tenant creation fails

Check logs:
```bash
tail -f storage/logs/laravel.log
```

### Issue: Subdomain not working locally

Add to `/etc/hosts`:
```
127.0.0.1  yourcrm.com
127.0.0.1  tenant1.yourcrm.com
127.0.0.1  tenant2.yourcrm.com
```

## 📈 Next Steps

- [ ] Add Stripe integration for payments
- [ ] Implement usage billing
- [ ] Add email notifications
- [ ] Create admin views
- [ ] Add API rate limiting
- [ ] Implement webhooks
- [ ] Add monitoring & analytics

## 📄 License

MIT License

## 🤝 Contributing

Pull requests are welcome!

---

**Built with ❤️ using Laravel & stancl/tenancy**

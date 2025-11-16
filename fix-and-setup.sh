#!/bin/bash

echo "🔧 Fixing autoloader and setting up demo tenant..."
echo ""

# Step 1: Refresh autoloader
echo "1️⃣ Refreshing composer autoloader..."
docker-compose exec app composer dump-autoload -o
if [ $? -ne 0 ]; then
    echo "❌ Failed to refresh autoloader"
    exit 1
fi
echo "✅ Autoloader refreshed"
echo ""

# Step 2: Clear all Laravel caches
echo "2️⃣ Clearing all Laravel caches..."
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
docker-compose exec app php artisan event:clear
echo "✅ All caches cleared"
echo ""

# Step 2.5: Clear bootstrap cache
echo "2.5️⃣ Clearing bootstrap cache..."
docker-compose exec app rm -f bootstrap/cache/*.php
echo "✅ Bootstrap cache cleared"
echo ""

# Step 3: Run tenant migrations (if not already run)
echo "3️⃣ Running tenant migrations..."
docker-compose exec app php artisan tenants:migrate
echo ""

# Step 4: Create demo tenant
echo "4️⃣ Creating demo tenant..."
docker-compose exec app php artisan tinker --execute="
if(App\Models\Tenant::where('id','acme-corp')->exists()){
    echo '⚠️  Demo tenant already exists!'.PHP_EOL;
    exit;
}

\$tenant = App\Models\Tenant::create([
    'id' => 'acme-corp',
    'name' => 'Acme Corporation',
    'slug' => 'acme-corp',
    'email' => 'admin@acme.com',
    'schema_name' => 'tenant_acme_corp',
    'owner_name' => 'John Doe',
    'owner_email' => 'john@acme.com',
    'plan' => 'professional',
    'status' => 'active',
    'max_users' => 25,
    'max_contacts' => 10000,
    'max_storage_mb' => 10000,
    'current_users' => 0,
    'current_contacts' => 0,
    'current_storage_mb' => 0,
    'features' => [
        'crm' => true,
        'email' => true,
        'reports' => true,
        'api' => true,
        'custom_fields' => true,
    ],
    'settings' => [],
]);

echo '✅ Tenant created with ID: ' . \$tenant->id . PHP_EOL;

\$domain = \$tenant->domains()->create(['domain' => 'acme-corp.localhost']);
echo '✅ Domain created: ' . \$domain->domain . PHP_EOL;

\$tenant->run(function() {
    \$user = App\Models\User::create([
        'name' => 'John Doe',
        'email' => 'john@acme.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
        'is_owner' => true,
    ]);
    echo '✅ User created: ' . \$user->email . PHP_EOL;

    \$team = App\Models\Team::create([
        'name' => 'Sales Team',
        'slug' => 'sales',
    ]);
    echo '✅ Team created: ' . \$team->name . PHP_EOL;
});

echo PHP_EOL;
echo '🎉 Demo tenant setup complete!' . PHP_EOL;
echo '🌐 Access at: http://acme-corp.localhost:8080' . PHP_EOL;
echo '🔐 Login with: john@acme.com / password' . PHP_EOL;
"

echo ""
echo "✅ Setup complete!"
echo ""
echo "📋 Summary:"
echo "   Super Admin:  http://localhost:8080/super-admin/login"
echo "                 admin@test.com / password"
echo ""
echo "   Demo Tenant:  http://acme-corp.localhost:8080/login"
echo "                 john@acme.com / password"
echo ""
echo "   Adminer:      http://localhost:8081"
echo "   MailHog:      http://localhost:8025"
echo ""

.PHONY: help

help: ## Bu yardım mesajını gösterir
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

up: ## Container'ları başlat
	docker-compose up -d

down: ## Container'ları durdur
	docker-compose down

restart: ## Container'ları yeniden başlat
	docker-compose restart

logs: ## Logları göster
	docker-compose logs -f

shell: ## App container'a bash ile bağlan
	docker-compose exec app /bin/sh

tinker: ## Laravel Tinker başlat
	docker-compose exec app php artisan tinker

migrate: ## Migration'ları çalıştır
	docker-compose exec app php artisan migrate

migrate-fresh: ## Database'i sıfırla ve migration'ları çalıştır
	docker-compose exec app php artisan migrate:fresh --seed

seed: ## Seed data ekle
	docker-compose exec app php artisan db:seed

test: ## Testleri çalıştır
	docker-compose exec app php artisan test

pint: ## Code style düzelt
	docker-compose exec app ./vendor/bin/pint

cache-clear: ## Tüm cache'leri temizle
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear

composer-dump: ## Composer autoloader'ı yenile
	docker-compose exec app composer dump-autoload -o

fix-autoload: composer-dump cache-clear ## Autoloader ve cache sorunlarını düzelt
	@echo "✅ Autoloader ve cache temizlendi!"

queue-work: ## Queue worker başlat
	docker-compose exec app php artisan queue:work

npm-dev: ## Frontend assets'leri development modda derle
	docker-compose exec app npm run dev

npm-build: ## Frontend assets'leri production modda derle
	docker-compose exec app npm run build

npm-watch: ## Frontend assets'leri watch modda derle
	docker-compose exec app npm run dev -- --watch

db-backup: ## Veritabanı yedekle
	docker-compose exec postgres pg_dump -U crm_user crm_platform > backup_$(shell date +%Y%m%d_%H%M%S).sql

fresh: down up migrate-fresh npm-build cache-clear ## Tam yeniden başlat

## ===== MULTI-TENANT COMMANDS ===== ##

tenant-migrate: ## Tüm tenant migration'larını çalıştır
	docker-compose exec app php artisan tenants:migrate

tenant-migrate-fresh: ## Tüm tenant'ları sıfırla
	docker-compose exec app php artisan tenants:migrate:fresh

tenant-migrate-rollback: ## Tenant migration'larını geri al
	docker-compose exec app php artisan tenants:migrate:rollback

tenant-seed: ## Tenant seed data ekle
	docker-compose exec app php artisan tenants:seed

tenant-list: ## Tenant'ları listele
	@docker-compose exec app php artisan tinker --execute="App\Models\Tenant::select(['id','name','email','plan','status'])->get()->each(function(\$$t){ echo \$$t->id . ' - ' . \$$t->name . ' (' . \$$t->plan . ') - ' . \$$t->status . PHP_EOL; })"

create-super-admin: ## Super admin oluştur (email: admin@test.com, pass: password)
	@echo "Creating Super Admin..."
	@docker-compose exec app php artisan tinker --execute="if(App\Models\SuperAdmin::where('email','admin@test.com')->exists()){echo 'Super Admin already exists!'.PHP_EOL;}else{App\Models\SuperAdmin::create(['name'=>'Super Admin','email'=>'admin@test.com','password'=>bcrypt('password'),'is_active'=>true,'permissions'=>['*']]);echo '✓ Super Admin created!'.PHP_EOL;echo 'Email: admin@test.com'.PHP_EOL;echo 'Password: password'.PHP_EOL;}"

create-demo-tenant: ## Demo tenant oluştur (acme-corp)
	@echo "Creating Demo Tenant..."
	@docker-compose exec app php artisan tinker --execute="if(App\Models\Tenant::where('id','acme-corp')->exists()){echo 'Demo tenant already exists!'.PHP_EOL;exit;}\$$t=App\Models\Tenant::create(['id'=>'acme-corp','name'=>'Acme Corporation','slug'=>'acme-corp','email'=>'admin@acme.com','schema_name'=>'tenant_acme_corp','owner_name'=>'John Doe','owner_email'=>'john@acme.com','plan'=>'professional','status'=>'active','max_users'=>25,'max_contacts'=>10000,'max_storage_mb'=>10000]);\$$t->domains()->create(['domain'=>'acme-corp.localhost']);\$$t->run(function(){App\Models\User::create(['name'=>'John Doe','email'=>'john@acme.com','password'=>bcrypt('password'),'email_verified_at'=>now()]);App\Models\Team::create(['name'=>'Sales Team','slug'=>'sales']);});echo '✓ Demo tenant created!'.PHP_EOL;echo 'Domain: http://acme-corp.localhost:8080'.PHP_EOL;echo 'Login: john@acme.com / password'.PHP_EOL;"

tenant-info: ## Tenant bilgilerini göster
	@docker-compose exec app php artisan tinker --execute="if(App\Models\Tenant::count()==0){echo 'No tenants found.'.PHP_EOL;exit;}App\Models\Tenant::with('domains')->get()->each(function(\$$t){echo '═══════════════════════════════════'.PHP_EOL;echo 'ID: '.\$$t->id.PHP_EOL;echo 'Name: '.\$$t->name.PHP_EOL;echo 'Email: '.\$$t->email.PHP_EOL;echo 'Plan: '.\$$t->plan.PHP_EOL;echo 'Status: '.\$$t->status.PHP_EOL;echo 'Domain: '.(\$$t->domains->first()?->domain ?? 'N/A').PHP_EOL;echo 'Schema: '.\$$t->schema_name.PHP_EOL;});"

setup-multi-tenant: migrate create-super-admin tenant-migrate create-demo-tenant npm-build ## Komple multi-tenant kurulum (ilk kurulum için)

install: up ## İlk kurulum (dependencies + migrations + super admin + demo tenant)
	@echo "🚀 Installing CRM Platform..."
	docker-compose exec app composer install
	docker-compose exec app npm install
	docker-compose exec app php artisan key:generate
	@echo ""
	@echo "🔧 Fixing autoloader..."
	$(MAKE) fix-autoload
	@echo ""
	@echo "📊 Running migrations..."
	$(MAKE) migrate
	@echo ""
	@echo "👤 Creating Super Admin..."
	$(MAKE) create-super-admin
	@echo ""
	@echo "🏢 Creating Demo Tenant..."
	$(MAKE) create-demo-tenant
	@echo ""
	@echo "📦 Building frontend..."
	$(MAKE) npm-build
	@echo ""
	@echo "✅ Installation complete!"
	@echo ""
	@echo "🌐 Access points:"
	@echo "   Main App:     http://localhost:8080"
	@echo "   Super Admin:  http://localhost:8080/super-admin/login"
	@echo "   Demo Tenant:  http://acme-corp.localhost:8080/login"
	@echo "   Adminer:      http://localhost:8081"
	@echo "   MailHog:      http://localhost:8025"
	@echo ""
	@echo "🔐 Credentials:"
	@echo "   Super Admin:  admin@test.com / password"
	@echo "   Demo Tenant:  john@acme.com / password"
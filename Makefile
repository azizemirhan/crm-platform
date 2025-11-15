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
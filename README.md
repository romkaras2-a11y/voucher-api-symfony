# 🎟️ Voucher REST API (Symfony)

A Symfony-based REST API for managing vouchers (creation, listing, validation, redemption),
built with ApiPlatform, Doctrine, JWT Security and Docker.

---

## 🚀 Features

- Create & manage vouchers (amount / percent)
- Redeem vouchers with full validation
- Idempotent redemption endpoint
- API documentation via Swagger (OpenAPI)
- JWT-secured endpoints
- Docker-based local setup
- Unit & Functional Tests

---

## 🧱 Tech Stack

- PHP 8.1
- Symfony 6.4 LTS
- ApiPlatform
- Doctrine ORM
- PostgreSQL
- Docker & Docker Compose
- PHPUnit

---

## 📦 Local Setup (Docker)

```bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php -S localhost:8000 -t public
docker-compose up --build
Bearer <token>
php bin/phpunit

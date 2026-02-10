# 🎟️ Voucher REST API (Symfony)

A Symfony-based REST API for managing vouchers (creation, listing, validation, redemption),
built with ApiPlatform, Doctrine, JWT Security and Docker.

---
🏗️ Architekturübersicht
Client (Postman / Swagger / Frontend)
        |
        | HTTP + JWT Bearer
        v
ApiPlatform (REST / OpenAPI)
        |
        v
Controller (thin)
        |
        v
Service Layer (Business Logic)
        |
        v
Domain / Entity (Voucher)
        |
        v
Doctrine ORM → MySQL

Architekturprinzipien

Controller sind dünn

Business-Logik liegt im Service-Layer

Entities enthalten nur Daten & Validation

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

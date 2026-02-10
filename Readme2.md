??? Voucher REST API – Symfony 6.4

Eine Symfony-basierte REST-API zur Verwaltung und Einlosung von Gutscheinen (Voucher).
Der Fokus liegt auf sauberer Architektur, Security, Testbarkeit und API-Standards.

? Features

? Gutschein erstellen, auflisten & abrufen

? Gutschein einlosen (idempotent)

? Validierung von:

 -Gultigkeitszeitraum

 -Einloseanzahl

 -Mehrfachverwendung

?? JWT-basierte Authentifizierung

?? Swagger / OpenAPI Dokumentation (ApiPlatform)

?? Unit- & API-Tests

?? Docker Setup (API + DB)

?? Saubere Trennung von Controller, Service & Domain

??? Architekturubersicht
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
Doctrine ORM > MySQL

Architekturprinzipien

Controller sind dunn

Business-Logik liegt im Service-Layer

Entities enthalten nur Daten & Validation

Idempotente Einlosung

Security-first Ansatz

?? Technologie-Stack
Bereich	Technologie
Sprache	PHP 8.1
Framework	Symfony 6.4
API	ApiPlatform
Auth	JWT (LexikJWT)
Datenbank	MySQL
ORM	Doctrine
Tests	PHPUnit
Container	Docker
Docs	Swagger / OpenAPI
?? Setup – Lokal (Windows 7 / PHP 8.1)
Voraussetzungen

PHP 8.1

Composer

Git

MySQL (oder Docker)

Installation
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php -S localhost:8000 -t public


?? API lauft unter:

http://localhost:8000


?? Swagger UI:

http://localhost:8000/api

?? Setup – Docker
docker-compose up --build


API: http://localhost:8080

Swagger: http://localhost:8080/api

?? Authentifizierung (JWT)
Login
POST /api/login
Content-Type: application/json

{
  "username": "api_user",
  "password": "password"
}


Antwort:

{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}

Auth Header
Authorization: Bearer <TOKEN>


?? Alle /api/* Endpunkte sind geschutzt.

?? Testing
Unit Tests
php bin/phpunit


Business-Logik (VoucherRedeemer)

Validierung & Einlose-Regeln

API / Functional Tests

Postman Collection im Ordner postman/

JWT Token wird automatisch gesetzt

?? Typische Fehlerfalle

? Gutschein abgelaufen > HTTP 400

? Maximale Einlosungen erreicht > HTTP 400

? Ungultiger Token > HTTP 401

? Zugriff ohne Rolle > HTTP 403

?? Keine internen Fehlerdetails werden geleakt

?? Security-Konzept

JWT Authentication (stateless)

Input Validation (Symfony Validator)

Keine sensiblen Daten im Response

Vorbereitung fur Rate Limiting (z. B. Symfony RateLimiter)

Trennung von Auth & Business-Logik

?? Integration (z. B. Shopware)

API-first Design

Nutzung uber HTTP / JWT

Ideal fur:

Shopware Plugin

Headless Frontends

Microservice-Architekturen

?? Projektstruktur (Auszug)
src/
+-- Controller/
+-- Entity/
+-- Service/
+-- Exception/
tests/
+-- Service/
+-- Api/

?? Weiterentwicklung (optional)

?? Rate Limiting

?? User-Management (DB-basiert)

?? Voucher Usage Reporting

?? GitHub Actions CI

?? Shopware Plugin

????? Autor

Entwickelt als technische Aufgabe / Demo-Projekt
mit Fokus auf Clean Code & API Desi
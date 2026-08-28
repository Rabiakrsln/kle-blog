# KLE Blog Frontend

KLE Blog projesinin kullanıcı arayüzüdür.

Frontend Laravel ile geliştirilmiştir ve backend ile yalnızca API üzerinden haberleşir.

## Teknolojiler

* PHP 8.4
* Laravel 13
* Livewire
* Tailwind CSS
* Vite
* Docker

---

## Mimari

Frontend doğrudan backend veritabanına bağlanmaz.

```text
Browser
   ↓
Laravel Frontend
   ↓
Backend API
   ↓
MySQL
```

Backend:

```text
http://localhost:8000
```

Frontend:

```text
http://localhost:8001
```

---

## Gereksinimler

* Docker Desktop
* Git

---

## Kurulum

Proje klasöründen:

```bash
docker network create kle_blog_network
```

Frontend klasörüne geçin:

```bash
cd blog-frontend
```

Environment dosyasını oluşturun:

```bash
copy .env.example .env
```

Frontend container'larını oluşturun:

```bash
docker compose up -d --build
```

Container durumunu kontrol edin:

```bash
docker compose ps
```

---

## Frontend Adresi

```text
http://localhost:8001
```

Vite development server:

```text
http://localhost:5173
```

---

## Backend API

Frontend backend API'ye aşağıdaki adres üzerinden bağlanır:

```text
http://localhost:8000
```

API adresi `.env` içerisindeki `BACKEND_API_URL` değişkeninden alınır.

Örnek:

```env
APP_URL=http://localhost:8001
BACKEND_API_URL=http://localhost:8000
```

---

## Session ve Cache

Frontend veritabanına bağlanmaz.

Session dosya tabanlı olarak tutulur:

```env
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Authentication sırasında backend tarafından oluşturulan Sanctum token frontend sunucusundaki Laravel session içerisinde tutulur.

Token browser JavaScript'ine veya `localStorage` içerisine gönderilmez.

---

## Authentication

Kullanıcı işlemleri:

```text
Register
Login
Logout
Profile
Dashboard
```

Frontend authentication işlemlerini Laravel Controller/Livewire üzerinden gerçekleştirir.

Login sonrasında API token server-side session içerisinde saklanır.

Logout işleminde backend API logout isteği gönderilir ve session içerisindeki token temizlenir.

---

## API Tabanlı Sayfalar

Frontend aşağıdaki backend API özelliklerini kullanır:

* Blog yazıları
* Kategori listeleri
* Kategori detayları
* Blog detayları
* Yorumlar
* Kullanıcı dashboard
* Kullanıcı yazıları
* Kullanıcı yorumları
* Kullanıcı profil güncelleme
* Kullanım koşulları

---

## Docker Network

Backend ve frontend aynı Docker network üzerinde çalışır:

```text
kle_blog_network
```

Network mevcut değilse:

```bash
docker network create kle_blog_network
```

Kontrol:

```bash
docker network inspect kle_blog_network
```

---

## Durdurma

Frontend container'larını durdurmak için:

```bash
docker compose down
```

Tekrar başlatmak için:

```bash
docker compose up -d
```

---

## Backend ile Birlikte Çalıştırma

Önce backend'i çalıştırın:

```bash
cd blog-backend

docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed
```

Sonra frontend'i çalıştırın:

```bash
cd ../blog-frontend

docker compose up -d --build
```

Uygulamalar:

```text
Frontend: http://localhost:8001
Backend:  http://localhost:8000
Admin:    http://localhost:8000/admin
```

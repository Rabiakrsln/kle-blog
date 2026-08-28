# KLE Blog Backend

KLE Blog projesinin Laravel API ve yönetim paneli backend uygulamasıdır.

## Teknolojiler

* PHP 8.4
* Laravel 13
* MySQL 8
* Laravel Sanctum
* FilamentPHP
* Spatie Laravel Permission
* Docker
* PHPUnit

## Proje Yapısı

```text
kle-blog/
├── blog-backend/
│   ├── Laravel API
│   ├── Filament Admin Panel
│   └── MySQL
│
└── blog-frontend/
    └── Laravel Frontend
```

Backend veritabanı işlemlerini gerçekleştirir ve frontend'e API üzerinden veri sağlar.

---

## Gereksinimler

* Docker Desktop
* Git

Projeyi lokal PHP veya MySQL kurulumu olmadan Docker üzerinden çalıştırabilirsiniz.

---

## Kurulum

Öncelikle proje klasörüne geçin:

```bash
cd kle-blog
```

Docker container'larının kullandığı ortak network'ü oluşturun:

```bash
docker network create kle_blog_network
```

> Network zaten oluşturulduysa bu komutu tekrar çalıştırmanız gerekmez.

Backend klasörüne geçin:

```bash
cd blog-backend
```

Environment dosyasını oluşturun:

```bash
copy .env.example .env
```

Docker container'larını oluşturun:

```bash
docker compose up -d --build
```

Container durumunu kontrol edin:

```bash
docker compose ps
```

Composer bağımlılıklarını yükleyin:

```bash
docker compose exec app composer install
```

Application key oluşturun:

```bash
docker compose exec app php artisan key:generate
```

Veritabanı migration ve seed işlemlerini çalıştırın:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

Cache temizlemek için:

```bash
docker compose exec app php artisan optimize:clear
```

---

## Backend Adresi

API:

```text
http://localhost:8000
```

Filament Admin Panel:

```text
http://localhost:8000/admin
```

---

## Admin Bilgileri

Seed işlemi sonrasında aşağıdaki admin hesabı oluşturulur:

```text
E-posta: test@example.com
Şifre: password
```

Admin hesabı `admin` rolüne sahiptir.

Normal kullanıcılar ise `user` rolü ile oluşturulur.

---

## API

Temel endpointler:

```text
GET    /api/posts
GET    /api/posts/{slug}

POST   /api/posts

GET    /api/categories
GET    /api/categories/{slug}

GET    /api/comments
POST   /api/comments

POST   /api/register
POST   /api/login
POST   /api/logout

GET    /api/user
PUT    /api/user

GET    /api/user/posts
GET    /api/user/comments

GET    /api/contracts/{slug}
```

API authentication işlemlerinde Laravel Sanctum token kullanılır.

---

## Filtreleme

Post endpoint'i aşağıdaki filtreleri destekler:

```text
GET /api/posts?search=laravel
GET /api/posts?category=teknoloji
GET /api/posts?date=today
GET /api/posts?date=week
GET /api/posts?date=month
GET /api/posts?date=year
GET /api/posts?author=1
```

Pagination:

```text
GET /api/posts?page=1&per_page=10
```

---

## Test

Testleri çalıştırmak için:

```bash
docker compose exec app php artisan test
```

---

## Docker

Backend Docker servisleri:

```text
app
db
```

Backend:

```text
localhost:8000
```

MySQL:

```text
localhost:3307
```

Docker içerisindeki MySQL bağlantı bilgileri:

```text
DB_HOST=db
DB_PORT=3306
DB_DATABASE=kle_blog
DB_USERNAME=kle_user
DB_PASSWORD=kle_password
```

---

## Seed Verileri

`php artisan migrate:fresh --seed` çalıştırıldığında:

* Admin kullanıcı
* Normal kullanıcılar
* Roller
* Kategoriler
* Onaylı ve yayınlanmış örnek blog yazıları
* Örnek yorumlar
* Kullanım koşulları

oluşturulur.

Seed işlemi sonrasında ana sayfanın boş kalmaması için onaylanmış ve yayınlanmış örnek blog yazıları oluşturulur.

---

## Postman

Projede API endpointlerini test etmek için Postman collection kullanılabilir.

Postman collection içerisinde aşağıdaki endpointler bulunur:

* Register
* Login
* Logout
* User
* Posts
* Post detail
* Categories
* Comments
* User posts
* User comments
* Contracts

Login sonrasında alınan Sanctum token, authentication gerektiren endpointlerde kullanılmalıdır.

---

## Yeniden Kurulum

Veritabanını tamamen sıfırlayıp seed verilerini tekrar oluşturmak için:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

Cache temizlemek için:

```bash
docker compose exec app php artisan optimize:clear
```

Container'ları durdurmak için:

```bash
docker compose down
```

Container'ları tekrar başlatmak için:

```bash
docker compose up -d
```

---

## Projeyi GitHub'dan Temiz Klonda Çalıştırma

```bash
git clone <repository-url>
cd kle-blog

docker network create kle_blog_network

cd blog-backend
copy .env.example .env

docker compose up -d --build

docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed
```

Daha sonra frontend kurulumu için:

```bash
cd ../blog-frontend
copy .env.example .env

docker compose up -d --build
```

Uygulama adresleri:

```text
Frontend: http://localhost:8001
Backend:  http://localhost:8000
Admin:    http://localhost:8000/admin
```

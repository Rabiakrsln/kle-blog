# Laravel Blog Sitesi

Bu proje Laravel kullanılarak geliştirilmiş bir blog sitesidir.

Proje iki bölümden oluşmaktadır:

* blog-backend
* blog-frontend

Backend verileri ve API işlemlerini yönetir.

Frontend kullanıcıların gördüğü web sitesidir.

## Kullanılan Teknolojiler

Backend:

* Laravel 13
* PHP 8.4
* FilamentPHP
* Laravel Sanctum
* MySQL
* Docker

Frontend:

* Laravel 13
* PHP 8.4
* Blade
* Livewire
* Tailwind CSS
* Vite
* Docker

API testleri için Postman kullanılmıştır.

## Projeyi İndirme

Projeyi GitHub üzerinden bilgisayara indirin.

Terminali açın ve projeyi indirmek istediğiniz klasöre gidin.

```bash
git clone https://github.com/Rabiakrsln/kle-blog.git
```

Proje klasörüne girin.

```bash
cd kle-blog
```

## Gerekenler

Projeyi çalıştırmadan önce bilgisayarda aşağıdaki programların bulunması gerekir:

* Docker Desktop
* Git

Docker Desktop'ın açık olması gerekir.

## Backend'i Çalıştırma

Önce backend klasörüne girin.

```bash
cd blog-backend
```

Backend containerlarını başlatın.

```bash
docker compose up -d
```

Containerların çalışıp çalışmadığını kontrol edin.

```bash
docker compose ps
```

Containerların durumunun `Up` olması gerekir.

Backend Laravel uygulamasını kontrol etmek için:

```bash
docker compose exec app php artisan about
```

Backend adresi:

```text
http://localhost:8000
```

## Frontend'i Çalıştırma

Yeni bir terminal açın.

Ana proje klasörüne gidin.

```bash
cd kle-blog
```

Frontend klasörüne girin.

```bash
cd blog-frontend
```

Frontend containerlarını başlatın.

```bash
docker compose up -d
```

Containerların durumunu kontrol edin.

```bash
docker compose ps
```

Frontend adresi:

```text
http://localhost:8001
```

Siteyi kullanmak için tarayıcıdan bu adresi açın.

## Projeyi Durdurma

Backend klasöründeyken:

```bash
docker compose down
```

Frontend klasöründeyken:

```bash
docker compose down
```

Bu işlem containerları durdurur.

Projeyi tekrar çalıştırmak istediğinizde aynı klasörlerde:

```bash
docker compose up -d
```

komutunu kullanabilirsiniz.

## Siteyi Kullanma

Frontend çalıştıktan sonra tarayıcıdan:

```text
http://localhost:8001
```

adresine girin.

Site açıldığında ana sayfa görüntülenir.

Ana sayfa üzerinden blog yazılarını inceleyebilirsiniz.

## Ana Sayfa

Ana sayfada blog yazıları görüntülenir.

İstediğiniz blog yazısına tıklayarak yazının detay sayfasına gidebilirsiniz.

Yazının detay sayfasında yazının içeriğini ve mevcut yorumları görebilirsiniz.

## Kategoriler

Menüden kategoriler bölümüne gidebilirsiniz.

Burada mevcut kategoriler görüntülenir.

Bir kategori seçildiğinde o kategoriye ait blog yazıları listelenir.

İstediğiniz yazıya tıklayarak yazının detayını açabilirsiniz.

## Blog Yazısı Arama

Blog yazılarını aramak için arama alanını kullanabilirsiniz.

Aramak istediğiniz kelimeyi yazarak ilgili yazıları bulabilirsiniz.

## Blog Yazısı Filtreleme

Blog yazıları filtrelenebilir.

Filtreleme işlemlerinde kategori, tarih ve yazar seçenekleri kullanılabilir.

## Kayıt Olma

Siteye yeni bir kullanıcı olarak kayıt olabilirsiniz.

Kayıt sayfasına gidin.

Gerekli bilgileri doldurun.

Kayıt işlemini tamamlayın.

Daha sonra oluşturduğunuz hesap ile giriş yapabilirsiniz.

## Giriş Yapma

Kayıtlı bir hesabınız varsa giriş sayfasından hesabınıza giriş yapabilirsiniz.

Giriş yaptıktan sonra kullanıcıya özel bölümlere erişebilirsiniz.

## Yorum Yapma

Blog yazılarına yorum yapmak için giriş yapmanız gerekir.

Bir blog yazısının detay sayfasını açın.

Yorum alanına yorumunuzu yazın.

Gönder butonuna basın.

Yorum gönderildikten sonra onay sürecine alınır.

Onaylanan yorumlar blog yazısının altında görüntülenir.

## Dashboard

Giriş yaptıktan sonra dashboard bölümüne ulaşabilirsiniz.

Dashboard üzerinden kullanıcıya ait işlemleri ve bilgileri görebilirsiniz.

## Blog Yazısı Oluşturma

Giriş yapan kullanıcı blog yazısı oluşturma bölümünü kullanabilir.

Blog yazısı oluşturma sayfasında gerekli bilgileri doldurun.

Yazıyı oluşturduktan sonra sistem tarafından işleme alınır.

## Çıkış Yapma

Hesabınızdan çıkmak için çıkış yapma seçeneğini kullanabilirsiniz.

Çıkış yaptıktan sonra tekrar giriş yapmak için giriş sayfasını kullanabilirsiniz.

## Backend Yönetim Paneli

Backend tarafında FilamentPHP ile oluşturulmuş bir yönetim paneli bulunmaktadır.

Yönetim paneli üzerinden sistemdeki içerikler yönetilebilir.

Yönetim panelinde kullanıcılar, kategoriler, blog yazıları ve yorumlar gibi içerikler yönetilebilir.

## API

Frontend ile backend arasında API üzerinden iletişim kurulmaktadır.

Backend API blog yazıları, kategoriler, yorumlar ve kullanıcı işlemleri için kullanılmaktadır.

Frontend doğrudan veritabanına bağlanmaz.

Frontend gerekli bilgileri backend API üzerinden alır.

## Postman

API işlemlerini kontrol etmek için Postman kullanılabilir.

Projede Postman ile ilgili dosyalar `postman` klasöründe bulunmaktadır.

## Sık Kullanılan Komutlar

Backend veya frontend containerlarını çalıştırmak:

```bash
docker compose up -d
```

Containerları durdurmak:

```bash
docker compose down
```

Container durumunu kontrol etmek:

```bash
docker compose ps
```

Laravel bilgilerini görmek:

```bash
docker compose exec app php artisan about
```

Route listesini görmek:

```bash
docker compose exec app php artisan route:list
```

Cache temizlemek:

```bash
docker compose exec app php artisan optimize:clear
```

## Projeyi Kısaca Çalıştırma

Docker Desktop'ı açın.

Terminalde proje klasörüne girin.

Backend'i çalıştırın:

```bash
cd blog-backend
docker compose up -d
```

Yeni terminal açın.

Frontend'i çalıştırın:

```bash
cd kle-blog/blog-frontend
docker compose up -d
```

Daha sonra tarayıcıdan:

```text
http://localhost:8001
```

adresini açın.

Site kullanıma hazırdır.

## Proje Yapısı

```text
kle-blog
|
|-- blog-backend
|   |-- app
|   |-- database
|   |-- routes
|   |-- public
|   |-- docker-compose.yml
|   |-- README.md
|
|-- blog-frontend
|   |-- app
|   |-- resources
|   |-- routes
|   |-- public
|   |-- docker-compose.yml
|   |-- README.md
|
|-- postman
```

## Özet

Bu proje Docker üzerinde çalışan Laravel tabanlı bir blog sitesidir.

Backend veritabanı ve API işlemlerini yönetir.

Frontend kullanıcıların siteyi kullandığı bölümdür.

Kullanıcılar blog yazılarını okuyabilir, kategorileri inceleyebilir, hesap oluşturabilir, giriş yapabilir ve giriş yaptıktan sonra yorum yapabilir.

Projeyi çalıştırmak için Docker Desktop'ın açık olması ve backend ile frontend containerlarının çalıştırılması yeterlidir.

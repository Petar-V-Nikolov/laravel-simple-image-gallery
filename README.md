# Laravel Simple Image Gallery

A Laravel 13 starter kit for a small public photo site. Visitors browse a grid of images. Signed-in users upload JPEG, PNG, WebP, or GIF files to the public disk and can delete their own uploads.

This is a teaching and bootstrap kit, not a media library. There are no albums, no S3 requirement, and no image processing pipeline.

Listed as an open-source starter on [pnscripts.com](https://pnscripts.com).

## Features

- Public home grid (newest first) and a show page
- Session auth: register, log in, log out (Blade, no Breeze)
- Authenticated upload to `storage/app/public/gallery` (max 5 MB)
- Owners can delete their own images
- Docker Compose stack for local MySQL / nginx

## Requirements

- PHP 8.3+
- Composer
- SQLite (for tests) or MySQL (for the Docker / local app)
- PHP GD or Imagick (for the `image` validation rule)

## Install

```bash
git clone git@github.com:Petar-V-Nikolov/laravel-simple-image-gallery.git
cd laravel-simple-image-gallery
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

`storage:link` creates `public/storage` → `storage/app/public`. Without it, uploaded images will not be visible in the browser.

### Docker

The included `docker-compose.yml` runs nginx on port 8080, PHP-FPM, MySQL, and phpMyAdmin. Copy `.env.example` to `.env`, set `DB_HOST=mysql`, generate an app key, then:

```bash
docker compose up -d
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

## Demo credentials

After `php artisan migrate --seed`:

| Field | Value |
| --- | --- |
| Email | `gallery@example.com` |
| Password | `password` |

The seeder does not commit binary images. Upload from `/images/create` after you log in.

## Tests

```bash
php artisan test
```

Feature tests use SQLite in memory (`phpunit.xml`) and `UploadedFile::fake()` so no image fixtures live in git.

## Limitations

- No albums, tags, or collections
- No thumbnails, cropping, or EXIF stripping
- Files live on the **public** disk (local). S3 is optional Laravel config, not required
- Auth is minimal session login/register; there is no email verification or password reset

## License

MIT. Copyright (c) 2026 Petar Nikolov / PN Scripts. See [LICENSE](LICENSE).

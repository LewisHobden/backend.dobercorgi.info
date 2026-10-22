# ![Dobercorgi](https://dobercorgi.fra1.digitaloceanspaces.com/dobercorgi/dobercorgi-128x128.png) Dobercorgi Backend
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/LewisHobden/backend.dobercorgi.info/CI)

## About
This project is an Backend/API written in Laravel to manage/request arbitrary resources. 
A resource consists of a few attributes, and can be managed by administrators of a configured Discord server. 

The API endpoints to get resources are public, while adding and managing of resources are for admins only. 
The production server runs on a PHP-Apache container to keep it lightweight.
File uploading is supported with S3-compatible storage or local.

## Getting Started Developing
Local development uses [Laravel Sail](https://laravel.com/docs/sail), so you only need Docker installed.

1. Copy `.env.example` to `.env`. The defaults will suffice, but you will need a [Discord Application](https://discord.com/developers/) to authenticate with.
   If ports 80 or 3306 are already in use, set `APP_PORT` / `FORWARD_DB_PORT` (and `APP_URL`) in `.env`.
2. Install the PHP dependencies using a throwaway container:
   ```shell
   docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install
   ```
3. Start the containers with `./vendor/bin/sail up -d`.
4. Run the following:
    - `./vendor/bin/sail artisan key:generate`
    - `./vendor/bin/sail artisan migrate`
    - `./vendor/bin/sail npm install`
    - `./vendor/bin/sail npm run dev` (or `npm run build` for a one-off build)
5. Run the tests with `./vendor/bin/sail artisan test`.

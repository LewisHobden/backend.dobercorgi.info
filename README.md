# ![Dobercorgi](https://dobercorgi.fra1.digitaloceanspaces.com/dobercorgi/dobercorgi-128x128.png) Dobercorgi Backend
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/LewisHobden/backend.dobercorgi.info/CI)

## About
This project is an Backend/API written in Laravel to manage/request arbitrary resources. 
A resource consists of a few attributes, and can be managed by administrators of a configured Discord server. 

The API endpoints to get resources are public, while adding and managing of resources are for admins only. 
The production server runs on a PHP-Apache container to keep it lightweight.
File uploading is supported with S3-compatible storage or local.

## Getting Started Developing
The `docker-compose.yml` file is for development purposes, it sets up the database and a container called "development" with NPM and Composer installed for your dependencies.

1. Build dev containers locally using `docker-compose build`.
2. Run the containers using `docker-compose up -d`.
3. Copy `.env.example` to `.env`, the default values will suffice but you will need a [Discord Application](https://discord.com/developers/) to authenticate with.
4. To set up the database, create a database called `laravel` on your dev SQL database using adminer at http://localhost:8080
5. To install dependencies, run `docker exec -it development sh` to open a shell into the dev container and run the following:
    - `composer install`
    - `npm install`
    - `npm run dev`
6. Run `php artisan migrate` in the development container to run migrations.

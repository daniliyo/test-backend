docker compose up -d
docker compose run composer install
docker compose run artisan key:generate
cp .env.example .env
filling .env file
docker compose run artisan migrate


# local setup with sail

- cd into /wordle
- rename .env.local to .env
- run:
  - composer update
  - [sail] up -d
  - [sail] php artisan migrate
  - [sail] php artisan db:seed --class=DummySeeder
  - [sail] npm install
  - [sail] npm run dev

your application is now running on http://localhost, you should be able to register a new moderator

# local setup with ddev

- cd into /wordle
- ddev config
- run:
  - ddev start
  - ddev composer update
  - ddev php artisan migrate
  - ddev php artisan db:seed --class=DummySeeder
  - ddev php artisan db:seed --class=ValidwordSeeder
  - ddev npm install
  - ddev npm run build

your application is now running on https://wordle.ddev.site/, you should be able to register a new moderator

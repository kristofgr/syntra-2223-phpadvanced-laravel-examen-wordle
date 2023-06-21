# local setup

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

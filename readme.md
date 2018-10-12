# Internet crawler

Application for downloading files from internet

## Getting started

clone project to your folder, than

```
cp .env.example .env
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php artisan migrate
/etc/hosts -> {docker ip} internet-crawler.local
open http://internet-crawler.local in browser
```

## Api

Enqueues new task for file downloading
```
[POST] /api/tasks
- payload
  {url: 'valid url'}
- responses
  200 - {data: true}
  422 - {url: error message}
```
Shows list of jobs
```
[GET] /api/tasks
- responses
  200 - [
          {
            id: 1,
            status: pendind | downloading | complete | error
            url: http://original.com/file
            result_url: http://internet-crawler.local/download.csv
            error: string | null
          },
          ...
        ]
```

## Command
Enqueue new task for file downloading
```
docker-compose exec php php artisan tasks:new

Follow instructions!
```
Shows list of jobs
```
docker-compose exec php php artisan tasks:list
```
## Tests
```
docker-compose exec php php artisan migrate --database=pgsql_tests
docker-compose exec php php vendor/bin/phpunit --configuration=phpunit.xml
```

# Internet crawler

Application for downloading files from internet

## Getting started

clone project to your folder, than

```
cp .env.example .env
docker-compose up -d
docker-compose exec php composer install
/etc/hosts -> {docker ip} internet-crawler.local
open http://internet-crawler.local in browser
```

##Api

Api call creates new delayed job for file downloading
```
[POST] /api/tasks
- payload
  {url: 'valid url'}
- responses
  200 - {data: true}
  422 - {url: error message}
```

##Command
Command creates new delayed job for file downloading
```
docker-compose exec php php artisan app:download-file

Follow instructions!
```

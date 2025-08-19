# TestRecord

Проект для управления записями и синхронизации с Google Sheets.

## Установка

1. Клонировать репозиторий:
   ```bash
   git clone git@github.com:kareen-wxs/TestRecord.git
   cd TestRecord

2. Установить зависимости:
    composer install
    npm install
    npm run dev

3. Настроить файл окружения:
    cp .env.example .env
    php artisan key:generate

Запустить миграции и сидеры:
 php artisan migrate --seed

## Google Sheets API

Для синхронизации с Google Sheets необходимо:

Создать проект в Google Cloud Console
.

Включить Google Sheets API.

Создать Service Account и скачать ключ в формате JSON.

Сохранить файл в storage/app/google/credentials.json (эту папку нужно создать вручную).

В настройках проекта в админке указать ID Google-таблицы для синхронизации.

Запуск
    php artisan serve

Дополнительно

База данных проекта лежит в репозитории (test.sql) для удобного запуска.

Все API роуты находятся в routes/api.php.
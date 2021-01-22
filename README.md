 <h1>Установка</h1>

<b>Шаг 1: Клонируем проект</b>

git clone https://github.com/appleuser701/apple_system.git

<b>Шаг 2: Установка зависимостей</b>

composer install

<b>Шаг 3: Применение миграций</b>

php yii migrate

<b>Шаг 4: Добавление пользователя (логин admin, пароль admin)</b>

php yii user/create

<b>Шаг 5: Запуск веб сервера</b>

php yii serve --docroot='backend/web'

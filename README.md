# Ui42

## Require

- PHP 8.2
- compoer
- npm

## Instalation

### 1. Download repository
- download manualy from [repository](https://github.com/pavolhorvath/ui42).
- download with **git clone** command
```
git clone https://github.com/pavolhorvath/ui42.git
```

### 2. Install composer dependencies
```
composer install
```

### 3. Install npm dependencies
```
npm install
```

### 4. Run css compilation for production enviroment
```
npm run production
```

### 5. Set database connection in **.env** file
```
DB_CONNECTION=mysql
DB_HOST={hostUrl}
DB_PORT=3306
DB_DATABASE={databaseName}
DB_USERNAME={userName}
DB_PASSWORD={userPassword}
```

### 6. Run database migrations
```
php artisan migrate
```

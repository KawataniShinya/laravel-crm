# laravel-crm

## composition
- Nginx
- Laravel
- Breeze
- Inertia
- Sanctum
- MySQL
- nodeJS
- Docker
- Redis

## install and Usage
### 1. コンテナ起動
```shell
docker compose build
docker compose up -d
```

### 2. コンテナ確認
```shell
docker ps
docker compose ps
```

### 3. 初期設定(アプリケーション環境)
```shell
docker compose exec app bash
composer install
cp -p /var/www/app/.env.docker /var/www/app/.env
php artisan key:generate
npm install
npm run build
exit
```

### 4. 初期設定(データベース設定)
```shell
docker compose exec db bash
mysql -u root -proot -e "CREATE USER 'laravelCrmUser' IDENTIFIED BY 'password000'"
mysql -u root -proot -e "GRANT all ON *.* TO 'laravelCrmUser'"
mysql -u root -proot -e "FLUSH PRIVILEGES"
mysql -u root -proot -e "CREATE DATABASE laravel_crm"
exit
```
```shell
docker compose exec app bash
php artisan migrate:fresh --seed
exit
```

### 5. hosts設定
hosts に下記エントリーを追加
```shell
127.0.0.1 localhost.app.sample.jp
127.0.0.1 localhost.app-node.sample.jp
```

### 6. ログイン
```
http://localhost.app.sample.jp/login
```
```
Email : test@test.com
Password : password123
```
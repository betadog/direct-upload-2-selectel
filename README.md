# Форма прямой загрузки файлов в облачное хранилище Selectel

Перед началом тестов надо 

1. установить `composer` и выполнить `composer install`
2. настроить Apache/Nginx
3. переопределить константы:
4. 
```
const AUTH_LOGIN    = '';
const AUTH_PASSWORD = '';
const BUCKET        = '';
const PREFIX        = '';
$redirectUrl = 'http://localhost/index.php?success=1';
```

# Installation

```shell
cp .env.example .env
```

```shell
composer install && npm i
```


Replace `/bitrix/.settings.php` content to
```php
return require $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/.settings.php';
```




- [Bitrix Docker](https://github.com/bitrixdock/bitrixdock)

# Comment build le projet

```php
1. docker compose up
2. docker exec -it symfony-apache bash
3. composer install
4. php bin/console make:migration
5. php bin/console doctrine:migrations:migrate
```

### Accéder à la page

```
http://localhost:8080/index.php
```

### Accéder à phpmyadmin 
```
http://localhost:8081/
username : user
password : password

root : root
password : rootpassword


```



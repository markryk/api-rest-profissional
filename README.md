# API REST Profissional

API REST feita com Laravel

## Rodar o projeto

```
git clone
cd api-rest-profissional
php -S localhost:8000 -t public
```

## Visão geral

O que haverá no projeto

- CRUD completo
- Autenticação com Sanctum (OK)
- Paginação
- Filtros
- Versionamento de API
- Swagger / OpenAPI
- Tratamento de erros
- Rate Limiting
- Cache
- Testes automatizados

A API terá os seguintes módulos:

- Tarefas
- Clientes
- Produtos
- Pedidos
- Finanças

## Requisitos

- PHP 8.2+
- Composer
- MySQL/PostgreSQL
- Laravel 12+
- Node.js (opcional)

### Configuração do BD

Edite o arquivo .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_rest_profissional
DB_USERNAME=root
DB_PASSWORD=
```

Execute
```
php artisan migrate
```

### Instalação do Laravel Sanctum

```
composer require laravel/sanctum
```

Publique os arquivos

```
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

Execute as migrations

```
php artisan migrate
```

No arquivo *bootstrap/app.php*, adicione

```
->withMiddleware(function (Middleware $middleware): void {
    $middleware->statefulApi();
})
```

Ainda em bootstrap/app.php, dentro de withRouting(), acrescente:
```
web: __DIR__.'/../routes/web.php',
api: __DIR__.'/../routes/api.php', (acrescentar essa linha)
```

No Model User, acrescente
```
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens;
}
```

### Criação de Models, Migrations e Controllers
```
php artisan make:model Task -mcr
php artisan make:model Client -mcr
php artisan make:model Product -mcr
php artisan make:model Order -mcr
php artisan make:model Finance -mcr

(m: migration; c: controller; r: resource controller)
```

### Configuração de Fillable

xxxModel
```
protected $fillable = [
    (...)
];
```

### Criando Autenticação

AuthController
```
php artisan make:controller Api/V1/AuthController
```

No arquivo Api/V1/AuthController.php, desenvolver métodos:
- register();
- login();
- logout();

### Demais Controllers

TaskController, ClientController, ProductController, OrderController, FinanceController

Métodos:

- index();
- store();
- show();
- update();
- destroy();

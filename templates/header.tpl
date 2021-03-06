<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Starter Template · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

{literal}
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    {/literal}
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.4/examples/starter-template/starter-template.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/">Место под лого</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/folders">Категории</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/vendors">Производители</a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0 px-2" style="border: 1px solid #ffffff; border-radius: 4px;">
            <span class="px-2 text-white">Корзина:</span>
            {if !empty($cart->getCountCartItems())}
                <span class="badge badge-warning">Позиций: {$cart->getCountCartItems()}</span>
                <span class="badge badge-info mr-1 ml-1">Товаров: {$cart->getAmount()}</span>
                <span class="badge badge-success mr-1">Сумма: {$cart->getPrice()} руб.</span>
                <a href="/cart/clear" class="badge badge-danger mr-1"><i class="fa fa-trash"></i></a>
                <a class="badge badge-success" href="/cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
            {else}
                <span class="px-2 text-white">Пуста</span>
            {/if}

        </div>
        <div class="form-inline my-2 my-lg-0" >
            {if $user->getId()}
                <span class="px-2 text-white">Вы зашли как: <a href="/user/edit">{$user->getName()}</a></span>
                <a class="px-2 text-white" href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход</a>
            {else}
                <a class="px-2 text-white" href="/login">Вход</a>
                <a class="px-2 text-white" href="/register">Регистрация</a>
            {/if}
            <form action="/search" class="form-inline my-2 my-lg-0" method="get">
                <input class="form-control mr-sm-2" type="text" name="name" placeholder="Search product" aria-label="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<main role="main" class="container">
        <div class="container">
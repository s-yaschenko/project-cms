<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>MyPortfolio</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="/../img/favicon.png" rel="icon">
    <link href="/../img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700|Raleway:400,700&display=swap"
          rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="/../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/../vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="/../vendor/line-awesome/css/line-awesome.min.css" rel="stylesheet">
    <link href="/../vendor/aos/aos.css" rel="stylesheet">
    <link href="/../vendor/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/../css/style.css" type="text/css" rel="stylesheet">

    <!-- =======================================================
      Template Name: MyPortfolio
      Template URL: https://bootstrapmade.com/myportfolio-bootstrap-portfolio-website-template/
      Author: BootstrapMade.com
      Author URL: https://bootstrapmade.com/
    ======================================================= -->
</head>

<body>

<div class="collapse navbar-collapse custom-navmenu" id="main-navbar">
    <div class="container py-2 py-md-5">
        <div class="row align-items-start">
            <div class="col-md-2">
                <ul class="custom-menu">
                    <li class="active"><a href="/">Home</a></li>
                    <li><a href="about.html">About Me</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="works.html">Works</a></li>
                </ul>
            </div>
            <div class="col-md-6 d-none d-md-block  mr-auto">
                <div class="tweet d-flex">
                    <span class="icofont-twitter text-white mt-2 mr-3"></span>
                    <div>
                        <p><em>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam necessitatibus incidunt ut
                                officiis explicabo inventore. <br> <a href="#">t.co/v82jsk</a></em></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-none d-md-block">
                <h3>Hire Me</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam necessitatibus incidunt ut officiis
                    explicabo inventore. <br> <a href="#">myemail@gmail.com</a></p>
            </div>
        </div>

    </div>
</div>

<nav class="navbar navbar-light custom-navbar">
    <div class="container d-flex justify-content-between">

        {if $user->getId()}
            <span>Вы зашли как: <a href="/user/edit">{$user->getName()}</a></span>
            <a href="/logout">Выход</a>

        {else}

            <form class="form-inline" method="post" action="/login">
                <label class="sr-only" for="inlineFormInputName2">Login</label>
                <input type="text" name="email" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="email">

                <label class="sr-only" for="inlineFormInputName2">Name</label>
                <input type="password" name="password" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="password">

                <button type="submit" class="btn btn-primary mb-2">Submit</button>
            </form>
            <a href="/register">Регистрация</a>
        {/if}

    </div>
    <div class="container">
        <a class="navbar-brand" href="/">MyPortfolio.</a>

        <a href="#" class="burger" data-toggle="collapse" data-target="#main-navbar">
            <span></span>
        </a>

    </div>
</nav>

<main id="main">
    <div class="site-section site-portfolio">
        <div class="container">
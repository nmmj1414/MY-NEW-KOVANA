<?php

?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homestyles.css">
</head>

<body>
    <header>
        <!-- ===================== NAVBAR ===================== -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="home.php">
                    <img src="images/KOVANA_LOGO.png" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-3 p-3 ">
                        <li class="nav-item py-lg-4">
                            <a class="nav-link" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item dropdown py-lg-4">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                                Destinations
                            </a>
                        </li>
                        <li class="nav-item py-lg-4">
                            <a class="nav-link" href="#">About Us</a>
                        </li>
                    </ul>
                </div>
            </nav>
    </header>

    <section id="slider">
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0"
                    class="active"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="4"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/TRAVEL.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>WELCOME TO KOVANA!</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/PAMPANGA.jpg" class="d-block w-100" alt="PAMPANGA">
                    <div class="carousel-caption">
                        <h5>ANGELES,PAMPANGA</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/BANAUE.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>BANAUE</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/CEBU.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>CEBU</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/BORACAY.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>BORACAY</h5>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
</body>
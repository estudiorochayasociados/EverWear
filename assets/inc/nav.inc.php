<?php
$configNav = new Clases\Config();
$contactData = $configNav->viewContact();
$socialData = $configNav->viewSocial();
?>

<!--desktop-->
<div class="gradient"></div>
<div class="d-none d-md-block   ">
    <nav class="col-md-12 navbar navbar-expand-lg fixed-top position-absolute mt-20 ">
        <div class="container ">
            <h1 class="mb-0"><a href="<?= URL ?>"><img src="<?= LOGO ?>" width="250px" alt=""></a></h1>
            <div class="d-flex flex-column flex-wrap">
                <div class="navbar-text ml-auto py-0 px-lg-2">
                    <span class="mr-20"><a class="link-tel btn btn-warning" style="background: #FFC400;color:black;" href="http://www.ecommerceeverwear.softech.com.ar/home.aspx" target="_blank">Ingreso Clientes </a></span>
                    <a href="<?= $socialData['data']['facebook'] ?>" target="_blank"><img src="<?= URL ?>/assets/img/fb.png"></a>
                    <a href="<?= $socialData['data']['youtube'] ?>" target="_blank"><img src="<?= URL ?>/assets/img/youtube.png"></a>
                    <a href="<?= $socialData['data']['linkedin'] ?>" target="_blank"><img src="<?= URL ?>/assets/img/linkedin.png"></a>
                </div>
                <ul class="navbar-nav mb-auto mt-0 ml-auto">
                    <li class="nav-item bold active">
                        <a class="nav-link py-0" href="<?= URL ?>"><i class="fas fa-home"></i></a>
                    </li>
                    <li class="nav-item bold">
                        <a class="nav-link py-0" href="<?= URL ?>/empresa">Somos ever WEAR</a>
                    </li>

                    <li class="nav-item bold">
                        <a class="nav-link py-0" href="<?= URL ?>/lineas">Líneas de Productos</a>
                    </li>
                    <li class="nav-item bold">
                        <a class="nav-link py-0" href="<?= URL ?>/industria">Línea Industria</a>
                    </li>
                    <!-- <li class="nav-item bold">
                        <a class="nav-link py-0" href="<?= URL ?>/blog">Blog</a>
                    </li> -->
                    <li class="nav-item bold">
                        <a class="nav-link py-0" href="<?= URL ?>/social">Comunidad Digital</a>
                    </li>
                    <li class="nav-item bold">
                        <a class="nav-link py-0" href="<?= URL ?>/contacto">Contacto</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</div>
</div>
<!--mobile-->
<div class="d-md-none">
    <nav class="col-md-12 navbar navbar-expand-lg mt-10 nav-mobile" style="background:#000 !important">
        <div class="container">
            <h1 class="mb-0"><a href="#"><img src="<?= LOGO ?>" alt="" width="250px"></a></h1>
            <button class="navbar-toggler text-light" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-light"><i class="fas fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse mt-20" id="navbarResponsive">
                <ul class="navbar-nav mb-auto mt-0 ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link py-0" href="<?= URL ?>"><i class="fas fa-home"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-0" href="<?= URL ?>/empresa">Somos Ever</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-0" href="<?= URL ?>/lineas">Líneas de Productos</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link py-0" href="<?= URL ?>/industria">Línea Industria</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link py-0" href="<?= URL ?>/blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-0" href="<?= URL ?>/social">Comunidad Digital</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-0" href="<?= URL ?>/contacto">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
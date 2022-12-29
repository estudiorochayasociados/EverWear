<header id="header" class=" typeheader-4">
    <div class="header-top hidden-compact">
        <div class="container">
            <div class="row">
                <div class="header-top-right col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul class="top-link list-inline lang-curr">
                    </ul>
                    <ul class="top-log list-inline">
                        <?php if (isset($_SESSION["usuarios"]["nombre"])) { ?>
<!--                            <li><i class="fa fa-sign-in"></i> <a href="--><?//= URL ?><!--/sesion">Mi cuenta</a> |</li>-->
                            <li><a href="<?= URL ?>/sesion?logout=1">Cerrar Sesión</a></li>
                        <?php } else { ?>
                        <li><i class="fa fa-lock"></i> <a href="<?= URL ?>">Iniciar Sesión</a>
                            <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo">
                        <a href="<?= URL ?>"><img src="<?= LOGO ?>" title="<?= TITULO ?>" alt="<?= TITULO ?>"/></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom hidden-compact hidden-md hidden-lg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="main-menu-w">
                        <div class="responsive so-megamenu megamenu-style-dev">
                            <nav class="navbar-default">
                                <div class=" container-megamenu  horizontal open ">
                                    <div class="navbar-header">
                                        <button type="button" id="show-megamenu" style="color:#fff !important;" data-toggle="collapse" class="navbar-toggle">
                                            <span style="color:#fff !important;" class="icon-bar"></span>
                                            <span style="color:#fff !important;" class="icon-bar"></span>
                                            <span style="color:#fff !important;" class="icon-bar"></span>
                                        </button>
                                    </div>

                                    <div class="megamenu-wrapper">
                                        <span id="remove-megamenu" class="fa fa-times"></span>
                                        <div class="megamenu-pattern">
                                            <div class="container-mega">
                                                <ul class="megamenu" data-transition="slide" data-animationtime="250">
                                                    <li class="">
                                                        <p class="close-menu"></p>
                                                        <a href="<?= URL . "/sesion/agregar" ?>" class="clearfix">
                                                            <strong>AGREGAR CLIENTE</strong>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <p class="close-menu"></p>
                                                        <a href="<?= URL . "/sesion/listado" ?>" class="clearfix">
                                                            <strong>LISTADO DE CLIENTES</strong>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <p class="close-menu"></p>
                                                        <a href="<?= URL . "/sesion?logout" ?>" class="clearfix">
                                                            <strong>Salir</strong>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</header>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#1a1a1a;">
    <div class="container">
        <a class="navbar-brand" href="<?php echo SITE_URL; ?>">
            <i class="fa-solid fa-wallet fa-lg me-1"></i>
            <?php echo SITE_NAME; ?>
        </a>

        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fas fa-bars text-light"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto d-flex flex-row mt-3 mt-lg-0">
                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link active" aria-current="page" href="<?php echo SITE_URL; ?>dashboard">
                        <div>
                            <i class="fas fa-home fa-lg mb-1"></i>
                        </div>
                        Начало
                    </a>
                </li>
                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>flags">
                        <div>
                            <i class="fa-solid fa-plus fa-lg mb-1"></i>
                        </div>
                        Закупи флагове
                    </a>
                </li>

                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>advertising">
                        <div>
                            <i class="fa-brands fa-adversal fa-lg mb-1"></i>
                        </div>
                        Закупи реклама
                    </a>
                </li>

                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>credits/sms">
                        <div>
                            <i class="fa-solid fa-coins fa-lg mb-1"></i>
                            <span class="badge rounded-pill badge-notification bg-primary"><?php echo getUser('balance'); ?></span>
                        </div>
                        Зареди кредити
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav ms-auto d-flex flex-row mt-3 mt-lg-0">
                <?php if (getUser('admin') == 1): ?>
                    <li class="nav-item dropdown text-center mx-2 mx-lg-1">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown"
                           aria-expanded="false">
                            <div>
                                <i class="fa-solid fa-gears fa-lg mb-1"></i>
                            </div>
                            АКП
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/users">Управление на потребителите</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/credits">Управление на кредитие</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/flags">Управление на флаговете</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item text-center mx-2 mx-lg-1">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>logout">
                        <div>
                            <i class="fas fa-globe-americas fa-lg mb-1"></i>
                        </div>
                        Изход
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php if (checkIfBanned()): ?>
        <div class="d-flex align-items-center p-3 my-3 text-white bg-danger rounded shadow-sm">
            <i class="fa-solid fa-ban fa-2xl me-3"></i>
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1"><?php echo greeting(); ?></h1>
                <small>Вашето IP <?php echo getIP(); ?>, е банато от нашите сървъри. </small>
            </div>
        </div>
        <div class="d-grid gap-2 mb-3">
            <a href="<?php echo SITE_URL; ?>unban" class="btn btn-warning">Премахни бана</a>
        </div>
    <?php else: ?>
    <div class="d-flex align-items-center p-3 my-3 text-white bg-success rounded shadow-sm">
        <i class="fa-solid fa-circle-check fa-2xl me-3"></i>
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1"><?php echo greeting(); ?></h1>
            <small>Вашето IP <?php echo getIP(); ?>, не е банато от нашите сървъри. Приятна игра!</small>
        </div>
    </div>
<?php endif; ?>
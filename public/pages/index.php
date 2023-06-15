<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Система &bull; <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?php echo SITE_URL; ?>public/assets/stylesheet.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="ultra-big-white"><?php echo SITE_NAME; ?></div>

    <main class="form-signin w-100 m-auto text-center">
        <form method="post">
            <div class="mb-4">
                <i class="fa-solid fa-right-to-bracket fa-2xl" style="font-size: 6rem;color: #fff;text-shadow: 1px 0 1px black;"></i>
            </div>
            <h1 class="h3 mb-3 fw-normal" style="color: #fff;text-shadow: 1px 0 1px black;">Моля, влезте в акаунта си</h1>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Email адрес">
                <label for="floatingInput">Email адрес</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Парола">
                <label for="floatingPassword">Парола</label>
            </div>

            <?php echo csrf_token(); ?>

            <span class="mb-3">
                Нямаш акаунт? Регистрирай се <a href="<?php echo SITE_URL; ?>register">оттук</a>.<br />
                Забравена парола? Вземи нова парола <a href="<?php echo SITE_URL; ?>forgot-password">оттук</a>.<br />
            </span>

            <button class="mt-3 w-100 btn btn-lg btn-primary" name='login' type="submit">Влез</button>
            <p class="mt-5 mb-3">&copy; Developed by HybridMind</p>
        </form>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

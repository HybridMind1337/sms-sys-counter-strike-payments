<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Забравена парола &bull; <?php echo SITE_NAME; ?></title>
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
            <h1 class="h3 mb-3 fw-normal" style="color: #fff;text-shadow: 1px 0 1px black;">Забравена парола</h1>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Парола" required>
                <label for="password">Парола</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Потвърди парола" required>
                <label for="confirm-password">Потвърди парола</label>
            </div>
            <?php echo csrf_token(); ?>

            <span class="mb-3">
                Нямаш акаунт? Регистрирай се <a href="<?php echo SITE_URL; ?>register">оттук</a>.<br />
                 Имаш акаунт? Влез <a href="<?php echo SITE_URL; ?>">оттук</a>.<br/><br />
            </span>

            <button class="mt-3 w-100 btn btn-lg btn-primary" name='reset' type="submit">Нулирай парола</button>
            <p class="mt-5 mb-3">&copy; Developed by HybridMind</p>
        </form>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

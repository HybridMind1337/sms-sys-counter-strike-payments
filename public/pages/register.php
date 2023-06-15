<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Система &bull; <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
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
            <h1 class="h3 mb-3 fw-normal" style="color: #fff;text-shadow: 1px 0 1px black;">Регистрация</h1>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email адрес" required>
                <label for="email">Email адрес</label>
            </div>

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
                Имаш акаунт? Влез <a href="<?php echo SITE_URL; ?>">оттук</a>.<br/>
                Забравена парола? Вземи нова парола <a href="<?php echo SITE_URL; ?>forgot-password">оттук</a>.<br/>
            </span>

            <button class="mt-3 w-100 btn btn-lg btn-primary" name="register" type="submit">Регистрация</button>
            <p class="mt-5 mb-3">&copy; Developed by HybridMind</p>

        </form>
    </main>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="template-toast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script src="<?php echo SITE_URL; ?>public/assets/app.js"></script>
<script>
    <?php
    $sessionMessage = getSessionMessage();
    if ($sessionMessage): ?>
    Swal.fire({
        position: 'top-end',
        icon: '<?php echo $sessionMessage['alert']; ?>',
        title: '<?php echo $sessionMessage['message']; ?>',
        showConfirmButton: false,
        timer: 1500
    })
    <?php endif; ?>
</script>
</body>
</html>

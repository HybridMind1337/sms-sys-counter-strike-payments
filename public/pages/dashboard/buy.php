<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Закупуване на флагове &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>

</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Закупуване на флагове</div>
            <div class="card-body">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th colspan="2" class="alert-heading">Информация за продукта</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Следните флагове ще бъдат добавени към посоченият от вас nickname.</td>
                        <td><b><?php echo $flag->flags ?></b></td>
                    </tr>
                    <tr>
                        <td>Флаговете ще бъдат добавени към следният сървър:</td>
                        <td><b><?php echo $server_info->hostname ?></b></td>
                    </tr>
                    <tr>
                        <td>Времето, през което флаговете ще бъдат активни, ще бъде</td>
                        <td><b><?php echo $flag->valid ?></b> дни.</td>
                    </tr>
                    <tr>
                        <td>Това означава, че ако закупите флаговете днес, ще трябва да ги закупите отново на</td>
                        <td><b><?php echo futureDate($flag->valid) ?></b></td>
                    </tr>
                    </tbody>
                </table>
                <hr />
                <form method="POST">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Име в играта">
                        <label for="name">Име в играта</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="password" name="password" placeholder="Парола за вход">
                        <label for="password">Парола за вход</label>
                    </div>

                    <?php echo csrf_token(); ?>

                    <button type="submit" name="buy" class="btn btn-primary btn-block mb-4">Купи</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once './public/layouts/footer.php'; ?>

</body>
</html>

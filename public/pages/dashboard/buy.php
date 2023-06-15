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
                <div class="alert alert-info" role="alert" data-mdb-color="success">
                    <h4 class="alert-heading">Информация за продукта</h4>
                    <p>
                        Следните флагове ще бъдат добавени към посоченият от вас nickname.<br />
                        <b><?php echo $flag->flags; ?></b><br />
                        Флаговете ще бъдат добавени към следният сървър:<br />
                        <b><?php echo $flag->server_id; ?></b><br />
                        Време траеното на флаговете ще бъде <b><?php echo $flag->valid; ?></b> дни. Тоест ако закупите флаговете днес, ще трябва да закупите флаговете отново на <b><?php echo futureDate($flag->valid); ?></b>
                    </p>
                    <hr/>
                    <p class="mb-0">
                        Премахването на бана ще Ви струва <b><?php echo UNBAN_PRICE; ?></b> кредита.
                    </p>
                </div>

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
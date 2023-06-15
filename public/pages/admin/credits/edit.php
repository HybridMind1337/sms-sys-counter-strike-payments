<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Промяна на SMS кредити &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>

</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Промяна на SMS кредити</div>
            <div class="card-body">
                <div class="alert alert-info" role="alert" data-mdb-color="danger">
                    Промяна на инфомрацията на SMS-a за <b><?php echo $data->amount; ?></b>лв
                </div>
                <form method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="user_id" name="user_id" placeholder="User ID" value="<?php echo $data->user_id; ?>">
                        <label for="user_id">User ID</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="service_id" name="service_id" placeholder="Service ID" value="<?php echo $data->service_id; ?>">
                        <label for="service_id">Service ID</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="text" name="text" placeholder="Текст" value="<?php echo $data->text; ?>">
                        <label for="text">Текст</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="number" name="number" placeholder="Номер" value="<?php echo $data->number; ?>">
                        <label for="number">Номер</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="credits" name="credits" placeholder="Кредити" value="<?php echo $data->credits; ?>">
                        <label for="credits">Кредити</label>
                    </div>

                    <?php echo csrf_token(); ?>

                    <button type="submit" name="change" class="btn btn-primary btn-block mb-4">Промени</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once './public/layouts/footer.php'; ?>
</body>
</html>
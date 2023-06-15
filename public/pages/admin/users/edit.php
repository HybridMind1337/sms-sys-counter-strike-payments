<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Промяна на потребител &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>

</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Промяна на потребител</div>
            <div class="card-body">
                <div class="alert alert-info" role="alert" data-mdb-color="danger">
                    В момента променята баланса на потребител с е-майл <strong><?php echo $data->email; ?></strong>. Уникален номер: <strong><?php echo $data->id; ?></strong>
                </div>
                <form method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Наличен кредит</span>
                        <span class="input-group-text"><?php echo $data->balance; ?></span>
                        <input type="number" class="form-control" name="balance">
                    </div>
                    <?php echo csrf_token(); ?>
                    <button class="mt-3 w-100 btn btn-lg btn-primary" name='add' type="submit">Добави</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once './public/layouts/footer.php'; ?>
</body>
</html>
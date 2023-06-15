<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Купуване на реклама във форума &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>
</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Купуване на реклама във форума</div>
            <div class="card-body">

                <div class="alert alert-info text-center" role="alert" data-mdb-color="success">
                    <h4 class="alert-heading">Информация за услугата</h4>
                    <p>
                        Във форума на нашия сайт предлагаме нова възможност за рекламиране на вашата фирма, продукт или услуга!<br />
                        Само за <b><?php echo $data->price; ?></b> кредита, можете да закупите реклама, която ще бъде валидна за цели <b><?php echo $data->valid; ?></b> дни!
                    </p>
                </div>

                <form method="POST">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="sitename" name="sitename" placeholder="Име на сайта">
                        <label for="sitename">Име на сайта</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="url" class="form-control" id="url" name="url" placeholder="Линк към сайта">
                        <label for="url">Линк към сайта</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="url" class="form-control" id="image" name="image" placeholder="Линк към банера (468х60)">
                        <label for="image">Линк към банера (468х60)</label>
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
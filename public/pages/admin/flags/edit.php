<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Промяна на привилегии &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>

</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Промяна на привилегии</div>
            <div class="card-body">

                <form method="POST">

                    <div class="form-floating mb-3">
                        <select class="form-select" name="server_id">
                            <?php
                            if ($servers):
                                foreach ($servers as $value): ?>
                                    <option value="<?php echo $value->id; ?>" <?php echo checkSelected($data->server_id, $value->id); ?>><?php echo $value->hostname; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                        <label for="floatingSelect">Изберете сървър</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Име на продукта" value="<?php echo $data->name; ?>">
                        <label for="name">Име на продукта</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="flags" name="flags" placeholder="Флагове (Пример: abcd)" value="<?php echo $data->flags; ?>">
                        <label for="flags">Флагове (Пример: abcd)</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="valid" name="valid" placeholder="Валиден за (в дни)" value="<?php echo $data->valid; ?>">
                        <label for="valid">Валиден за (в дни)</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="credits" name="credits" placeholder="Цена в кредити" value="<?php echo $data->credits; ?>">
                        <label for="valid">Цена в кредити</label>
                    </div>

                    <?php echo csrf_token(); ?>

                    <button type="submit" name="edit" class="btn btn-primary btn-block mb-4">Промени</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once './public/layouts/footer.php'; ?>
</body>
</html>
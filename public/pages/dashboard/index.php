<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Начална страница &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>
</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Последни транзакции</div>
            <div class="card-body">
                <?php if ($transactions): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-sm ">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Услуга</th>
                                <th scope="col">Кредити</th>
                                <th scope="col">Дата</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <th scope="row"><?php echo $transaction->id; ?></th>
                                    <td><?php echo $transaction->service; ?></td>
                                    <td><?php echo $transaction->balance; ?></td>
                                    <td><?php echo formatDate($transaction->date); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <a href="<?php echo SITE_URL; ?>transactions" class="btn btn-info">Всички транзакции</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Нямате транзакции за момента
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">

        <div class="card">
            <div class="card-header">Хронология</div>
            <div class="card-body">

                <?php if ($chronology): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-sm ">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Заредено чрез</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Кредити</th>
                                <th scope="col">Дата</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($chronology as $value): ?>
                                <tr>
                                    <th scope="row"><?php echo $value->id; ?></th>
                                    <td><?php echo $value->type; ?></td>
                                    <td><?php echo $value->amount; ?>лв.</td>
                                    <td><?php echo $value->balance; ?></td>
                                    <td><?php echo formatDate($value->date); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <a href="<?php echo SITE_URL; ?>chronology" class="btn btn-info">Виж цялата хронология</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Нямате намерена хронология за момента
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>
<?php require_once './public/layouts/footer.php'; ?>
</body>
</html>
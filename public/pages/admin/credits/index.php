<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Управление на кредитите &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Управление на SMS кредитите</div>
            <div class="card-body">
                <?php if ($data): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-sm" id="datatable" data-mdb-hover="true" data-mdb-bordered="true" data-mdb-striped="true" data-mdb-sm="true">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">USER ID</th>
                                <th scope="col">SERVICE ID</th>
                                <th scope="col">Текст/Номер</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Кредити</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data as $value): ?>
                                <tr>
                                    <th scope="row"><?php echo $value->id; ?></th>
                                    <td><?php echo $value->user_id; ?></td>
                                    <td><?php echo $value->service_id; ?></td>
                                    <td><?php echo $value->text; ?> / <?php echo $value->number; ?></td>
                                    <td><?php echo $value->amount; ?></td>
                                    <td><?php echo $value->credits; ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo SITE_URL; ?>admin/credits/edit/<?php echo $value->id; ?>" class="btn btn-primary btn-sm">
                                            Промени
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert" role="alert" data-mdb-color="danger">
                        Няма намерена информация
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Управление на рекламата във форума</div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="price" name="price" placeholder="Цена за реклама във форума" value="<?php echo $prices->price; ?>">
                        <label for="price">Цена за реклама във форума</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="valid" name="valid" placeholder="Колко време да е валидна реклмата (в дни)" value="<?php echo $prices->valid; ?>">
                        <label for="price">Колко време да е валидна реклмата (в дни)</label>
                    </div>

                    <?php echo csrf_token(); ?>

                    <button type="submit" name="change" class="btn btn-primary btn-block mb-4">Промени</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once './public/layouts/footer.php'; ?>
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#datatable').DataTable();
    } );
</script>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Всички транзакции &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Всички транзакции</div>
            <div class="card-body">
                <?php if ($transactions): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-sm" id="datatable" data-mdb-hover="true" data-mdb-bordered="true" data-mdb-striped="true" data-mdb-sm="true">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Услуга</th>
                                <th scope="col">Кредити</th>
                                <th scope="col">Дата</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($transactions as $value): ?>
                                <tr>
                                    <th scope="row"><?php echo $value->id; ?></th>
                                    <td><?php echo $value->service; ?></td>
                                    <td><?php echo $value->balance; ?></td>
                                    <td><?php echo formatDate($value->date); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert" role="alert" data-mdb-color="danger">
                        Няма намарени транзакции
                    </div>
                <?php endif; ?>
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
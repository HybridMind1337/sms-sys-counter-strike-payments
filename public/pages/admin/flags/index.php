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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Управление на SMS кредитите</div>
            <div class="card-body">
                <div class="d-grid gap-2 mb-3">
                    <a href="<?php echo SITE_URL; ?>admin/flags/create" class="btn btn-success">Създай</a>
                </div>
                <?php if ($data): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover table-bordered table-sm" id="datatable" data-mdb-hover="true" data-mdb-bordered="true" data-mdb-striped="true" data-mdb-sm="true">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Сървър</th>
                                <th scope="col">Име</th>
                                <th scope="col">Флагове</th>
                                <th scope="col">Валиден за</th>
                                <th scope="col">Кредити</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data as $value): ?>
                                <tr>
                                    <th scope="row"><?php echo $value->id; ?></th>
                                    <td><?php echo $value->server_id; ?></td>
                                    <td><?php echo $value->name; ?></td>
                                    <td><?php echo $value->flags; ?></td>
                                    <td><?php echo $value->valid; ?></td>
                                    <td><?php echo $value->credits; ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo SITE_URL; ?>admin/flags/edit/<?php echo $value->id; ?>" class="btn btn-primary btn-sm">
                                            Промени
                                        </a>
                                        <a href="<?php echo SITE_URL; ?>admin/flags/remove/<?php echo $value->id; ?>" class="btn btn-danger btn-sm">
                                            Изтрий
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
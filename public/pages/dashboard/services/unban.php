<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Премахване на бан &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>
</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Премахване на бан</div>
            <div class="card-body">

                <div class="alert alert-info" role="alert" data-mdb-color="success">
                    <h4 class="alert-heading">Информация за бана</h4>
                    <p>
                        Име на сървъра: <strong><?php echo $ban_details->server_name; ?></strong><br />
                        IP на сървъра: <strong><?php echo $ban_details->server_ip; ?></strong><br />
                        Банат от <strong><?php echo $ban_details->admin_nick; ?></strong><br />
                        Време на бана <strong><?php echo minutsToWords($ban_details->ban_length); ?></strong><br />
                    </p>
                    <hr/>
                    <p class="mb-0">
                        Премахването на бана ще Ви струва <b><?php echo UNBAN_PRICE; ?></b> кредита.
                    </p>
                </div>

                <form method="POST">
                    <button type="submit" name="remove" class="btn btn-primary btn-block mb-4">Премахни бана</button>
                </form>
            </div>
        </div>
    </div>

</div>
<?php require_once './public/layouts/footer.php'; ?>
</body>
</html>
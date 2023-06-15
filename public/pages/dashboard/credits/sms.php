<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Зареждане, чрез SMS &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>
</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Зареждане на кредити, чрез SMS</div>
            <div class="card-body">

                <div class="alert bg-success text-white" role="alert" data-mdb-color="success">
                    <h4 class="alert-heading">Купуване на точки</h4>
                    <p>
                        Със закупените точки можете да закупите от нашите VIP привилегии. Точките се натрупват във Вашия профил и могат да бъдат използвани по всяко време.
                    </p>
                    <hr/>
                    <p class="mb-0">
                        При плащането, чрез SMS вие получавате по-малко точки, поради високите такси, които плащаме.
                    </p>
                </div>

                <form method="POST">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="sms_data">
                            <?php
                            if ($data):
                                foreach ($data as $sms): ?>
                                    <option value="<?php echo $sms->id; ?>">Цена: <strong><?php echo $sms->amount; ?></strong> Кредити:
                                        <strong><?php echo $sms->credits; ?></strong></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                        <label for="floatingSelect">Изберете SMS</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="sms_code" name="sms_code" placeholder="SMS Код">
                        <label for="sms_code">SMS Код</label>
                    </div>

                    <button type="submit" name="buy" class="btn btn-primary btn-block mb-4">Зареди</button>
                </form>
            </div>
        </div>
    </div>

</div>
<?php require_once './public/layouts/footer.php'; ?>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Закупуване на флагове &bull; <?php echo SITE_NAME; ?></title>
    <?php require_once './public/layouts/metas.php'; ?>

</head>
<body>
<?php require_once './public/layouts/navbar.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Закупуване на флагове</div>
            <div class="card-body">
                <div class="accordion" id="accordionExampleY">
                    <?php if ($servers):
                        foreach ($servers as $server): ?>
                            <div class="accordion-item" id="server-container-<?php echo $server->id; ?>">
                                <h2 class="accordion-header" id="heading<?php echo $server->id; ?>">
                                    <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse"
                                            data-mdb-target="#collapse<?php echo $server->id; ?>" aria-expanded="false" aria-controls="collapse<?php echo $server->id; ?>">
                                        <i class="fas fa-question-circle fa-sm me-2 opacity-70"></i>
                                        <?php echo $server->hostname; ?>
                                    </button>
                                </h2>
                                <div id="collapse<?php echo $server->id; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $server->id; ?>"
                                     data-mdb-parent="#accordionExampleY">
                                    <div class="accordion-body">
                                        <div id="ajax-content-<?php echo $server->id; ?>"></div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; else: ?>
                        <div class="alert alert-danger text-center">
                            Няма намарена инфомрация за добавени сървъри към бан листа.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once './public/layouts/footer.php'; ?>
<script>
    $(document).ready(function () {

        $('.accordion-item').each(function () {
            var server_id = $(this).attr('id').match(/\d+/)[0];
            var ajax_content = $('#ajax-content-' + server_id);
            ajax_content.html('<div class="loading-spinner"></div>');

            $.ajax({
                type: 'GET',
                url: '<?php echo SITE_URL; ?>ajax/flags',
                data: {
                    server_id: server_id,
                },
                success: function (response) {
                    ajax_content.html(response);
                },
                error: function (xhr, status, error) {
                    console.log('Error occurred:', error);
                }
            });
        });
    });
</script>
</body>
</html>
<?php helper('url'); ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>
<body class="bg-light">
<?= $this->renderSection('content') ?>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
<?= $this->renderSection('scripts') ?>
<script>
    $(function () {
        $(document).on('submit', '.needs-validation', function (event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            $(this).addClass('was-validated');
        });
    });
</script>
</body>
</html>

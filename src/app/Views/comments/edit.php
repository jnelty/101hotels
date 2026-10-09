<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Редактирование комментария<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="container py-4">
    <div class="card mx-auto" style="max-width: 720px;">
        <div class="card-body">
            <h1 class="h4 mb-3">Редактирование комментария #<?= esc($comment['id']) ?></h1>

            <?php $errors = session()->getFlashdata('errors') ?? []; ?>
            <?php if ($errors): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ((array) $errors as $validationError): ?>
                        <div><?= esc($validationError) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= esc('/comments/' . $comment['id'] . '/edit', 'attr') ?>" method="post" class="needs-validation" novalidate>
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="text">Текст</label>
                    <textarea class="form-control" id="text" name="text" rows="6" required><?= esc(old('text', $comment['content'], false)) ?></textarea>
                    <div class="invalid-feedback">Введите текст комментария.</div>
                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="/comments" class="btn btn-outline-secondary">Отмена</a>
            </form>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

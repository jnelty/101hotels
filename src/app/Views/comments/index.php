<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Комментарии<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Комментарии</h1>
        <a href="<?= esc($logoutUrl ?? '/logout', 'attr') ?>" class="btn btn-outline-secondary btn-sm">Выйти</a>
    </div>

    <?php if ($message = session()->getFlashdata('message')): ?>
        <div class="alert alert-success" role="alert"><?= esc($message) ?></div>
    <?php endif; ?>

    <?php if ($error = session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert"><?= esc($error) ?></div>
    <?php endif; ?>

    <form action='/comments' method="get" class="form-inline mb-3">
        <label for="sort" class="mr-2">Сортировать:</label>
        <select name="sort" id="sort" class="form-control form-control-sm mr-2">
            <option value="id" <?= $sort === 'id' ? 'selected' : '' ?>>по ID</option>
            <option value="date" <?= $sort === 'date' ? 'selected' : '' ?>>по дате</option>
        </select>
        <select name="direction" class="form-control form-control-sm mr-2" aria-label="Направление сортировки">
            <option value="asc" <?= $direction === 'asc' ? 'selected' : '' ?>>по возрастанию</option>
            <option value="desc" <?= $direction === 'desc' ? 'selected' : '' ?>>по убыванию</option>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm">Применить</button>
    </form>

    <section aria-label="Список комментариев">
        <?php if (empty($comments)): ?>
            <div class="alert alert-secondary">Комментариев пока нет.</div>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <?php $isOwnComment = (int) $comment['user_id'] === $currentUserId; ?>
                <article class="card mb-3<?= $isOwnComment ? ' border-primary' : '' ?>" data-comment-id="<?= esc($comment['id'], 'attr') ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h2 class="h6 card-title mb-1">
                                <?= esc($comment['email'] ?? 'Удалённый пользователь') ?>
                                <?php if ($isOwnComment): ?>
                                    <span class="badge badge-primary ml-2">Ваш комментарий</span>
                                <?php endif; ?>
                            </h2>
                            <small class="text-muted">
                                ID: <?= esc($comment['id']) ?> · <?= esc($comment['date'] ?? '') ?>
                            </small>
                        </div>
                        <p class="card-text mb-3"><?= nl2br(esc($comment['text'] ?? '')) ?></p>

                        <?php if ($isOwnComment): ?>
                            <div class="d-flex">
                                <a href="<?= esc('/comments/' . $comment['id'] . '/edit', 'attr') ?>" class="btn btn-outline-primary btn-sm mr-2">Редактировать</a>
                                <form action="<?= esc('/comments/' . $comment['id'] . '/delete', 'attr') ?>" method="post" class="delete-form">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <?= $pager->links('default', 'bootstrap_full') ?>

    <div class="card mt-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Добавить комментарий</h2>

            <?php $errors = session()->getFlashdata('errors') ?? []; ?>
            <?php if ($errors): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ((array) $errors as $validationError): ?>
                        <div><?= esc($validationError) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= esc($commentsUrl ?? '/comments', 'attr') ?>" method="post" class="needs-validation" novalidate>
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="text">Текст</label>
                    <textarea class="form-control" id="text" name="text" rows="4" required><?= esc(old('text', '', false)) ?></textarea>
                    <div class="invalid-feedback">Введите текст комментария.</div>
                </div>

                <button type="submit" class="btn btn-primary">Добавить</button>
            </form>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(function () {
        $('.delete-form').on('submit', function (event) {
            if (!window.confirm('Удалить комментарий?')) {
                event.preventDefault();
            }
        });
    });
</script>
<?= $this->endSection() ?>

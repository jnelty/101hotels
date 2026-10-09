<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Регистрация<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-4">Регистрация</h1>

                    <?php $errors = session()->getFlashdata('errors') ?? []; ?>
                    <?php if ($errors): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ((array) $errors as $error): ?>
                                <div><?= esc($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form action='/register' method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?= esc(old('email', '', false), 'attr') ?>"
                                autocomplete="email"
                                required
                            >
                            <div class="invalid-feedback">Введите корректный email.</div>
                        </div>

                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                minlength="6"
                                autocomplete="new-password"
                                required
                            >
                            <div class="invalid-feedback">Минимум 6 символов.</div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">Повторите пароль</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password-confirm"
                                name="password_confirm"
                                autocomplete="new-password"
                                required
                            >
                            <div class="invalid-feedback">Пароли должны совпадать.</div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                    </form>

                    <p class="text-center mb-0 mt-3">
                        Уже есть аккаунт? <a href="<?= esc($loginUrl ?? '/login', 'attr') ?>">Войти</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(function () {
        $('.needs-validation').on('submit', function () {
            var password = $('#password').val();
            var confirmation = $('#password-confirm').val();

            $('#password-confirm')[0].setCustomValidity(
                password === confirmation ? '' : 'Пароли не совпадают'
            );
        });

        $('#password, #password-confirm').on('input', function () {
            $('#password-confirm')[0].setCustomValidity('');
        });
    });
</script>
<?= $this->endSection() ?>

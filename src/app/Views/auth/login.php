<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Вход<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-4">Вход</h1>

                    <?php // Флэш-сообщения для отображения серверных ошибок. ?>
                    <?php if ($error = session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger" role="alert"><?= esc($error) ?></div>
                    <?php endif; ?>

                    <?php if ($message = session()->getFlashdata('message')): ?>
                        <div class="alert alert-success" role="alert"><?= esc($message) ?></div>
                    <?php endif; ?>

                    <form action='/login' method="post" class="needs-validation" novalidate>
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
                                autocomplete="current-password"
                                required
                            >
                            <div class="invalid-feedback">Введите пароль.</div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Войти</button>
                    </form>

                    <p class="text-center mb-0 mt-3">
                        Нет аккаунта? <a href="<?= esc($registerUrl ?? '/register', 'attr') ?>">Зарегистрироваться</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

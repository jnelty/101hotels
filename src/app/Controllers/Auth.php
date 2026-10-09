<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function registerForm(): string
    {
        return view('auth/register');
    }

    public function register()
    {
        if (! $this->validate('registerUser')) {
            return redirect()
                ->to('/register')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {
            $userId = (new UserModel())->insert([
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ]);
        } catch (DatabaseException $exception) {
            log_message('error', $exception->getMessage());

            return redirect()
                ->to('/register')
                ->withInput()
                ->with('errors', ['email' => 'Не удалось создать пользователя.']);
        }

        if ($userId === false) {
            return redirect()
                ->to('/register')
                ->withInput()
                ->with('errors', ['email' => 'Не удалось создать пользователя.']);
        }

        return redirect()
            ->to('/login')
            ->with('message', 'Регистрация завершена.');
    }

    public function loginForm(): string
    {
        return view('auth/login');
    }

    public function login(): RedirectResponse
    {
        if (! $this->validate('loginUser')) {
            return redirect()
                ->to('/login')
                ->withInput()
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = (new UserModel())
            ->where('email', $email)
            ->first();

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()
                ->to('/login')
                ->withInput()
                ->with('error', 'Неверный email или пароль.');
        }

        session()->regenerate(true);
        session()->set([
            'user_id' => (int) $user['id'],
            'email' => $user['email'],
        ]);

        return redirect()->to('/comments');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}

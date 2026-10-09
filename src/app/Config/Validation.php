<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $loginUser = [
        'email' => [
            'label'  => 'Email',
            'rules'  => 'required|valid_email',
            'errors' => [
                'required'    => 'Введите email.',
                'valid_email' => 'Введите корректный email.',
            ],
        ],
        'password' => [
            'label'  => 'Пароль',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Введите пароль.',
            ],
        ],
    ];

    public array $registerUser = [
        'email' => [
            'label'  => 'Email',
            'rules'  => 'required|valid_email|max_length[255]|is_unique[users.email]',
            'errors' => [
                'required'    => 'Введите email.',
                'valid_email' => 'Введите корректный email.',
                'max_length'  => 'Email не должен превышать 255 символов.',
                'is_unique'   => 'Пользователь с таким email уже существует.',
            ],
        ],
        'password' => [
            'label'  => 'Пароль',
            'rules'  => 'required|min_length[6]',
            'errors' => [
                'required'   => 'Введите пароль.',
                'min_length' => 'Пароль должен содержать минимум 6 символов.',
            ],
        ],
        'password_confirm' => [
            'label'  => 'Подтверждение пароля',
            'rules'  => 'required|matches[password]',
            'errors' => [
                'required' => 'Повторите пароль.',
                'matches'  => 'Пароли не совпадают.',
            ],
        ],
    ];

    public array $newComment = [
        'text' => [
            'label'  => 'Комментарий',
            'rules'  => 'required|max_length[5000]',
            'errors' => [
                'required'   => 'Введите текст комментария.',
                'max_length' => 'Комментарий не должен превышать 5000 символов.',
            ],
        ],
    ];

    public array $commentsQuery = [
        'sort' => [
            'label' => 'Поле сортировки',
            'rules' => 'required|in_list[id,date]',
        ],
        'direction' => [
            'label' => 'Направление сортировки',
            'rules' => 'required|in_list[asc,desc]',
        ],
        'page' => [
            'label' => 'Номер страницы',
            'rules' => 'required|string|is_natural_no_zero',
        ],
    ];
}

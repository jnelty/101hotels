<?php

namespace App\Repositories;

use App\DTO\CommentsQuery;
use App\Models\CommentModel;
use CodeIgniter\I18n\Time;

readonly class CommentRepository
{
    public function __construct(
        private CommentModel $commentModel = new CommentModel()
    )
    {
    }

    public function getPage(CommentsQuery $query, int $perPage): array
    {
        $sortColumns = [
            'id' => 'comments.id',
            'date' => 'comments.date',
        ];

        $this->commentModel
            ->select('comments.id, comments.user_id, comments.content AS text, comments.date, users.email')
            ->join('users', 'users.id = comments.user_id', 'left')
            ->orderBy($sortColumns[$query->sort], strtoupper($query->direction));

        if ($query->sort === 'date') {
            $this->commentModel->orderBy('comments.id', strtoupper($query->direction));
        }

        return [
            'comments' => $this->commentModel->paginate($perPage, 'default', $query->page),
            'pager' => $this->commentModel->pager,
        ];
    }

    public function add(int $userId, string $content): void
    {
        $this->commentModel->insert([
            'user_id' => $userId,
            'content' => $content,
            'date' => Time::now(app_timezone())->toDateTimeString(),
        ]);
    }

    public function findOwnedById(int $id, int $userId): ?array
    {
        return $this->commentModel
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function update(int $id, string $content): void
    {
        $this->commentModel->update($id, ['content' => $content]);
    }

    public function delete(int $id): void
    {
        $this->commentModel->delete($id);
    }
}

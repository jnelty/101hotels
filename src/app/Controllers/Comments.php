<?php

namespace App\Controllers;

use App\DTO\CommentsQuery;
use App\Repositories\CommentRepository;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class Comments extends BaseController
{
    private const COMMENTS_PER_PAGE = 3;


    public function __construct(
        private readonly CommentRepository $commentRepository = new CommentRepository())
    {
    }

    public function index(): string
    {
        $queryData = CommentsQuery::queryToArray($this->request->getGet());

        $query = $this->validateData($queryData, 'commentsQuery')
            ? CommentsQuery::fromQuery($queryData)
            : new CommentsQuery();

        $page = $this->commentRepository->getPage($query, self::COMMENTS_PER_PAGE);

        return view('comments/index', [
            'comments' => $page['comments'],
            'currentUserId' => session()->get('user_id'),
            'sort' => $query->sort,
            'direction' => $query->direction,
            'pager' => $page['pager'],
        ]);
    }

    public function store(): RedirectResponse
    {
        if (! $this->validate('newComment')) {
            return redirect()
                ->to('/comments')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->commentRepository->add(
            (int) session()->get('user_id'),
            (string) $this->request->getPost('text')
        );

        return redirect()
            ->to('/comments')
            ->with('message', 'Комментарий добавлен.');
    }

    public function edit(int $id): string|RedirectResponse
    {
        $comment = $this->commentRepository->findOwnedById($id, session()->get('user_id'));

        if ($comment === null) {
            return $this->forbiddenError();
        }

        return view('comments/edit', ['comment' => $comment]);
    }

    public function update(int $id): RedirectResponse
    {
        if ($this->commentRepository->findOwnedById($id, session()->get('user_id')) === null) {
            return $this->forbiddenError();
        }

        if (! $this->validate('newComment')) {
            return redirect()
                ->to('/comments/' . $id . '/edit')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->commentRepository->update($id, $this->request->getPost('text'));

        return redirect()
            ->to('/comments')
            ->with('message', 'Комментарий обновлён.');
    }

    public function delete(int $id): RedirectResponse
    {
        if ($this->commentRepository->findOwnedById($id, session()->get('user_id')) === null) {
            return $this->forbiddenError();
        }

        $this->commentRepository->delete($id);

        return redirect()
            ->to('/comments')
            ->with('message', 'Комментарий удалён.');
    }

    private function forbiddenError(): RedirectResponse
    {
        return redirect()
            ->to('/comments')
            ->with('error', 'Комментарий не найден или у вас нет прав на это действие.');
    }

}

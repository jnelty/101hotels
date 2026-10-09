<?php

namespace App\DTO;

final class CommentsQuery
{
    private const DEFAULT_SORT = 'id';
    private const DEFAULT_DIRECTION = 'desc';
    private const DEFAULT_PAGE = 1;

    public string $sort;
    public string $direction;
    public int $page;

    public function __construct(
        string $sort = self::DEFAULT_SORT,
        string $direction = self::DEFAULT_DIRECTION,
        int $page = self::DEFAULT_PAGE
    ) {
        $this->sort = $sort;
        $this->direction = $direction;
        $this->page = $page;
    }

    public static function queryToArray(array $query): array
    {
        return [
            'sort' => $query['sort'] ?? self::DEFAULT_SORT,
            'direction' => $query['direction'] ?? self::DEFAULT_DIRECTION,
            'page' => $query['page'] ?? (string) self::DEFAULT_PAGE,
        ];
    }

    public static function fromQuery(array $query): self
    {
        return new self(
            $query['sort'],
            $query['direction'],
            (int) $query['page']
        );
    }
}

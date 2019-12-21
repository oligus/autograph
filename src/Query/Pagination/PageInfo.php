<?php declare(strict_types=1);

namespace Autograph\Query\Pagination;

class PageInfo
{
    private ?int $totalCount;
    private PageInfoType $pageInfoType;

    private bool $hasNextPage = false;
    private bool $hasPreviousPage = false;

    private string $startCursor = '';
    private string $endCursor = '';

    public function __construct(?int $totalCount)
    {
        $this->totalCount = $totalCount;
        $this->pageInfoType = new PageInfoType();
    }

    /**
     * @return PageInfoType
     */
    public function getPageInfoType(): PageInfoType
    {
        return $this->pageInfoType;
    }

    public function resolve()
    {
        return [
            'hasNextPage' => $this->hasNextPage,
            'hasPreviousPage' => $this->hasPreviousPage,
            'startCursor' => $this->startCursor,
            'endCursor' => $this->endCursor
        ];
    }
}

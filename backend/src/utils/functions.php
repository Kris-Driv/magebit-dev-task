<?php

function paginate(array $items, int $limit, int $page) : array
{
    $pages = array_chunk($items, $limit, false);
    $maxPage = count($pages);
    $page = max(min($page, $maxPage), 1);

    $nextPage = $page + 1;
    $nextPage = isset($pages[$nextPage]) ? $nextPage : null;

    $prevPage = $page - 2;
    $prevPage = isset($pages[$prevPage]) ? $prevPage + 1 : null;

    $items = $pages[$page-1];

    return [
        "items" => $items,
        "page" => $page,
        "total-pages" => $maxPage,
        "next" => $nextPage,
        "previous" => $prevPage,
        "limit" => $limit,
        "total" => count($items)
    ];
}
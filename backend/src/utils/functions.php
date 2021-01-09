<?php

function paginate(array $items, int $limit, int $page) : array
{
    $pages = array_chunk($items, $limit, false);
    $maxPage = count($pages);
    $page = max(min($page, $maxPage), 1);

    $nextPage = $page;
    $nextPage = isset($pages[$nextPage]) ? $nextPage + 1 : null;

    $prevPage = $page - 2;
    $prevPage = isset($pages[$prevPage]) ? $prevPage + 1 : null;

    $items = $pages[$page-1] ?? [];

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

function filter(array $items, string $match) : array {
    $ret = [];
    $match = strtolower($match);
    foreach($items as $item) {
        if(strpos($item["email"], $match) === false) continue;
        $ret[] = $item;
    }
    return $ret;
}
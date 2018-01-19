<?php

namespace App\Traits;

use App\User;
use App\Event;
use App\Team;
use App\Rejection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
trait Utilities{
private function paginate($page, $perPage, $items)
    {
        $offSet = ($page * $perPage) - $perPage;
        $itemsForCurrentPage = $items->slice($offSet, $perPage);
        return new LengthAwarePaginator(
            $itemsForCurrentPage, $items->count(), $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}
<?php

namespace App\Traits\Movie\Genre;

use App\Constants\Query;
use Illuminate\Database\Eloquent\Builder;

trait MovieGenreSort
{
    public function scopeApplySort(Builder $query, ?string $sort): Builder
    {
        return match ($sort)
        {
            'id_asc' => $query->sortByColumn
            (
                column: Query::COLUMN_ID,
                direction: Query::SORT_ASC
            ),

            'id_desc' => $query->sortByColumn
            (
                column: Query::COLUMN_ID,
                direction: Query::SORT_DESC
            ),

            default => $query->orderBy
            (
                Query::COLUMN_ID,
                Query::SORT_DESC
            )
        };
    }

    public function scopeSortByColumn(Builder $query, string $column, string $direction): Builder
    {
        return $query->orderBy
        (
            $column,
            $direction
        );
    }
}
<?php

namespace App\Traits;

trait Searchable
{
    /**
     * Scope a query to search across defined searchable columns.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (!$term || !property_exists($this, 'searchable')) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            foreach ($this->searchable as $column) {
                $q->orWhere($column, 'LIKE', '%' . $term . '%');
            }
        });
    }
}

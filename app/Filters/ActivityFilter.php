<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class ActivityFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function categoria($categoria): ActivityFilter
    {
        return $this->whereIn('categoria_id', $categoria);
    }
}

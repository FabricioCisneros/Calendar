<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class NominaFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];


    public function search($search):NominaFilter
    {
        return $this->where('nombre','LIKE', '%'.$search.'%')
                    ->orWhere('noempleado','LIKE','%'.$search.'%');
    }

    public function oficinas($oficina): NominaFilter
    {
        return $this->WhereIn('oficina', $oficina);
    }

    public function noempleado($noempleado):NominaFilter
    {
        return $this->where('noempleado','LIKE', '%'.$noempleado.'%');
    }
}

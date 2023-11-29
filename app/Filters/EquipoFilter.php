<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class EquipoFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
    public function search($search): EquipoFilter
    {
        return $this->where('numero_serie', 'LIKE', '%'.$search.'%');
    }

    public function modelo($modelo): EquipoFilter
    {
        return $this->where('modelo', 'LIKE', '%'.$modelo.'%');
    }

    public function numero_serie($numero_serie): EquipoFilter
    {
        return $this->where('numero_serie', 'LIKE', '%'.$numero_serie.'%');
    }
    public function categorias($categoria): EquipoFilter
    {
        return $this->whereIn('categoria_id', $categoria);
    }

    public function oficinas($oficina): EquipoFilter
    {
        return $this->whereIn('oficina_id', $oficina);
    }

    public function statuses($statuses): EquipoFilter
    {
        return $this->whereIn('status_id', $statuses);
    }
}

<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class TicketFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function search($search): TicketFilter
    {
        return $this->where('numero_serie', 'LIKE', '%'.$search.'%');
    }

    public function modelo($modelo): TicketFilter
    {
        return $this->where('modelo', 'LIKE', '%'.$modelo.'%');
    }

    public function numero_serie($numero_serie): TicketFilter
    {
        return $this->where('numero_serie', 'LIKE', '%'.$numero_serie.'%');
    }


    public function categorias($categoria): TicketFilter
    {
        return $this->whereIn('categoria_id', $categoria);
    }

    public function oficinas($oficina): TicketFilter
    {
        return $this->whereIn('oficina_id', $oficina);
    }

    public function statuses($statuses): TicketFilter
    {
        return $this->whereIn('status_id', $statuses);
    }

}

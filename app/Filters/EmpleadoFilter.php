<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class EmpleadoFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];
    public function search($search): EmpleadoFilter
    {
        return $this->where('name', 'LIKE', '%'.$search.'%')
        ->orWhere('email', 'LIKE', '%'.$search.'%')
        ->orWhere('apellidos', 'LIKE', '%'.$search.'%')
        ->orWhere('telefono', 'LIKE', '%'.$search.'%');
    }

    public function nombre($nombre):EmpleadoFilter
    {
        return $this->where('name','LIKE','%'.$nombre.'%')
        ->orWhere('apellidos', 'LIKE', '%'.$nombre.'%');
    }
    
    public function correo($correo):EmpleadoFilter
    {
        return $this->where('email','LIKE','%',$correo.'%');
    }
    public function turnos($turno):EmpleadoFilter
    {
        return $this->whereIn('turno_id', $turno);
    }
    public function oficinas($oficina): EmpleadoFilter
    {
        return $this->whereIn('oficina_id', $oficina);
    }
}

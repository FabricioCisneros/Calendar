<?php 

namespace App\Filters;

use App\Models\Directorio;
use App\Models\Empleado;
use App\Models\Equipo;
use App\Models\Nomina;
use App\Models\Ticket;
use EloquentFilter\ModelFilter;
use App\Filters\NominaFilter;

class DirectorioFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function searchEmpleado($searchEmpleado):DirectorioFilter
    {
        $empleadoId=Nomina::where('nombre', 'LIKE', '%'.$searchEmpleado.'%')
                            ->orWhere('noempleado', 'LIKE', '%'.$searchEmpleado.'%')
                            ->pluck('id');

        return $this->whereIn('nomina_id', $empleadoId);
    }

    public function estatusDirectorio($estatusDirectorio): DirectorioFilter
    {
        return $this->where('estatus_directorio',$estatusDirectorio);
    }


    public function oficinasEmpleado($oficinasEmpleado): DirectorioFilter
    {
        $oficinaEmpleado=Nomina::where('oficina',$oficinasEmpleado)->pluck('id');

        return $this->whereIn('nomina_id',$oficinaEmpleado);
    }
    public function turnoEmpleado($turnoEmpleado):DirectorioFilter
    {
        $turnoEmpleadoList=Nomina::where('turno',$turnoEmpleado)->pluck('id');

        return $this->whereIn('nomina_id', $turnoEmpleadoList);
    }

    public function NsModelo($NsModelo):DirectorioFilter
    {
        $NsModeloList=Equipo::where('modelo', 'LIKE', '%'.$NsModelo.'%')
                               ->orWhere('numero_serie', 'LIKE', '%'.$NsModelo.'%')
                               ->pluck('id');
        
        return $this->whereIn('equipo_id', $NsModeloList);

        }
    
    public function oficinasEquipo($oficinaEquipo){
        $oficinaList=Equipo::where('oficina_id',$oficinaEquipo)->pluck('id');
        return $this->whereIn('equipo_id',$oficinaList);
    }

    // public function oficinasEquipo($oficinaEquipo):DirectorioFilter
    //     {

    //         $oficinaEquipoList=Ticket::where('oficina_id',$oficinaEquipo)->pluck('id');
    //         return $this->whereIn('ticket_id',$oficinaEquipoList);
    //     }
    



}

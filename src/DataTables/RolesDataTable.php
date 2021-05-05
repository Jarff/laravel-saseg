<?php

namespace App\DataTables;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class RolesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('<input type="checkbox" class="" id="customCheck">', function($row){
                return '<input type="checkbox" class="" id="customCheck'.$row->id.'" value="'.$row->id.'">';
            })
            ->editColumn('default', function($row){
                return ($row->default) ?
                '<span class="badge badge-pill badge-lg badge-success">Sí</span>' :
                '<span class="badge badge-pill badge-lg badge-warning">No</span>';
            })
            ->addColumn('Acciones', function($row){
                if($row->deletable){
                    $dlt = '<a onclick="swalAction(this)" href="#!" class="btn btn-sm btn-link text-danger" data-title="¿Esta seguro?" data-text="Este registro se eliminará" data-swal-icon="question" data-axios-method="delete" data-route="'.route('panel.roles.destroy', ['id' => $row->id]).'" data-action="location.reload()"><i class="fas fa-trash-alt"></i> Eliminar</a>';
                }else{
                    $dlt = '';
                }
                $btn = '
                    <a href="'.route('panel.roles.edit', ['id' => $row->id]).'" class="btn btn-sm btn-link text-success"><i class="fas fa-edit"></i></i>Editar</a>
                    '.$dlt.'
                ';
                return $btn;
            })
            ->rawColumns(['Acciones', 'default', '<input type="checkbox" class="" id="customCheck">']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('roles-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('<input type="checkbox" class="" id="customCheck">')
            ->width(90)
            ->addClass('text-center'),
            ['data' => 'name', 'title' => "Nombre Rol"],
            ['data' => 'guard_name', 'title' => "Nombre Guard"],
            ['data' => 'default', 'title' => "Rol Defecto"],
            Column::computed('Acciones')
            ->width(90)
            ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Roles_' . date('YmdHis');
    }
}

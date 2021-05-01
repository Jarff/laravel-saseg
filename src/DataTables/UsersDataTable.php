<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class UsersDataTable extends DataTable
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
            ->editColumn('name', function($row){
                return '<a href="'.route('panel.admins.edit', ['id' => $row->id]).'">'.$row->name.'</a>';
            })
            ->addColumn('Acciones', function($row){
                $btn = '
                    <a href="'.route('panel.admins.edit', ['id' => $row->id]).'" class="btn btn-sm btn-link text-success"><i class="fas fa-edit"></i></i>Editar</a>
                    <a onclick="swalAction(this)" href="#!" class="btn btn-sm btn-link text-danger" data-title="¿Esta seguro?" data-text="Este registro se eliminará" data-swal-icon="question" data-axios-method="delete" data-route="'.route('panel.admins.destroy', ['id' => $row->id]).'" data-action="location.reload()"><i class="fas fa-trash-alt"></i> Eliminar</a>
                ';
                return $btn;
            })
            ->rawColumns(['Acciones', 'name', '<input type="checkbox" class="" id="customCheck">']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->setTableId('users-table')
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
            ['data' => 'name', 'title' => 'Nombre'],
            ['data' => 'email', 'title' => 'Correo'],
            ['data' => 'created_at', 'title' => 'Fecha Creación'],
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
        return 'Users_' . date('YmdHis');
    }
}

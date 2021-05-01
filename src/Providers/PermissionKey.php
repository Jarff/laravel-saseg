<?php

namespace Saseg\Providers;
use Illuminate\Support\ServiceProvider;

/**
 * ConstantExport Trait implementa el método getConstants() el cual nos permite
 * regresar las constantes de la clase como un array asociativo
 */
Trait ConstantExport 
{
    /**
     * @return [const_name => 'value', ...]
     */
    static function getConstants(){
        $refl = new \ReflectionClass(__CLASS__);
        return $refl->getConstants();
    }
}


class PermissionKey extends ServiceProvider
{
    use ConstantExport;

    const Admin = [
        'name' => 'Módulo usuarios',
        'permissions' => [
            'show_sidebar' => [
                'display_name' => 'Mostrar en menú',
                'name' => 'admins.menu'
            ],
            'index' => [
                'display_name' => 'Ver todos',
                'name' => 'admins.index'
            ],
            'create' => [
                'display_name' => 'Crear',
                'name' => 'admins.create'
            ],
            'edit' =>[
                'display_name' => 'Ver detalle',
                'name' => 'admins.edit'
            ],
            'update' => [
                'display_name' => 'Modificar',
                'name' => 'admins.update'
            ],
            'update_password' => [
                'display_name' => 'Modificar contraseña',
                'name' => 'admins.update.password'
            ],
            'destroy' =>[
                'display_name' => 'Eliminar',
                'name' => 'admins.destroy'
            ],
        ]
    ];

    const Role = [
        'name' => 'Módulo roles',
        'permissions' => [
            'index' => [
                'display_name' => 'Ver todos',
                'name' => 'roles.index'
            ],
            'create' => [
                'display_name' => 'Crear',
                'name' => 'roles.create'
            ],
            'edit' => [
                'display_name' => 'Ver detalle',
                'name' => 'roles.edit'
            ],
            'update' => [
                'display_name' => 'Modificar',
                'name' => 'roles.update'
            ],
            'destroy' => [
                'display_name' => 'Eliminar',
                'name' => 'roles.destroy'
            ],
        ]
    ];

    const Image = [
        'name' => 'Módulo Material Subido',
        'permissions' => [
            'index' => [
                'display_name' => 'Ver todos',
                'name' => 'images.index'
            ],
            'destroy' => [
                'display_name' => 'Eliminar',
                'name' => 'images.destroy'
            ],
        ]
    ];

}

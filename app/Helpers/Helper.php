<?php

namespace App\Helpers;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Helper
{
    function getCurrentRole()
    {
        $user = auth()->user();

        if ($user->roles->isEmpty()) {
            return  "Sin Rol Asignado";
        } else {
            $roleName = $user->roles->first()->name;
            return  strtoupper($roleName);
        }
    }

    function roleHasAllPermissions($roleName)
    {
        // Obtiene el rol
        $role = Role::findByName($roleName);

        // Obtiene todos los permisos
        $allPermissions = Permission::all()->pluck('name');

        // Obtiene los permisos del rol
        $rolePermissions = $role->permissions->pluck('name');

        // Comprueba si el rol tiene todos los permisos
        return $allPermissions->diff($rolePermissions)->isEmpty();
    }
    function resetCache()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class Roles extends Component
{
    use WithPagination;

    public $componentName, $pageTitle, $roleName, $search, $roleId,  $pagination = 8;
    public $permissionName, $permissionId;

    function mount()
    {
        session(['map' => '', 'child' => '', 'pos' => 'Control de Roles y Permisos']);
        $this->componentName = 'Roles';
        $this->pageTitle = 'Listar';
    }

    public function render()
    {
        return view('livewire.roles.roles', [
            'roles' => $this->getRoles(),
            'permisos' => $this->getPermisos(),
        ]);
    }

    protected function getRoles()
    {
        return Role::orderBy('name')->get();
    }

    protected function getPermisos()
    {
        return Permission::when($this->search != null, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->paginate($this->pagination);
    }

    function createRole()
    {
        $this->resetValidation();

        if (empty($this->roleName)) {
            $this->addError('roleName', 'Ingresa el nombre del Role');
            return;
        }

        // verificar si ya existe un role con el mismo nombre
        if (Role::where('name', $this->roleName)->exists()) {
            $this->addError('roleName', 'Ya existe un role con este nombre');
            return;
        }


        Role::create(['name' =>  $this->roleName]);
        $this->dispatch('noty', msg: 'Se ha creado con éxito el role ' . $this->roleName);
        $this->roleName = '';
    }

    function Edit(Role $role)
    {
        $this->roleName = $role->name;
        $this->roleId = $role->id;
    }

    function cancelRoleEdit()
    {
        $this->reset('roleName', 'roleId');
    }

    function updateRole()
    {
        $this->resetValidation();

        if (empty($this->roleName)) {
            $this->addError('roleName', 'Ingresa el nombre del Role');
            return;
        }

        // verificar si existe un role con el mismo nombre en otro id
        if (Role::where('name', $this->roleName)->where('id', '!=', $this->roleId)->exists()) {
            $this->addError('roleName', 'Ya existe un role con este nombre');
            return;
        }

        Role::where('id', $this->roleId)->update(['name' =>  $this->roleName]);
        $this->dispatch('noty', msg: 'Se actualizó el role con éxito ');
        $this->reset('roleName', 'roleId');
    }

    #[On('destroyRole')]
    function destroyRole($id)
    {
        $role = Role::find($id);

        //if (User::role($role->name)->count() > 0) {
        //    $this->dispatch('noty', msg: 'No se puede eliminar el role ' . $role->name . ' porque hay usuarios asignados a este role');
        //    return;
        //}

        $role->delete();

        $this->dispatch('noty', msg: 'Se eliminó el role ' . $role->name . ' del sistema');
    }

    function createPermission()
    {
        $this->resetValidation();

        if (empty($this->permissionName)) {
            $this->addError('permissionName', 'Ingresa el nombre del Permiso');
            return;
        }

        // checar si existe un permison con el mismo nombre
        if (Permission::where('name', $this->permissionName)->exists()) {
            $this->addError('permissionName', 'Ya existe un permiso con este nombre');
            return;
        }


        Permission::create(['name' =>  $this->permissionName]);
        $this->dispatch('noty', msg: "Se creo el permiso  $this->permissionName  exitosamente");
        $this->permissionName = '';
    }

    function EditPermission(Permission $permission)
    {
        $this->permissionName = $permission->name;
        $this->permissionId = $permission->id;
    }


    function cancelPermissionEdit()
    {
        $this->reset('permissionName', 'permissionId');
    }

    function updatePermission()
    {
        $this->resetValidation();

        if (empty($this->permissionName)) {
            $this->addError('permissionName', 'Ingresa el nombre del Permiso');
            return;
        }

        // checar si existe un permison con el mismo nombre
        if (Permission::where('name', $this->permissionName)->where('id', '!=', $this->permissionId)->exists()) {
            $this->addError('permissionName', 'Ya existe un permiso con este nombre');
            return;
        }

        Permission::where('id', $this->permissionId)->update(['name' =>  $this->permissionName]);
        $this->dispatch('noty', msg: "Se actualizó el permiso  $this->permissionName  correctamente");
        $this->reset('permissionName', 'permissionId');
    }

    #[On('destroyPermission')]
    function destroyPermission($id)
    {
        $permission = Permission::find($id);

        // Verifica si hay roles asignados a este permiso
        if ($permission->roles()->count() > 0) {
            $this->dispatch('noty', msg: 'No se puede eliminar el permiso ' . $permission->name . ' porque hay roles asignados a él');
            return;
        }

        $permission->delete();

        $this->dispatch('noty', msg: 'Se eliminó el permiso ' . $permission->name . ' del sistema');
    }
}


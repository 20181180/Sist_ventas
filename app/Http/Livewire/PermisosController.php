<?php

namespace App\Http\Livewire;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\User;
use DB;

class PermisosController extends Component
{
    use WithPagination;

    public  $permissionName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 15;


    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listados';
        $this->componentName = 'Permisos';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $permisos = Permission::Where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $permisos = Permission::OrderBy('name', 'asc')->paginate($this->pagination);
        }
        return view(
            'livewire.permisos.componet',
            [
                'permisos' => $permisos
            ]
        )
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function CreatePermission()
    {
        $rules = ['permissionName' => 'required|min:5|unique:permissions,name'];

        $messages = [
            'permissionName.required' => 'Lo sentimos el nombre del permiso es obligatorio',
            'permissionName.unique' => '!Ups, lo sentimos el permiso ya existe..¡',
            'permissionName.min' => 'Ingrese minimo 5 caracteres para el nombre del permiso',
        ];

        $this->validate($rules, $messages);
        //metdo de crear el producto

        Permission::create([
            'name' => $this->permissionName,
        ]);
        $this->resetUI();
        $this->emit('permiso-added', 'Se Registro con exito xd');
    }

    public function Edit(Permission $permiso)
    {
        // $role = Role::find($id);
        $this->selected_id = $permiso->id;
        $this->permissionName = $permiso->name;

        $this->emit('show-modal', 'Show modal');
    }

    public function UpdatePermission()
    {
        $rules = ['permissionName' => "required|min:5|unique:permissions,name,{$this->selected_id}"];

        $messages = [
            'permissionName.required' => 'Lo sentimos el nombre del rol es obligatorio',
            'permissionName.unique' => '!Ups, lo sentimos el permiso ya existe..¡',
            'permissionName.min' => 'Ingrese minimo 5 caracteres para el permiso.',
        ];

        $this->validate($rules, $messages);
        //metdo de crear el producto

        $permiso = Permission::find($this->selected_id);
        $permiso->name = $this->permissionName;
        $permiso->save();
        $this->resetUI();
        $this->emit('permiso-updated', 'Actualizacion con exito xd');
    }

    protected $listeners = ['destroy' => 'Destroy'];

    public function Destroy($id)
    {
        $rolesCount = Permission::find($id)->getRolesName->count();

        if ($rolesCount > 0) {
            $this->emit('pemiso-error', '¡Ups!,No se puede eliminar el permiso por que tiene roles asignados..');
            return;
        }
        Permission::find($id)->delete();
        $this->emit('permiso-deleted', 'Permiso Eliminado con exito xd');
    }

    public function resetUI()
    {
        $this->permissionName = '';
        $this->search = '';
        $this->selected_id = 0;
        //$this->resetErrorBag();
        $this->resetValidation();
    }
}

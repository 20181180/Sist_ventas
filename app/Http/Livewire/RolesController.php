<?php

namespace App\Http\Livewire;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\User;
use DB;

class RolesController extends Component
{
    use WithPagination;

    public  $rolName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;


    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $roles = Role::Where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $roles = Role::OrderBy('name', 'asc')->paginate($this->pagination);
        }
        return view(
            'livewire.role.componet',
            [
                'roles' => $roles
            ]
        )
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function CreateRole()
    {
        $rules = ['roleName' => 'required|min:2|unique:roles,name'];

        $messages = [
            'roleName.required' => 'Lo sentimos el nombre del rol es obligatorio',
            'roleName.unique' => '!Ups, lo sentimos el usuario debe ser unico¡',
            'roleName.min' => 'Ingrese minimo 3 caracteres para el producto',
        ];

        $this->validate($rules, $messages);
        //metdo de crear el producto

        Role::create([
            'name' => $this->rolName,
        ]);
        $this->resetUI();
        $this->emit('rol-added', 'Registrado con exito xd');
    }

    public function Edit(Role $role)
    {
        // $role = Role::find($id);
        $this->selected_id = $role->id;
        $this->rolName = $role->name;

        $this->emit('show-modal', 'Show modal');
    }

    public function Update()
    {
        $rules = ['roleName' => "required|min:2|unique:roles,name,{$this->selected_id}"];

        $messages = [
            'roleName.required' => 'Lo sentimos el nombre del rol es obligatorio',
            'roleName.unique' => '!Ups, lo sentimos el usuario debe ser unico¡',
            'roleName.min' => 'Ingrese minimo 3 caracteres para el producto',
        ];

        $this->validate($rules, $messages);
        //metdo de crear el producto

        $role = Role::find($this->selected_id);
        $role->name = $this->rolName;
        $role->save();

        $this->emit('rol-update', 'Actualizacion con exito xd');
        $this->resetUI();
    }

    protected $listeners = ['destroy' => 'Destroy'];

    public function Destroy($id)
    {
        $permissionsCount = Role::find($id)->permissions->count();

        if ($permissionsCount > 0) {
            $this->emit('rol-delete', 'No se puede eliminar por que el rol esta en uso..Ups');
            return;
        }
        Role::find($id)->delete();
        $this->emit('rol-delete', 'Eliminado con exito xd');
    }

    public function resetUI()
    {
        $this->rolName = '';
        $this->search = '';
        $this->selected_id = '';
    }
}

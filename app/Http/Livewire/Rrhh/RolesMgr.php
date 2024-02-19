<?php

namespace App\Http\Livewire\Rrhh;

use App\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesMgr extends Component
{
    public User $user;

    // metodo toggleRole
    public function toggleRole($role)
    {
        if ($this->user->hasRole($role)) {
            $this->user->removeRole($role);
        } else {
            $this->user->assignRole($role);
        }
    }

    // metodo togglePermission
    public function togglePermission($permission)
    {
        if ($this->user->hasDirectPermission($permission)) {
            $this->user->revokePermissionTo($permission);
        } else {
            $this->user->givePermissionTo($permission);
        }
    }

    public function render()
    {
        $userRoles = $this->user->roles->pluck('name')->toArray();
        $userPermissions = $this->user->permissions->pluck('name')->toArray();
        $roles = Role::with('permissions')->whereNot('name','god')->orderBy('name')->get();

        return view('livewire.rrhh.roles-mgr', [
            'roles' => $roles, 
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions,
        ]);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmRole extends AppModel
{
    public function permissions(){
        return $this->belongsToMany(AdmPermission::class, 'adm_permission_role', 'role_id', 'permission_id');
    }

    public function admins(){
        return $this->belongsToMany(Admin::class, 'adm_role_admin', 'role_id', 'admin_id');
    }

    public function permissionIds(){
        return $this->permissions()->select('id')->get()->map(function($p){return $p->id;})->toArray();
    }
}

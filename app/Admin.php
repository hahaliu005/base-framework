<?php

namespace App;

class Admin extends AppModel
{
    public function roles()
    {
        return $this->belongsToMany(AdmRole::class, 'adm_role_admin', 'admin_id', 'role_id');
    }
}

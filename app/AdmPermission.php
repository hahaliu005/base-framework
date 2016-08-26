<?php

namespace App;

use Illuminate\Support\Facades\Gate;

class AdmPermission extends AppModel
{
    const GUEST = 'guest';

    public function roles()
    {
        return $this->belongsToMany(AdmRole::class, 'adm_permission_role', 'permission_id', 'role_id');
    }

    /**
     * 检查用户是否有相应的权限
     *
     * @param $permission_str => 字符串形如: 'admin.video|admin.video.create'
     * @return bool  true => 有 , false => 没有
     *
     */
    public static function check($permission_str)
    {
        $permission = empty($permission_str) ? AdmPermission::GUEST : $permission_str;
        $permissions = explode('|', $permission);

        foreach($permissions as $permission){
            if($permission == AdmPermission::GUEST || Gate::allows($permission)){
                return true;
            }
        }

        return false;
    }
}

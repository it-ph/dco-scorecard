<?php
namespace App\helpers;

use App\Role;

class AllRoles {
    
    function roles() {
       return $roles = Role::orderBy('role','ASC')
       ->where('is_hide',0)
       ->get();
    }
    

}
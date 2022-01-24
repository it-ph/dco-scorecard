<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HrPortalEmployees extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'hr_employee_profile';
    protected $guarded = [];
}

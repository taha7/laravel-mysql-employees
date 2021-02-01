<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'employee_departments');
    }

    public function manager()
    {
        return $this->hasOne(Manager::class);
    }
}

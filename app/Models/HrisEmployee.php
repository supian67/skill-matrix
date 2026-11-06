<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrisEmployee extends Model
{
    protected $connection = 'karyawan';

    protected $table = 'employees';

    protected $primaryKey = 'id';

    protected $guarded = [];
}
<?php

namespace App;

use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Model;
/* use Caffeinated\Shinobi\Models\Permission; */

class AdministradoresModel extends Model
{
    use HasRolesAndPermissions;

    protected $table = 'users';

    protected $primaryKey = 'id_users';

}

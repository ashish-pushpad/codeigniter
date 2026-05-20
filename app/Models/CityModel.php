<?php

namespace App\Models;
use CodeIgniter\Model;

class CityModel extends Model {
    protected $table= 'city';
    protected $primaryKey= 'id';
    protected $allowedFields =['name','state_id','added_by'];
    protected $useTimestamps = true;
}
<?php

namespace App\Models;
use CodeIgniter\Model;

class StatesModel extends Model {
    protected $table= 'states';
    protected $primaryKey= 'id';
    protected $allowedFields =['state','country_id','added_by'];
    protected $useTimestamps = true;
}
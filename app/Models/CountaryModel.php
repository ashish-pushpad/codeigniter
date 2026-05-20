<?php

namespace App\Models;
use CodeIgniter\Model;

class CountaryModel extends Model {
    protected $table= 'countries';
    protected $primaryKey= 'id';
    protected $allowedFields =['name','added_by'];
    protected $useTimestamps = true;
}
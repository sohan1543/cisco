<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Router extends Model
{
    use SoftDeletes;
    protected $fillable = ['sap_id', 'host_name', 'type', 'loopback', 'mac_address'];
}

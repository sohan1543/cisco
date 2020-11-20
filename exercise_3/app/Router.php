<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    protected $fillable = ['sap_id', 'host_name', 'type', 'loopback', 'mac_address'];
}

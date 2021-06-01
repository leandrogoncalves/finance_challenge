<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model;

class LogMongo extends Model
{
    protected $collection = 'logs';
    protected $connection = 'mongodb';
    protected $guarded =['_id'];
}

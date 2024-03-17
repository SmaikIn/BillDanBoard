<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

abstract class ModelWithUuid extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';
}

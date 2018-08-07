<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2017/3/8
 * Time: 17:14
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    protected $guarded = [];
}
<?php

namespace App\Models;

class X_User_Real extends BaseModel
{

    protected $table = 'user_real';

    public function user()
    {
        return $this->belongsTo('App\Models\X_User','user_id');
        //return $this->hasOne('App\Models\X_User','user_id');
    }

}

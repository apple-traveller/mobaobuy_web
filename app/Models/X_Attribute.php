<?php

namespace App\Models;

class X_Attribute extends BaseModel
{

    protected $table = 'attribute';


    public function attrValues()
    {
        return $this->hasMany('App\Models\X_Attribute_Value','attr_id');
    }



}

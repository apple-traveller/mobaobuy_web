<?php

namespace App\Models;

class FirmUserModel extends BaseModel
{

     protected $table = 'firm_user';

    /**获取用户所属的企业 (多对一关联)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function firm()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }*/

}

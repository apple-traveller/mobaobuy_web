<?php

namespace App\Models;

class X_Article extends BaseModel
{

     protected $table = 'article';

     public $timestamps = false;

    /**获取文章所属的分类 (多对一关联)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articleCat()
    {
        return $this->belongsTo('App\Models\X_Article_Cat','cat_id');
    }


}

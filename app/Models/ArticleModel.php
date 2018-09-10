<?php

namespace App\Models;

class ArticleModel extends BaseModel
{

     protected $table = 'article';

     public $timestamps = false;

    /**获取文章所属的分类 (多对一关联)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function articleCat()
    {
        return $this->belongsTo('App\Models\ArticleCatModel','cat_id');
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    protected $table = 'menu';
    protected $primaryKey = 'menu_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id','name','price'
    ];

    public function orders()
    {
        return $this->hasMany(InsideOrder::class,'order_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutsideOrderTotal extends Model
{
    protected $table = 'outside_order_total';
    protected $primaryKey = 'order_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    public function orders()
    {
        return $this->hasMany(OutsideModel::class,'order_id');
    }
}

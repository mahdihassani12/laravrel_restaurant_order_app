<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutsideModel extends Model
{
    protected $table = 'outside_order';
    protected $primaryKey = 'order_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    public function outSideOrderTotal()
    {
        return $this->belongsTo(OutsideOrderTotal::class,'order_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }
}

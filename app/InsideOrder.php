<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsideOrder extends Model
{
    protected $table = 'inside_order';
    protected $primaryKey = 'order_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_id','order_amount','price','identity','total_id'
    ];

    public function InsideOrderTotal()
    {
        return $this->belongsTo(InsideOrderTotal::class,'order_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }
}

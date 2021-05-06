<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsideOrderTotal extends Model
{
    
	protected $table = 'inside_order_total';
    protected $primaryKey = 'order_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location_id','total','status'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class,'location_id');
    }

    public function orders()
    {
        return $this->hasMany(InsideOrder::class,'order_id');
    }

}

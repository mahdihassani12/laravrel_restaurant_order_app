<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'location_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'floor_id','name'
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class,'floor_id');
    }

    public function orders()
    {
        return $this->hasMany(InsideOrder::class,'order_id');
    }

    public function InsideOrderTotal()
    {
        return $this->hasMany(InsideOrderTotal::class,'order_id');
    }
}

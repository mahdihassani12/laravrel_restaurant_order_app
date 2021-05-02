<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{

    protected $table = 'floor';
    protected $primaryKey = 'floor_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'floor_name'
    ];

    public function tables()
    {
        return $this->hasMany(Table::class,'location_id');
    }
}

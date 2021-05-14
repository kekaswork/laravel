<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_address',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'id',
        'user_id',
    ];

    /**
    *  user
    *
    *  Relationship with User Model
    *
    *  @type    function
    *  @date    11/05/2021
    *
    *  @param   void
    */
    public function user()
  	{
    	return $this->belongsTo('App\Models\User');
  	}
}

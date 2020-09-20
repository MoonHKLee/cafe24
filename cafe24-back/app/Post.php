<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'hits',
    ];

    protected $attributes = [
        'hits' => 0,
        'is_deleted' => false,
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

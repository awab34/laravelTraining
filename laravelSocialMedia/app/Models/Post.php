<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    USE SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'title',
        'details',
        'photo',
        'slug',
    ];

    // hasMany()->whereNull('awab') bring me any record that have got the record awab null
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $table = 'documents';

    protected $fillable = [
        'name',
        'path',
        'size',
        'user_id'
    ];


    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    
}
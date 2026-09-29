<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowings extends Model
{
    protected $fillable = ['user_id','book_id','borrowed_at','returned_at'];

    public function users(){
        $this->belongsTo(User::class,'user_id','id');
    }

    public function books(){
        $this->belongsTo(Book::class,'book_id','id');
    }
}

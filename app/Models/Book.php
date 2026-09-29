<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable=['category_id','title','author','stock'];

    public function categories(){
        return $this->belongsTo(Categories::class,'categories_id','id');
    }

    public function borrowings(){
        return $this->hasMany(Borrowings::class,'book_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['category_name'];

    public function book(){
        $this->hasMany(Book::class,'category_id','id');
    }
}

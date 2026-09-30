<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable=['category_id','title','author','stock'];

    public function category():BelongsTo {
        return $this->belongsTo(Category::class,'categories_id','id');
    }

    public function borrowing():HasMany{
        return $this->hasMany(Borrowing::class,'book_id','id');
    }

    public function imageURL():CastsAttribute{
        return CastsAttribute::get(
            fn()=>$this->image?Storage::disk('public')->url($this->image):null
        );
    }
}

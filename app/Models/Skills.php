<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    protected $table = 'skills'; 

    protected $fillable = ['skillName', 'description' ,'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    use HasFactory;
}

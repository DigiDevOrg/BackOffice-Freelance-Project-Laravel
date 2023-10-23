<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewsReplies extends Model
{
    use HasFactory ; 
    protected $fillable = ['message', 'review_id', 'user_id']; 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function review()
    {
        return $this->belongsTo(Review::class,'review_id');
    }
    
}

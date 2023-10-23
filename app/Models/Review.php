<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [ "rating", "author_id","freelancerId", "comment" ];
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancerId');
    }
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}

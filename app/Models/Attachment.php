<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['service_id', 'filename', 'filesize', 'filetype'];
    
    protected $casts = [
        'uploaddate' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'file_type',
        'file_path',
        'is_deleted',
    ];

    /**
     * Get the user that owns the file.
     */
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}

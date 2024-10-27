<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyInformation extends Model
{
    use HasFactory;
    protected $table='family_members';
    protected $fillable = [
        'user_id',  // Include user_id
        'name',
        'relationship',
        'dob',
        'phone',
    ];
}

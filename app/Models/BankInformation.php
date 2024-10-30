<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankInformation extends Model
{
    use HasFactory;
    public $table='bank_informations';
    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'ifsc_code',
        'pan_number',
    ];
}

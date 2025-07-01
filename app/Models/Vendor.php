<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        // Add other fields as needed
    ];

    public function penghantaran()
    {
        return $this->hasMany(Penghantaran::class);
    }
} 
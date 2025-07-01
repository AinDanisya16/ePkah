<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghantaran extends Model
{
    use HasFactory;

    protected $table = 'penghantaran';

    protected $fillable = [
        'vendor_id',
        'status_penghantaran',
        // Add other fields as needed
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
} 
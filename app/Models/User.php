<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'peranan',
        'nama',
        'id_kakitangan',
        'email',
        'telefon',
        'alamat',
        'poskod',
        'jajahan',
        'negeri',
        'password',
        'nama_syarikat',
        'no_syarikat',
        'lokasi_kutipan',
        'jenis_barang',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'lokasi_kutipan' => 'array',
        'jenis_barang' => 'array',
    ];

    /**
     * Get the penghantaran for this user (if vendor)
     */
    public function penghantaran()
    {
        return $this->hasMany(Penghantaran::class, 'vendor_id');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return strtolower($this->peranan) === 'admin';
    }

    /**
     * Check if user is vendor
     */
    public function isVendor()
    {
        return strtolower($this->peranan) === 'vendor';
    }

    /**
     * Check if user is pengguna
     */
    public function isPengguna()
    {
        return strtolower($this->peranan) === 'pengguna';
    }

    /**
     * Check if user is sekolah/agensi
     */
    public function isSekolah()
    {
        return strtolower($this->peranan) === 'sekolah/agensi';
    }

    /**
     * Generate new user ID based on role
     */
    public static function generateId($peranan)
    {
        $prefix = match($peranan) {
            'admin' => 'A',
            'pengguna' => 'P',
            'vendor' => 'V',
            'sekolah/agensi' => 'S',
            default => 'X'
        };

        $lastUser = self::where('id', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastUser) {
            $lastIdNum = intval(substr($lastUser->id, 1));
            $newIdNum = $lastIdNum + 1;
        } else {
            $newIdNum = 1;
        }

        return $prefix . str_pad($newIdNum, 3, '0', STR_PAD_LEFT);
    }
} 
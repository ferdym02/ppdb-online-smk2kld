<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah', 
        'alamat_sekolah', 
        'email_sekolah', 
        'telepon_sekolah', 
        'logo_sekolah', 
        'facebook', 
        'instagram',
        'call_center',
        'x',
        'tiktok' 
    ];

    // Cast the call_center field to an array
    protected $casts = [
        'call_center' => 'array',
    ];
}

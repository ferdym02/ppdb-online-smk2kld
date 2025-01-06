<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';
    protected $primaryKey = 'email';
    public $incrementing = false; // Nonaktifkan auto-increment
    protected $keyType = 'string'; // Pastikan primary key berupa string
    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}

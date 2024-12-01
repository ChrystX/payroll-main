<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Table name
    protected $table = 'admin';

    // Primary key
    protected $primaryKey = 'id';

    // Fillable fields for mass assignment
    protected $fillable = [
        'id_perusahaan',
        'username',
        'password',
        'role',
    ];

    /**
     * Hidden fields for serialization
     */
    protected $hidden = [
        'password', // Hide password field when serializing
        'remember_token', // Optional if using Laravel's built-in authentication
    ];

    /**
     * The relationship with the Perusahaan model
     * An admin belongs to one perusahaan.
     */
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id');
    }

    /**
     * Set the password attribute and hash it before saving.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Sales extends Authenticatable
{
    use Notifiable;
    
    protected $primaryKey = 'id_sales';

    protected $guard = 'sales';

    protected $fillable = [
        'nama_sales', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactorCode extends Model
{
    use HasFactory;

    protected $table = "two_factor_codes";

    protected $fillable = [
        'two_factor_code',
        'expired_at'
    ];

    protected $dates = [
        'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

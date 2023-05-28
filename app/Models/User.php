<?php

namespace App\Models;

use App\Jobs\TwoFactorMailJob;
use App\Mail\TwoFactorCodeMail;
use App\Mail\UserOTPMail;
use Twilio\Rest\Client;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password'
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

    protected $appends = [
        'full_name',
    ];
    

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->email;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'last_login_at',
    ];

    protected function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function twoFactorCode()
    {
        return $this->hasOne(TwoFactorCode::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function generateTwoFactorCode()
    {
        $two_factor_code = rand(100000, 999999);

        auth()->user()->twoFactorCode()->updateOrCreate([
            'user_id' => auth()->id()
        ], [
            'two_factor_code' => $two_factor_code,
            'expired_at' => now()->addMinutes(10)
        ]);

        // Mail::to(auth()->user()->email)->send(new TwoFactorCodeMail($two_factor_code));
        TwoFactorMailJob::dispatch($two_factor_code);
    }

    public function resetTwoFactorCode()
    {
        auth()->user()->twoFactorCode()->update([
            'two_factor_code' => null,
            'expired_at' => null
        ]);
    }
}

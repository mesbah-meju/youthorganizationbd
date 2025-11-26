<?php

namespace App\Models;

use App\Traits\EnumValue;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\EmailVerificationNotification;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, HasRoles, EnumValue;

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'gender', 'address', 'upazila', 'district', 'division', 'country', 'email_verified_at', 'verification_code', 'status', 'is_approved'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userrole()
    {
        return $this->hasOne(UserRole::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function uploads(){
        return $this->hasMany(Upload::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function doctor_school()
    {
        return $this->hasOne(DoctorSchool::class);
    }

    public function divisionN()
    {
        return $this->belongsTo(Division::class, 'division');
    }

    public function districtN()
    {
        return $this->belongsTo(District::class, 'district');
    }

    public function upazilaN()
    {
        return $this->belongsTo(Upazila::class, 'upazila');
    }
}

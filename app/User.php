<?php

namespace App;

use App\Notifications\Birthday;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Notification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_name', 'email', 'birth', 'password', 'legal_name',
        'inn', 'city', 'street', 'house','is_wholesaler',
        'phone', 'access', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany('App\Order', 'uid', 'id')->orderBy('created_at', 'DESC');
    }

    public function brandAccess()
    {
        return $this->hasOne(BrandAccess::class, 'user_id', 'id');
    }

    public function percent()
    {
        return $this->hasMany(BrandPercent::class, 'user_id', 'id');
    }

    public function scopeIsAdmin($query, $bool)
    {
        return $query->where('is_admin', $bool);
    }

    public function scopeHasAccess($query, $bool)
    {
        return $query->where('access', $bool)->where('is_admin', 0)->where('is_wholesaler', 1);
    }

    /**
     * Check days before/after birthday
     *
     * @param int $days
     * @param bool $before
     * @param bool $flow | if we wanna that check after birthday in $days days not include $before
     * @param int $uid
     * @return bool
     */
    public static function checkDaysBirthday($days = 2, $before = true, $flow = false, $uid = null)
    {
        if (is_null($uid) && Auth::user()->is_wholesaler)
            return false;

        $uid = (Auth::check()) ? Auth::user()->id : $uid ;
        $birthday = self::where('id', $uid)->first()->birth;
        $d = Carbon::parse($birthday)->year(date('Y'));
        $isBirthday = Carbon::parse($birthday)->isBirthday();

        $daysPass = Carbon::parse($d)->diffInDays(now()->startOfDay(), false);

        if ($flow) {
            if ($daysPass > 0 && $daysPass <= $days) {
                return true;
            } else {
                return false;
            }
        }

        if ($before && $daysPass < 0)
            $days = -1 * abs($days);

        if ($daysPass >= $days && !$isBirthday && $before && $daysPass < 0)
            return true;

        if ($daysPass >= $days && !$isBirthday && !$before && $daysPass > 0)
            return true;

        return false;
    }

    /**
     * @param null $uid
     * @return bool
     */
    public static function isBirthday($uid = null) {
        if (is_null($uid) && Auth::user()->is_wholesaler)
            return false;

        $uid = (Auth::check()) ? Auth::user()->id : $uid ;
        $birthday = self::where('id', $uid)->first()->birth;

        return Carbon::parse($birthday)->isBirthday();
    }

    /**
     * Is it available show opt price for roz clients
     * it's possible when roz client's birthdays is closed or after birthdays
     * Days we specify in .env file
     */
    public static function isAvailableToShowOptPriceForRoz()
    {
        if (Auth::user()->is_wholesaler)
            return true;

        return self::checkDaysBirthday(env('BIRTHDAY_DATE_BEFORE'))
            || self:: checkDaysBirthday(env('BIRTHDAY_DATE_AFTER'), false, true)
            || self::isBirthday();
    }

    public static function sendBirthdayEmail()
    {
        $users = User::where('is_wholesaler', 0)->get();

        //filter users by birthday
        $users = $users->filter(function($value, $key) {
            return (self::checkDaysBirthday(env('BIRTHDAY_DATE_BEFORE'), true, false, $value['id']) || self::isBirthday($value['id'])) ? true : false;
        });

        Notification::send($users, new Birthday());
    }
}

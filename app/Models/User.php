<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 30 Oct 2019 10:37:29 +0700.
 */

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Notifications\PasswordReset; // Or the location that you store your notifications (this is default).

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    public $timestamps = false;

    protected $dates = [
		'prev_login',
		'last_login',
		'dt_start',
		'dt_end'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
        'email',
        'phone',
        'address',
        'username',
		'password',
		'prev_login',
		'last_login',
		'type',
		'active',
		'notification_emails',
		'dt_start',
		'dt_end'
	];

	/**
	* Send the password reset notification.
	*
	* @param  string  $token
	* @return void
	*/
	public function sendPasswordResetNotification($token)
	{
	    $this->notify(new PasswordReset($token));
	}

	public function roles(){
		return $this->belongsToMany('App\Models\Role');
	}
}

<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Campaign
 * 
 * @property int $id
 * @property int $customer_id
 * @property string $name
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property int $slots
 * @property string $status
 * @property int $verificator_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Campaign extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'customer_id' => 'int',
		'slots' => 'int',
		'verificator_id' => 'int'
	];

	protected $dates = [
		'start_date',
		'end_date'
	];

	protected $fillable = [
		'customer_id',
		'name',
		'start_date',
		'end_date',
		'slots',
		'status',
		'verificator_id'
	];

	public function customer(){
		return $this->belongsTo('App\Models\User','customer_id');
	}

	public function verificator(){
		return $this->belongsTo('App\Models\User','verificator_id');
	}

	public function locations(){
		return $this->belongsToMany('App\Models\Location');
	}

	public function contents(){
		return $this->belongsToMany('App\Models\Content');
	}

	public function device_types(){
		return $this->belongsToMany('App\Models\DeviceType');
	}
}

<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Layout
 * 
 * @property int $id
 * @property string $name
 * @property int $timeout
 * @property string $photo_file
 * @property string $type
 * @property int $creator_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Layout extends Eloquent
{
	protected $casts = [
		'timeout' => 'int',
		'creator_id' => 'int'
	];

	protected $fillable = [
		'name',
		'timeout',
		'photo_file',
		'type',
		'creator_id'
	];
	
	public function boxes(){
		return $this->hasMany('App\Models\LayoutBox');
	}

	public function creator(){
		return $this->belongsTo('App\Models\User');
	}

	public function device_lines(){
		return $this->hasMany('App\Models\DeviceLine');
	}
}

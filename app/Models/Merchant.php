<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Merchant
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
class Merchant extends Eloquent
{
	protected $casts = [
		"id"=>"int",
		'creator_id' => 'int'
	];

	protected $fillable = [
		"id","name","business_entity","type_of_merchant","type_of_business","address","city","province","postal_code","phone_number","owner_name","bank_account_number","bank_account_name","photo_of_identity_card","photo_of_tax_id_number","photo_of_certificate","photo_of_proof_of_building_rent","photo_merchant_outside","photo_merchant_inside","photo_passbook","form_documentation_file","service_phone_number","open_hour","close_hour","lng","lat",
	];

	public function creator(){
		return $this->hasMany('App\Models\User', "id","creator_id");
	}

	public function device_lines(){
		return $this->hasMany('App\Models\DeviceLine');
	}

	public function devices(){
		return $this->belongsToMany('App\Models\Device',"device_lines");
	}

}

<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CampaignDeviceType
 * 
 * @property int $id
 * @property int $campaign_id
 * @property int $device_type_id
 *
 * @package App\Models
 */
class CampaignDeviceType extends Eloquent
{
	protected $table = 'campaign_device_type';
	public $timestamps = false;

	protected $casts = [
		'campaign_id' => 'int',
		'device_type_id' => 'int'
	];

	protected $fillable = [
		'campaign_id',
		'device_type_id'
	];
}

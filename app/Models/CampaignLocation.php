<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CampaignLocation
 * 
 * @property int $id
 * @property int $campaign_id
 * @property int $location_id
 *
 * @package App\Models
 */
class CampaignLocation extends Eloquent
{
	protected $table = 'campaign_location';
	public $timestamps = false;

	protected $casts = [
		'campaign_id' => 'int',
		'location_id' => 'int'
	];

	protected $fillable = [
		'campaign_id',
		'location_id'
	];
}

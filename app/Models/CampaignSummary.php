<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 17 Mar 2020 16:55:06 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CampaignSummary
 * 
 * @property int $id
 * @property int $campaign_id
 * @property int $slot_played
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class CampaignSummary extends Eloquent
{
	protected $casts = [
		'campaign_id' => 'int',
		'slot_played' => 'int'
	];

	protected $fillable = [
		'campaign_id',
		'slot_played'
	];
}

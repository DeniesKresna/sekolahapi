<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 31 Mar 2020 11:09:17 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SlotImpression
 * 
 * @property int $id
 * @property string $imei
 * @property int $content_id
 * @property int $campaign_id
 * @property \Carbon\Carbon $play_start_time
 * @property \Carbon\Carbon $play_end_time
 * @property int $calculated_status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class SlotImpression extends Eloquent
{
	protected $casts = [
		'content_id' => 'int',
		'campaign_id' => 'int',
		'calculated_status' => 'int'
	];

	protected $dates = [
		'play_start_time',
		'play_end_time'
	];

	protected $fillable = [
		'imei',
		'content_id',
		'campaign_id',
		'play_start_time',
		'play_end_time',
		'calculated_status'
	];
}

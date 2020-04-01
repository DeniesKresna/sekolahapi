<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:02 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ActivityLog
 * 
 * @property int $id
 * @property string $log_name
 * @property string $description
 * @property int $subject_id
 * @property string $subject_type
 * @property int $causer_id
 * @property string $causer_type
 * @property string $properties
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class ActivityLog extends Eloquent
{
	protected $table = 'activity_log';

	protected $casts = [
		'subject_id' => 'int',
		'causer_id' => 'int'
	];

	protected $fillable = [
		'log_name',
		'description',
		'subject_id',
		'subject_type',
		'causer_id',
		'causer_type',
		'properties'
	];
}

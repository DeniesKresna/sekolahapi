<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Mar 2020 15:44:03 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Role extends Eloquent
{
	protected $fillable = [
		'name',
		'display_name',
		'description'
	];
}

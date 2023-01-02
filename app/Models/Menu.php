<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Menu
 * 
 * @property int $id
 * @property string $title
 * @property string|null $icon
 * @property int|null $parent_id
 * @property string $url
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Menu extends Model
{
	use SoftDeletes;
	protected $table = 'menus';

	protected $casts = [
		'parent_id' => 'int'
	];

	protected $fillable = [
		'title',
		'icon',
		'parent_id',
		'url',
		'created_by',
		'updated_by',
		'deleted_by'
	];
}

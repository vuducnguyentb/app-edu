<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Slide
 * 
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $file_id
 * @property int $position
 * @property int $type
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property File|null $file
 *
 * @package App\Models
 */
class Slide extends Model
{
	use SoftDeletes;
	protected $table = 'slides';

	protected $casts = [
		'file_id' => 'int',
		'position' => 'int',
		'type' => 'int'
	];

	protected $fillable = [
		'title',
		'description',
		'file_id',
		'position',
		'type',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function file()
	{
		return $this->belongsTo(File::class);
	}
}

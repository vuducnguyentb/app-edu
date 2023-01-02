<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tag
 * 
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $type
 * @property string|null $position
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class Tag extends Model
{
	use SoftDeletes;
	protected $table = 'tags';

	protected $casts = [
		'type' => 'int'
	];

	protected $fillable = [
		'title',
		'slug',
		'type',
		'position',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function posts()
	{
		return $this->belongsToMany(Post::class)
					->withPivot('created_by', 'updated_by', 'deleted_by', 'deleted_at')
					->withTimestamps();
	}
}

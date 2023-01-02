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
 * Class File
 * 
 * @property int $id
 * @property string $url
 * @property int|null $user_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|Post[] $posts
 * @property Collection|Slide[] $slides
 *
 * @package App\Models
 */
class File extends Model
{
	use SoftDeletes;
	protected $table = 'files';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'url',
		'user_id',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function slides()
	{
		return $this->hasMany(Slide::class);
	}
}

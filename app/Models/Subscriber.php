<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscriber
 * 
 * @property int $id
 * @property string $email
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Subscriber extends Model
{
	protected $table = 'subscribers';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'email',
		'status'
	];
}

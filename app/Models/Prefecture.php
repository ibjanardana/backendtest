<?php

namespace App\Models;

class Prefecture extends \App\Models\Base\Prefecture
{
	protected $table = 'prefectures';
	protected $fillable = [
		'name',
		'display_name',
		'area_id'
	];
}

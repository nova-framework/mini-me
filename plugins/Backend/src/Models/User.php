<?php

namespace Backend\Models;

use Mini\Foundation\Auth\User as BaseModel;
use Mini\Support\Facades\Config;

use Carbon\Carbon;


class User extends BaseModel
{
	protected $table = 'users';

	protected $primaryKey = 'id';

	protected $fillable = array('role_id', 'username', 'password', 'realname', 'email', 'image', 'activation_code');

	protected $hidden = array('password', 'remember_token');


	public function online()
	{
		return $this->hasMany('Backend\Models\OnlineUser', 'user_id', 'id');
	}

	public function role()
	{
		return $this->belongsTo('Backend\Models\Role', 'role_id', 'id', 'role');
	}

	public function messages()
	{
		return $this->hasMany('Backend\Models\Message', 'sender_id', 'id');
	}

	public function notifications()
	{
		return $this->hasMany('Backend\Models\Notification', 'user_id');
	}

	public function scopeActive($query)
	{
		$limit = Config::get('backend::activityLimit');

		$timestamp = Carbon::now()->subMinutes($limit)->timestamp;

		//
		$table = $this->getTable();

		$relatedTable = $this->online()->getRelated()->getTable();

		return $query->with(array('online' => function ($query)
		{
			return $query->orderBy('last_activity', 'DESC');

		}))->join($relatedTable, $table .'.id', '=', $relatedTable .'.user_id')
			->where($relatedTable .'.last_activity', '>=', $timestamp)
			->orderBy($relatedTable .'.last_activity', 'DESC');
	}

	public function newNotification()
	{
		$notification = new Notification();

		$notification->user()->associate($this);

		return $notification;
	}

	public function hasRole($roles, $strict = false)
	{
		if (! array_key_exists('role', $this->relations)) {
			$this->load('role');
		}

		$slug = strtolower($this->role->slug);

		// Check if the User has a Root role.
		if (($slug === 'root') && ! $strict) {
			return true;
		}

		foreach ((array) $roles as $role) {
			if (strtolower($role) == $slug) {
				return true;
			}
		}

		return false;
	}

	public function name() {
		return trim($this->first_name .' ' .$this->last_name);
	}
}
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
	use Notifiable;
	use HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'name', 'email', 'password', 'user_type', 'user_uuid'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
			'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
			'email_verified_at' => 'datetime',
	];

	/*
		* Get candidate
		*/
	public function candidate()
	{
		return $this->hasOne('App\Candidate', 'user_uuid', 'user_uuid');
	}

	/*
		* Get employee
		*/
	public function employee()
	{
		return $this->hasOne('App\Employee', 'user_uuid', 'user_uuid');
	}

	/*
		* Get organization
		*/
	public function organization()
	{
		return $this->hasOne('App\OrganizationManagement', 'id', 'org_id');
	}

	/*
		* Get department
		*/
	public function department()
	{
		return $this->hasOne('App\DepartmentManagement', 'id', 'dept_id');
	}

	/*
		* Get division
		*/
	public function division()
	{
		return $this->hasOne('App\Division', 'id', 'div_id');
	}

	/*
		* Get section
		*/
	public function section()
	{
		return $this->hasOne('App\Section', 'id', 'sec_id');
	}

	/*
		* Get role
		*/
	public function role()
	{
		return $this->hasOne('App\Role', 'id', 'role_id');
	}


	/*
	 * Get questions
	 */
	public function questions()
	{
		return $this->hasMany('App\Question', 'created_by')->latest();
	}

	/*
	 * Get company
	 */
	public function company()
	{
		return $this->hasOne('App\Company', 'id', 'company_id');
	}

	/*
	 * Get full name
	 */
	public function getName()
	{
		return ($this->name ? $this->name : '') . ' ' . ($this->last_name ? $this->last_name : '');
	}
	
	/*
	 * Get passport
	 */
	public function passport()
	{
		return $this->hasMany('App\PassportManagement', 'user_id', 'id');
	}

	/*
	 * Get primary passport
	 */
	public function primaryPassport()
	{
		return $this->hasOne('App\PassportManagement', 'user_id', 'id')->where('is_primary', 1)->where('deleted_at', null);
	}

	/*
	 * Get previous passport
	 */
	public function previousPassports()
	{
		return $this->hasMany('App\PassportManagement', 'user_id', 'id')->where('is_primary', 0)->where('deleted_at', null);
	}

	/*
	 * Get quick links
	 */
	public function quickLinks()
	{
		return $this->hasMany('App\QuickLinks', 'created_by')->where('deleted_at', null)->orderBy('link_position', 'asc');
	}

	/*
	 * Get tasks
	 */
	public function tasks()
	{
		return $this->hasMany('App\TaskUser', 'user_id', 'id');
	}

}

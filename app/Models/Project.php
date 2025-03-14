<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $fillable = [
        'name',
        'status',
    ];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'project_attribute_values')
            ->withPivot('value');
    }

    public function attributeValues()
    {
        return $this->hasMany(ProjectAttributeValue::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'project_users')->withTimestamps();
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}

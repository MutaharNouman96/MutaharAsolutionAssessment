<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ['name', 'type'];

    public function attributeValues()
    {
        return $this->hasMany(ProjectAttributeValue::class);
    }
}

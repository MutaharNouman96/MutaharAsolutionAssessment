<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAttributeValue extends Model
{
    //
    protected $fillable = ['project_id', 'attribute_id', 'value'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}

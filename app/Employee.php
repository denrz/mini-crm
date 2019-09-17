<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/employees/' . $this->id;
    }

    /**
     * Get the employee that belongs to company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

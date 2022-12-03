<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
    ];

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:150',
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'The field ":attribute" is required!',
            'min' => 'The field ":attribute" must be larger than :min character!',
            'max' => 'The field ":attribute" must be be less than :max character!',
            'name.unique' => 'The name has already included.'
        ];
    }

    public function locations()
    {
        return $this->hasMany('App\Models\Location');
    }
}

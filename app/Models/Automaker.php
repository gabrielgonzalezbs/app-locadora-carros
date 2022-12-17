<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:150|unique:automakers,name,'. $this->id,
            'image' => 'required|file|mimes:png,jpg',
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

    public function carModels()
    {
        return $this->hasMany('App\Models\CarModel');
    }
}

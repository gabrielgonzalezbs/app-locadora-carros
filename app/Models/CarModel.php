<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'automaker_id',
        'name',
        'image',
        'number_ports',
        'places',
        'air_bag',
        'abs',
    ];

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:150|unique:car_models,name,'. $this->id,
            'image' => 'required|file|mimes:png,jpg,jpeg',
            'automaker_id' => 'exists:automakers,id',
            'number_ports' => 'required|integer|digits_between:1,5',
            'places' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean',
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

    public function automaker()
    {
        return $this->belongsTo('App\Models\Automaker');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_model_id',
        'plaque',
        'available',
        'km',
    ];

    public function rules()
    {
        return [
            'client_id' => 'required',
            'car_model_id' => 'required',
            'plaque' => 'required|unique:vehicles,plaque,'. $this->id,
            'available' => 'required',
            'km' => 'required',
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'The field ":attribute" is required!',
            'min' => 'The field ":attribute" must be larger than :min character!',
            'max' => 'The field ":attribute" must be be less than :max character!'
        ];
    }

    public function Client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}

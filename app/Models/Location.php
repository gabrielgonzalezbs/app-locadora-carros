<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'vehicle_id',
        'start_date_range',
        'end_date_range_expected',
        'end_date_range_real',
        'daily_value',
        'km_start',
        'km_end'
    ];

    public function rules()
    {
        return [
            'client_id' => 'required',
            'client_id' => 'required',
            'vehicle_id' => 'required',
            'start_date_range' => 'required',
            'end_date_range_expected' => 'required',
            'end_date_range_real' => 'required',
            'daily_value' => 'required',
            'km_start' => 'required',
            'km_end' => 'required',
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

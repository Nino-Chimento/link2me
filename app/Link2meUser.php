<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contact;

class Link2meUser extends Model
{
    protected $fillable = [
        "nome",
        "lastname",
        "birthday",
        "address",
        "department",
        "email",
        "number_phone",
        "latitude",
        "longitude"
    ];

    protected function messages()
    {
        return $this->hasMany("App\Contact");
    }
}

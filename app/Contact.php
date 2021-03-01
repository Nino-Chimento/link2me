<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Link2meUser;

class Contact extends Model
{
    protected $fillable = [
        "nome",
        "link2meusers_id",
        "lastname",
        "birthday",
        "address",
        "department",
        "email",
        "number_phone",
        "latitude",
        "longitude"
    ];

    protected function link2meuser(){
        return $this->belongsTo("App\Link2meUser");
    }
}

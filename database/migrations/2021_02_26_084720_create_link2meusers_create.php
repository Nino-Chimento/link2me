<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLink2meusersCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link2meusers_create', function (Blueprint $table) {
            $table->id();
            $table->string("name",50);
            $table->string("lastname",50);
            $table->date("birthday")->nullable();
            $table->string("address")->nullable();
            $table->string("department");
            $table->string("email",50)->unique();
            $table->string("number_phone",30)->nullable();
            $table->string("latitude")->nullable();
            $table->string("longitude")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link2meusers_create');
    }
}

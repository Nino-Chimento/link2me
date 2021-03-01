<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('link2meusers_id');
            $table->foreign('link2meusers_id')->references('id')->on('link2meusers_create');
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
        Schema::dropIfExists('contacts');
    }
}

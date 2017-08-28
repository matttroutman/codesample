<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('first_name');
    	    $table->string('last_name');
    	    $table->string('email');
	    $table->string('phone');
	    $table->integer('user_id');
    	    $table->timestamps();
        });

	Schema::create('contacts_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->integer('contact_id');
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
	Schema::dropIfExists('contacts_meta');
    }
}

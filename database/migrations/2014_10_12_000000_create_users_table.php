<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('address');
            $table->string("interest")->nullable();
            $table->boolean('checked');
            $table->longText('description');
            $table->date('date_of_birth')->nullable();
            $table->string('account');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

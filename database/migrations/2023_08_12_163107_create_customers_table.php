<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->string('address')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->integer('login_counter')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('profile_picture')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}


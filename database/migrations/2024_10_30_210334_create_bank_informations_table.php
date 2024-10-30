<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_informations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // assuming each user has a unique bank info
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->string('pan_number');
            
            // Foreign key to link with users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    
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
        Schema::dropIfExists('bank_informations');
    }
};

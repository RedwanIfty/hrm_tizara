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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('approval_id')->nullable(); // Foreign key for approval
            $table->unsignedBigInteger('employee_id'); // Foreign key for employee
//            $table->string('r')->nullable(); // Assuming 'r' is a string; adjust as needed
            $table->date('start_date');
            $table->date('end_date');
            $table->date('approved_start_date')->nullable();
            $table->date('approved_end_date')->nullable();
            $table->integer('applied_total_days');
            $table->integer('approved_total_days')->nullable();
            $table->text('reason')->nullable(); // Reason for the application
            $table->string('stay_location')->nullable(); // Location during leave
            $table->text('comment')->nullable(); // Any additional comments
            $table->string('leave_type'); // Type of leave
            $table->string('status'); // Status of the application
            $table->string('files')->nullable(); // To store file paths or names

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
        Schema::dropIfExists('applications');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('dob');
            $table->string('address');
            $table->string('phone', 20);
            $table->string('email');
            $table->date('start_date');
            $table->string('image');
            $table->unsignedInteger('start_time_id');
            $table->unsignedInteger('learning_hour_id');
            $table->unsignedInteger('duration_id');
            $table->unsignedInteger('course_id');
            $table->date('end_date');
            $table->time('end_time');
            $table->string('token')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('start_time_id')
                ->references('id')
                ->on('start_times')
                ->onUpdate('restrict')
                ->onDelete('cascade');

            $table->foreign('learning_hour_id')
                ->references('id')
                ->on('learning_hours')
                ->onUpdate('restrict')
                ->onDelete('cascade');

            $table->foreign('duration_id')
                ->references('id')
                ->on('durations')
                ->onUpdate('restrict')
                ->onDelete('cascade');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onUpdate('restrict')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}

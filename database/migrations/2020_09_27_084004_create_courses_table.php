<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('other_subject');
            $table->foreignId('course_level_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('other_level');
            $table->string('fullname');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('time_working');
            $table->integer('session_per_week');
            $table->integer('num_of_student')->default(1);
            $table->string('other_requirement')->nullable();
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
        Schema::dropIfExists('courses');
    }
}

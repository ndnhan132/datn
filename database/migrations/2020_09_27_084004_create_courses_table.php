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
            $table->boolean('confirmed')->default(false);
            $table->string('code')->unique();
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('other_subject')->nullable();
            $table->foreignId('course_level_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('other_level')->nullable();
            $table->string('fullname');
            $table->string('address');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('time_working')->nullable();
            $table->integer('session_per_week');
            $table->integer('time_per_session');
            $table->integer('num_of_student')->default(1);
            $table->integer('tuition_per_month');
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

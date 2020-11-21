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
            $table->boolean('flag_is_confirmed')->default(false);
            $table->boolean('flag_is_checked')->default(false);
            $table->string('code')->unique();
            $table->string('slug')->unique();
            $table->string('title');
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('other_subject')->nullable();

            $table->foreignId('course_level_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('other_course_level')->nullable();

            $table->enum('teacher_gender', ['MALE', 'FEMALE', 'BOTH'])->default('BOTH');
            $table->foreignId('teacher_level_id')->nullable()->constrained()->onDelete('set null');
            $table->string('other_teacher_level')->nullable();
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

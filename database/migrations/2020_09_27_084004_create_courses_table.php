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
            $table->string('slug')->unique();
            $table->string('title');

            $table->string('fullname', '50');
            $table->string('address', '100');
            $table->string('phone', '20');
            $table->string('email', '50')->nullable();

            $table->foreignId('course_level_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('other_course_level', '100')->nullable();
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('other_subject', '100')->nullable();
            $table->integer('num_of_student')->default(1);
            $table->integer('tuition_per_month');
            $table->integer('session_per_week');
            $table->integer('time_per_session');
            $table->string('time_working', '50')->nullable();

            $table->foreignId('teacher_level_id')->nullable()->constrained()->onDelete('set null');
            $table->string('other_teacher_level', '100')->nullable();
            $table->enum('teacher_gender', ['MALE', 'FEMALE', 'BOTH'])->default('BOTH');
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

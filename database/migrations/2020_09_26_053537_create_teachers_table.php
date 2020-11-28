<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_male')->nullable();
            $table->string('identity_card')->nullable();
            $table->string('university')->nullable();
            $table->string('speciality')->nullable();
            $table->foreignId('teacher_level_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('reference_tuition')->nullable();
            $table->integer('year_of_birth')->nullable();
            $table->text('description')->nullable();
            $table->integer('last_modified')->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->integer('request_confirmation_at')->nullable();
            $table->boolean('flag_is_checked')->default(false);
            $table->boolean('flag_is_teacher')->default(false); // tài khoản đã là gia sư

            $table->rememberToken();
            $table->timestamps();
            /*
            $flag_is_teacher = true => đã là gia Sư
            $flag_is_checked = true  && flag_is_teacher = false => ko dat yeu cau
            $flag_is_checked = true  && flag_is_teacher = false &&
            $flag_is_checked = false => chưa xét duyệt
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}

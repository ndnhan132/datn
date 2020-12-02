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
            $table->string('name', '50')->nullable();
            $table->string('email', '50')->unique();
            $table->string('password', '100');
            $table->string('address', '100')->nullable();
            $table->string('phone', '20')->nullable();
            $table->boolean('is_male')->nullable();
            $table->string('identity_card', '20')->nullable();
            $table->string('university', '100')->nullable();
            $table->string('speciality', '50')->nullable();
            $table->foreignId('teacher_level_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('reference_tuition')->nullable();
            $table->integer('year_of_birth')->nullable();
            $table->text('description')->nullable();
            $table->integer('last_modified')->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->unsignedInteger('request_confirmation_at')->default(0);
            $table->foreignId('teacher_account_status_id')->nullable()->constrained()->onDelete('set null');

            // $table->boolean('flag_is_checked')->default(false);
            // $table->boolean('flag_is_teacher')->default(false); // tài khoản đã là gia sư

            $table->rememberToken();
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
        Schema::dropIfExists('teachers');
    }
}

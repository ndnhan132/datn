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
            $table->boolean('flag_is_active')->default(false);
            $table->boolean('flag_is_checked')->default(false);
            $table->text('description')->nullable();
            $table->integer('last_modified')->nullable();
            $table->timestamp('email_verified_at')->nullable();
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

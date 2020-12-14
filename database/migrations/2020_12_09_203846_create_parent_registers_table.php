<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_registers', function (Blueprint $table) {
            $table->id();
            $table->boolean('flag_is_confirmed')->default(false);
            $table->boolean('flag_is_checked')->default(false);

            $table->string('fullname', '50');
            $table->string('address', '100');
            $table->string('phone', '20');
            $table->string('email', '50')->nullable();

            $table->string('time_working', '50')->nullable();
            $table->integer('tuition_per_session')->nullable();

            $table->foreignId('course_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('teacher_id')->nullable()->constrained()->onDelete('set null');
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
        Schema::dropIfExists('parent_registers');
    }
}

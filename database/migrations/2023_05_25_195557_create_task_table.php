<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('task_group_id');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->integer('task_type');
            $table->string('title');
            $table->string('description');
            $table->integer('repetetion_type');
            $table->integer('repetetions_count')->nullable();
            $table->boolean('completed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_groups');
    }
};

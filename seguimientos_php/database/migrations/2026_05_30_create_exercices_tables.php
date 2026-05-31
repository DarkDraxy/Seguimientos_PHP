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
            $table->string('title');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->string('category');
            $table->date('date');
            $table->timestamps();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('service');
            $table->string('service_name');
            $table->date('date');
            $table->string('slot', 5);
            $table->boolean('confirmed')->default(true);
            $table->timestamps();

            $table->unique(['date', 'slot','service']);
        });

        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string ('category');
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->string('time', 5);
            $table->text('description')->nullable();
            $table->boolean('reminder')->default(false);
            $table->timestamps();
        });

        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->text('ingredients');
            $table->text('instructions');
            $table->string('author')->default('Usuario');
            $table->timestamps();
        });

        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('question', 500);
            $table->unsignedInteger('responses')->default(0);
            $table->timestamps();
        });

        Schema::create('survey_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->string('text');
            $table->unsignedInteger('votes')->default(0);
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('events');
    }
};

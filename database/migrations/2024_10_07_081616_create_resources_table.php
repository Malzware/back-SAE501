<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('resource_code');
            $table->string('title');
            $table->foreignId('id_semester')->constrained('semesters');
            $table->integer('national_total')->nullable();
            $table->integer('national_tp')->nullable();
            $table->integer('adapt')->nullable();
            $table->integer('adapt_tp')->nullable();
            $table->integer('projet_ne')->nullable(); // Ajouté ici
            $table->integer('projet_e')->nullable();  // Ajouté ici
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('resources');
    }
}


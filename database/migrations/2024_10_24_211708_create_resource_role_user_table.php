<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceRoleUserTable extends Migration
{
    public function up()
    {
        Schema::create('resource_role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_user_id')->constrained('role_user')->onDelete('cascade');
            $table->foreignId('resource_id')->constrained('resources')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resource_role_user');
    }
}

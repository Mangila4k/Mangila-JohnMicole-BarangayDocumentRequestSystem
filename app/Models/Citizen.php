<?php

namespace App\Models;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitizensTable extends Migration
{
    public function up()
    {
        Schema::create('citizens', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->foreignId('role_id')->constrained('roles'); // Foreign key for roles
    $table->foreignId('barangay_id')->constrained('barangays'); // Foreign key for barangays
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('citizens');
    }
}

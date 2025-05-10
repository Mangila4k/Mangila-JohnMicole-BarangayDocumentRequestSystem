<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade'); // Foreign key to the 'documents' table
            $table->string('reservation_name'); // Name of the reservation
            $table->date('reservation_date'); // Date of the reservation
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}

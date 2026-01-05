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
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            // Relasi krusial: Satu penumpang terikat ke satu booking
            $table->foreignId('booking_id')->constrained('bookings');
            // Relasi krusial: Satu penumpang terikat ke satu tiket (seat number)
            $table->foreignId('ticket_id')->nullable()->constrained('tickets'); 
            
            $table->string('name');
            $table->string('id_card_number')->nullable(); // Nomor KTP/Paspor
            $table->date('birth_date');
            $table->enum('type', ['adult', 'child', 'infant']); // Jenis Penumpang
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**      
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
    Schema::create('research', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('author');
        $table->string('module');
        $table->string('status');
        $table->date('entry_date'); // Automatic date
        $table->date('released_date')->nullable(); // Edit/Released date
        $table->timestamps();
    });
}

    public function down(): void {
        Schema::dropIfExists('research');
    }
};
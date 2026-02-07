<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('researches', function (Blueprint $table) {
        $table->id();
        $table->string('category');
        $table->string('sub_type');
        $table->date('date_received');
        $table->string('author');
        $table->text('title');
        
        // DAGDAG MO ITONG MGA ITO PARA MAG-MATCH SA MODEL MO:
        $table->string('school_id')->nullable();
        $table->string('school_name')->nullable();
        $table->string('district')->nullable();
        $table->string('type_of_research')->nullable();
        $table->string('theme')->nullable();
        $table->date('endorsement_date')->nullable();
        $table->date('released_date')->nullable();
        $table->date('completion_date')->nullable();
        $table->date('coc_date')->nullable();
        
        $table->boolean('is_archived')->default(false);
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('researches');
    }
};
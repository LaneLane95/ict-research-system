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
        Schema::create('researches', function (Blueprint $table) {
            $table->id();
            // Main Categories: DepEd, Non-DepEd, Innovation
            $table->string('category'); 
            
            // Sub-types: Proposal, Ongoing, Thesis, Dissertation
            $table->string('sub_type')->nullable(); 
            
            // Shared Fields
            $table->date('date_received')->nullable();
            $table->string('school_id')->nullable();
            $table->string('school_name')->nullable();
            $table->string('district')->nullable();
            $table->string('author')->nullable();
            $table->text('title')->nullable();
            $table->string('type_of_research')->nullable();
            $table->string('theme')->nullable();
            $table->date('endorsement_date')->nullable();
            $table->date('released_date')->nullable();
            $table->date('completion_date')->nullable();
            
            // Special Field: Para sa DepEd at Innovation lang
            $table->date('coc_date')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researches');
    }
};
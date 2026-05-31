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
        Schema::create('project_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('construction_project_id')->constrained('construction_projects')->onDelete('cascade');
            $table->foreignId('material_id')->nullable()->constrained('materials')->onDelete('cascade');
            $table->string('custom_material_name')->nullable();
            $table->string('custom_unit')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->decimal('estimate_quantity', 10, 2)->nullable();
            $table->decimal('unit_price_at_time', 10, 2);
            $table->date('cost_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_costs');
    }
};

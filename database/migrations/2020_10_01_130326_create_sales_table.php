<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->uuid('lead_id');
            $table->jsonb('products_and_services');
            $table->text('description')->nullable();
            $table->smallInteger('close_rate')->default(0);
            $table->string('closed_us')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->boolean('is_complete')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('sales');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number');
            $table->string('invoice_value');
            $table->string('invoice_date');
            $table->string('invoice_number')->unique();
            $table->string('invoice_period_from');
            $table->string('invoice_period_to');
            $table->string('company_type');
            $table->string('service_provider');
            $table->string('invoice_status');
            $table->text('note')->nullable();
            $table->string('user_id');
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
        Schema::dropIfExists('invoices');
    }
}

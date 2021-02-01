<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_managers', function (Blueprint $table) {
            /** Data */
            $table->timestamps();

            /** Relations */
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('manager_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('manager_id')->references('id')->on('managers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depart_managers');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBLSedeTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
          Schema::connection('unvinteraction')->create('TBL_Sede', function (Blueprint $table) {
              $table->increments('PK_SEDE_Sede');
              $table->text('SEDE_Sede');
              $table->timestamps();
              $table->softDeletes();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('TBL_Sede');
    }
}

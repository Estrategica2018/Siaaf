<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('humtalent')->create('TBL_Notificaciones', function (Blueprint $table) {
            $table->increments('PK_NOTIF_Id_Notificacion')->unique();
            $table->String('NOTIF_Estado_Notificacion',20)->nullable();
            $table->date('NOTIF_Fecha_Inicio')->nullable();
            $table->date('NOTIF_Fecha_Fin')->nullable();
            $table->String('NOTIF_Descripcion',60);
            $table->date('NOTIF_Fecha_Notificacion')->nullable();
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
        Schema::dropIfExists('TBL_Notificaciones');
    }
}

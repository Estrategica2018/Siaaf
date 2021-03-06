<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('audiovisuals')->create('TBL_Prestamos', function (Blueprint $table) {
        	$table->increments('id'); //id prestamo
            $table->integer('PRT_FK_Articulos_id')->unsigned()->nullable(); //->idArticulos
            $table->integer('PRT_FK_Funcionario_id')->unsigned(); //funcionario
            $table->integer('PRT_FK_Kits_id')->unsigned(); //->id kits
            $table->dateTime('PRT_Fecha_Inicio'); //reserva y prestamo
            $table->dateTime('PRT_Fecha_Fin'); //reserva y prestamo
            $table->text('PRT_Observacion_Entrega');
            $table->text('PRT_Observacion_Recibe');
			$table->integer('PRT_Num_Orden')->unsigned(); //identificar de prestamo
			$table->integer('PRT_Cantidad')->unsigned(); //Numero de Elementos solicitados
            $table->integer('PRT_FK_Estado')->unsigned(); // pendiente aprobado o rechazado
            $table->integer('PRT_FK_Tipo_Solicitud')->unsigned(); // prestamo o reserva
            $table->integer('PRT_FK_Administrador_Entrega_id')->unsigned(); //administradores
            $table->integer('PRT_FK_Administrador_Recibe_id')->unsigned(); //administradores
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
        Schema::dropIfExists('TBL_Prestamos');
    }
}

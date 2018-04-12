<?php

namespace App\Container\Unvinteraction\src;

use Illuminate\Database\Eloquent\Model;

class TipoPregunta extends Model
{
    /**
     * desactivar opcion de  rellenar casilla update y create date
     *
     * @var string
     */
    
    public $timestamps = false;
    
    /**
     * Conexión de la base de datos usada por el modelo
     *
     * @var string
     */
   
    protected $connection ='unvinteraction';
     
    /**
     * Conexión de la tabla usada por el modelo
     *
     * @var string
     */
    
    protected $table = 'TBL_Tipo_Pregunta';
     
    /**
     * llave primaria utilizada por el modelo
     *
     * @var string
     */
    
    protected $primaryKey = 'PK_TPPG_Tipo_Pregunta';
      
    /**
     * casilla utilizadas en la tabla y el modelo
     *
     * @var string
     */
    protected $fillable = ['TPPG_Tipo'];
    
    /*
    *Función de conexión entre las tablas de TBL_Tipo_Pregunta y TBL_Preguntas
    *por los campo de FK_TBL_Tipo_Pregunta_Id y PK_TPPG_Tipo_Pregunta
    *para realizar las busquedas complementarias
    */   
    public function preguntasTiposPreguntas()
    {
        return $this->belongsto(TBL_Preguntas::class, 'FK_TBL_Tipo_Pregunta_Id', 'PK_TPPG_Tipo_Pregunta');
    }
}

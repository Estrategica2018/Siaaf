<?php

namespace App\Container\Unvinteraction\src;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participantes extends Model
{
     use SoftDeletes;
    

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

    protected $table = 'TBL_Participantes';
    
/**
     * llave primaria utilizada por el modelo
     *
     * @var string
     */

    protected $primaryKey = 'PK_PTPT_Participantes';
    
/**
     * casilla utilizadas en la tabla y el modelo
     *
     * @var string
     */
    protected $fillable = ['FK_TBL_Convenio_Id','FK_TBL_Usuarios_Id','PTPT_Fecha_Inicio','PTPT_Fecha_Fin'];
    
    /**
     * Atributos que con muteadas
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /*
    *Función de conexión entre las tablas de TBL_Participantes y TTBL_Convenio
    *por los campo de FK_TBL_Convenios y PK_Convenios
    *para realizar las busquedas complementarias
    */     
    public function conveniosParticipante()
    {
        return $this->belongsto(Convenio::class, 'FK_TBL_Convenio_Id', 'PK_CVNO_Convenio');
    }
    
    /*
    *Función de conexión entre la tabla TBL_Participantes y TBL_Usiario
    *por los campo de FK_TBL_Usuarios y identity_no
    *para realizar las busquedas complementarias
    */      
    public function usuariosParticipantes()
    {
        return $this->belongsto( Usuario::class, 'FK_TBL_Usuarios_Id', 'PK_USER_Usuario');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 21/04/2018
 * Time: 4:20 PM
 */

namespace App\Container\Audiovisuals\src;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sanciones extends Model
{
    use SoftDeletes;
    /**
     * Conexión de la base de datos usada por el modelo
     *
     * @var string
     */
    protected $connection = 'audiovisuals';
    /**
     * Tabla utilizada por el modelo.
     *
     * @var string
     */
    protected $table = "TBL_Sanciones";

    /**
     * Atributo softdelete.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * Atributos que son asignables.
     *
     * @var array
     */

    protected $fillable = [
        'FK_SNS_Id_Funcionario',
        'FK_SNS_Id_Administrador',
        'SNS_Fecha',
        'SNS_Descripcion',
        'FK_SNS_Id_Tipo_Sancion',
        'SNS_Costo',
        'FK_SNS_Id_Solicitud',
        'SNS_Sancion_General',
        'SNS_Numero_Orden',
        'SNS_Estado_Cancelacion',
        'SNS_FK_Id_Estado',
    ];
    /**
     * Función que retorna la relación entre la tabla 'TBL_Prestamos' y la tabla 'TBL_Usuario_Audiovisuales'
     * a través de la llave foránea 'PRT_FK_Funcionario_id' y la llave 'USER_FK_User'
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consultaUsuarioAudiovisuales()
    {
        return $this->belongsTo(UsuarioAudiovisuales::class,'FK_SNS_Id_Funcionario','USER_FK_User');
    }
    /**
     * Función que retorna la relación entre la tabla 'TBL_Prestamos' y la tabla 'users'
     * a través de la llave foránea 'PRT_FK_Administrador_Entrega_id' y la llave 'id'
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function	consultarAdministradorEntrega(){
        return $this->belongsTo(UsuarioAudiovisuales::class,'FK_SNS_Id_Administrador','USER_FK_User');
    }
    /**
     * Función que retorna la relación entre la tabla 'TBL_Prestamos' y la tabla 'users'
     * a través de la llave foránea 'PRT_FK_Administrador_Entrega_id' y la llave 'id'
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function	consultarSolicitud(){
        return $this->belongsTo(Solicitudes::class,'FK_SNS_Id_Solicitud','id');
    }
    /**
     * Función que retorna la relación entre la tabla 'TBL_Prestamos' y la tabla 'users'
     * a través de la llave foránea 'PRT_FK_Administrador_Entrega_id' y la llave 'id'
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function	consultarSolicituds(){
        return $this->belongsTo(Solicitudes::class,'FK_SNS_Id_Solicitud','id');
    }

}
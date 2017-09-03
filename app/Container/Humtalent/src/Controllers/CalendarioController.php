<?php
/**
 * Created by PhpStorm.
 * User: Yeison Gomez
 * Date: 8/08/2017
 * Time: 9:03 PM
 */

namespace App\Container\Humtalent\src\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Container\Users\Src\Interfaces\UserInterface;
use App\Container\Humtalent\src\Event;
use App\Container\Humtalent\src\Notification;
use App\Container\Overall\Src\Facades\AjaxResponse;
use Illuminate\Support\Facades\Auth;
use App\Notifications\HeaderSiaaf;
use Carbon\Carbon;

class CalendarioController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getEvent(Request $request){ //funcion para obtener tanto lso eventos como las notificaciones que esten registradas
        $eventos = Event::all(); //se realiza la consulta para traer todos los eventos registrados
        $events=array(); //arreglo para almacenar los eventos y notificaciones
        foreach ($eventos as $evento){ //se recorre la consulta realizada a los eventos
            $e=array(); //arreglo para almacenar cada registro de la consulta
            $e['title']=$evento['EVNT_Descripcion'];    //se gurda cada variable de la consulta en el vector con llaves
            $e['start']=$evento['EVNT_Fecha_Inicio'];   //que sean entendidas por la libreria de jquery full calendar y permitir que se muetren de manera correcta
            if($evento['EVNT_Fecha_Inicio'] != $evento['EVNT_Fecha_Fin'] ){ //si las fechas de inicio y de fin del evento son diferentes se le agregga un dia de mas
                $fecha =strtotime('+1 day', strtotime($evento['EVNT_Fecha_Fin']));//para que se muestre correctamente en el calendario
                $fecha=date('Y-m-d',$fecha);                                    //debido a que la libreria maneja un manejo diferente en los dias
                $e['end']=$fecha;
            }else{
                $e['end']=$evento['EVNT_Fecha_Fin'];
            }
            $e['id']=$evento['PK_EVNT_IdEvento'];
            $e['allDay']="true";                        //permite que el evento se establezca de manera correcta en el calendario
            $e['color']='#1988E3';                  //se establece un color azul especifico para mostrar los eventos
            $e['type']="Evento";
            $e['hora']=$evento['EVNT_Hora'];
            $e['notif']=$evento['EVNT_Fecha_Notificacion'];
            array_push($events,$e);                        //se mezclan los arreglos por cada registro de la BD
        }                               //una vez se guarden todos los eventos consultados
        $recordatorios = Notification::all();   //se realiza la consulta ahora a la tabla de notificaciones que almacena los recordatorios
        foreach ($recordatorios as $recordatorio){ //se recorre la consulta
            $e=array();
            $e['title']=$recordatorio['NOTIF_Descripcion']; //y de la misma forma que en el caso de los eventos
            $e['start']=$recordatorio['NOTIF_Fecha_Inicio']; //se almacenan las variables de forma entendible para la libreria
            $e['end']=$recordatorio['NOTIF_Fecha_Fin'];
            $e['id']=$recordatorio['PK_NOTIF_Id_Notificacion'];
            $e['allDay']="true";
            $e['color']='#25C279';                  //se asigna un color verde para als notificaciones
            $e['type']="Recordatorio";
            $e['notif']=$recordatorio['NOTIF_Fecha_Notificacion'];
            array_push($events,$e);     // se realiza la mezcla entre vectores
        }
        return json_encode($events); //y se envia a la libreria el vector con los datos tanto de los eventos como de las notificaciones
    }

    public function index(){        //funcion que llama a la vista de calendario
        return view('humtalent.calendario.calendario');
    }

    public function store(Request $request){ //función que almacena las notificaciones o recordatorios
        if($request['type'] == 'new') { //verifica que la peticón eviada tenga la variable type == new
            Notification::create([      //para asi poder crear el registro nuevo a la base de datos
                'NOTIF_Descripcion' => $request['title'],
                'NOTIF_Fecha_Inicio' => $request['startdate'], //se alamcenan las variables correspondientes
                'NOTIF_Fecha_Fin' => $request['endDate'],
                'NOTIF_Estado_Notificacion' => "Activa",
            ]);
            $idNotif=Notification::where('NOTIF_Descripcion',$request['title']) // inmediatamente se realiza la consulta a la base de datos
                                            ->get(['PK_NOTIF_Id_Notificacion'])->last(); //del ultimo registro almacenado para obtener la llave primaria ya que en esta tabla es auntoincrementable
            return json_encode($idNotif['PK_NOTIF_Id_Notificacion']); //se envia a la libreria la llave primaria (PK) de la notificación almacenada
        }//un vez la libreria reciba la PK llamara un formulario para solicitar la fecha de notofocación que asu vez llama a la funcion storeDate
    }
    public function storeDate(Request $request){ //funcion que actualiza la fecha de notificación para los recordatorios, recibe los datos enviados desde un formulario
        Notification::where('PK_NOTIF_Id_Notificacion', $request['PK_NOTIF_Id_Notificacion'])
                        ->update(['NOTIF_Fecha_Notificacion'=>$request['NOTIF_Fecha_Notificacion']]); //realiza la respectiva actualización en la base de datos
        $notification=array( //y envia un mensaje de notificación
            'message'=>'El recordatorio fue actualizado correctamente',
            'alert-type'=>'success'
        );
        return back()->with($notification);

    }
    public function storeDateEvent(Request $request){//en caso de que el susuario cambie de fecha desde el calendario un evento, esta funcuión es llamada para actualizar la fecha de notificación
        Event::where('PK_EVNT_IdEvento', $request['PK_EVNT_IdEvento'])
             ->update(['EVNT_Fecha_Notificacion'=>$request['EVNT_Fecha_Notificacion']]);//se realiza la actualización en la base de datos de la fecha de notificación para el evento
        $notification=array( //y se envia un mensaje de notificación
            'message'=>'El evento fue actualizado correctamente',
            'alert-type'=>'success'
        );
        return back()->with($notification);
    }
    public function updateDateNotification(Request $request){//en caso de que el usuario cambie de fecha de la notificación/ evento o alargue su tiempo de duración esta función será llamada
        if($request['type']== 'endDateUpdate'){//desde el script de la vista se envia el tipo de petición si es endDateUpdate quiere decir que se desea actualizar la fecha final de la notificación o evento
            if($request['eventType'] == 'Recordatorio') { //se verifica si es un recordatorio
                Notification::where('PK_NOTIF_Id_Notificacion', $request['eventId']) //para así mismo realizar la respectiva actualización de los datos en la tabla notificación
                    ->update(['NOTIF_Fecha_Fin' => $request['endDate']]);
            }else{                                       //si no es un recordatoriio se deduce que es un  evento
                if($request['startdate'] != $request['endDate'] ){ //al actualizar las fechas la libreria envia con un dia de mas a como se muestra en el formulario
                    $fecha =strtotime('-1 day', strtotime($request['endDate'])); //y para almacenar de manera correcta la fecha se le resta un dia
                    $fecha=date('Y-m-d',$fecha);                                //de la misma manera se actua en el caso de que se resete al fecha
                }else{
                    $fecha=$request['endDate'];        //para permitir que se muetren de manera correcta
                }
                Event::where('PK_EVNT_IdEvento',$request['eventId']) // y se realiza la respectiva actulización en la tabla
                     ->update(['EVNT_Fecha_Fin' => $fecha]);
            }
        }elseif ($request['type'] == 'resetDate'){ //en caso de que el tipo de petición sea resetdate quiere decir que se cambio completamente la fecha de inicio y fin del evento o recordatorio
            if($request['eventType'] == 'Recordatorio') { //se verifica si es un recordatorio
                Notification::where('PK_NOTIF_Id_Notificacion', $request['eventId']) //y se realiza la actualización de ambas fechas
                    ->update(['NOTIF_Fecha_Inicio' => $request['startdate'], 'NOTIF_Fecha_Fin' => $request['endDate']]);
            }else{
                if($request['startdate'] != $request['endDate'] ){
                    $fecha =strtotime('-1 day', strtotime($request['endDate']));
                    $fecha=date('Y-m-d',$fecha);
                }else{
                    $fecha=$request['endDate'];        //para permitir que se muetren de manera correcta
                }
                Event::where('PK_EVNT_IdEvento',$request['eventId']) //si no es un recordatorio es un evento
                    ->update(['EVNT_Fecha_Inicio'=> $request['startdate'],'EVNT_Fecha_Fin' => $fecha]);//se actualizan los datos
            }
            return json_encode(array('id'=>$request['eventId'],'eventType'=>$request['eventType']));//se retorna el id del evento modificado y el tipo para actualizar el calendario
        }
    }
    public function updateNotification(Request $request){//en caso de que el usuario desee cambiar el titulo de la notificación aparecerá un formulario de actulización de datos y esta funcion será llamada
        Notification::where('PK_NOTIF_Id_Notificacion', $request['PK_NOTIF_Id_Notificacion'])// cuando se envie el formulario se actulizan los datos
                    ->update(['NOTIF_Descripcion'=>$request['NOTIF_Descripcion'],
                              'NOTIF_Fecha_Notificacion'=>$request['NOTIF_Fecha_Notificacion'] ]);
        $notification=array(//se envia un mensaje de notificación de los cambios
            'message'=>'El recordatorio fue editado correctamente',
            'alert-type'=>'success'
        );
        return back()->with($notification);
    }
    public function updateEvent(Request $request){ //esta función será llamada cuando se desea editar los datos de un evento desde el calendario
        $request['EVNT_Hora']=strtotime($request['EVNT_Hora']); //se hace el cambio en el formato de la hora del evento
        $request['EVNT_Hora']=date("H:i",$request['EVNT_Hora']);

        $documento= Event::find($request['PK_NOTIF_Id_Notificacion']); //se busca el evento a actulizar
        $documento->fill($request->all());  //se actulizan los datos correspondientes
        $documento->save();
        $notification=array( //se retorna el mensaje de aviso
            'message'=>'La información del Evento fue modificada',
            'alert-type'=>'info'
        );
        return back()->with($notification);
    }
    public function deleteNotification(Request $request){//esta función se invoca cuando se desee eliminar tanto un evnto como una notificación
        if($request->ajax()) {//se verifica que se envie desde una petición ajax
            if ($request['eventType'] == 'Recordatorio') {//se verifica si es un recordatorio el que se desea eliminar
                Notification::where('PK_NOTIF_Id_Notificacion', $request['eventId'])//se busca el registro
                    ->delete();     //y se realiza la respectiva eliminación
            } else { //si no es un recordatorio se deduce que es un evento
                Event::where('PK_EVNT_IdEvento', $request['eventId'])   //se busca el registro a eliminar
                    ->delete();//se realiza la eliminación
            }
            return AjaxResponse::success( //se retorna un mensaje de notificación
                '¡Bien hecho!',
                'Datos eliminados correctamente.'
            );
        }else{ //en caso de que la petición no sea ajax se muestra el mensaje de error
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }

    }

    function crearNotificaciones() { //función para generar  notificaciones
        $fecha=getdate(); //se toma la fecha actual
        $dia= $fecha['wday']; //se toma el numero del día
        $user = Auth::user(); //se verifica el usuario logueado
        if($dia == 5)  //si el día es 5 o viernes se crea la notificación de documentación completa
        {
            $data = [
                'url' => route('humtalent.empleado.notificaciones.empleadosDocumentosCompletos'), //ruta que muestra la tabla d elos empleados que tienen la doc completa
                'description' => '¡Empleados con documentos completos!',
                'image' => 'assets/layouts/layout2/img/avatar3.jpg'
            ];
        }
       if($dia == 3) { //si el día es 3 o miercoles se crea la notificación de documentación incompleta
            $data = [
                'url' => route('humtalent.empleado.notificaciones.empleadosDocumentosIncompletos'), //ruta que muestra la tabla d elos empleados que tienen la doc incompleta
                'description' => '¡Empleados con documentos incompletos!',
                'image' => 'assets/layouts/layout2/img/avatar3.jpg'
            ];
        }
        $user->notify(new HeaderSiaaf($data)); // se crea la notificación
        $fechaActual =  Carbon::now();      //se toma la fecha actual
        $fechaActual = $fechaActual->format('Y-m-d');
        $recordatorios = Notification::all(); //se consultan los datos de los recordatorios
        $eventos = Event::all(); //se consultan los datos de los eventos

        foreach ($recordatorios as $recordatorio)
        {
            if($recordatorio['NOTIF_Fecha_Notificacion'] == $fechaActual) //cuando la fecha del recordatorio es igual a la actual se crea la notificación
            {
                $data = [
                    'url' => route('talento.humano.calendario.index'), //ruta que muestra el calendario
                    'description' => '¡Recordatorio pendiente!',
                    'image' => 'assets/layouts/layout2/img/avatar3.jpg'
                ];
                $user->notify(new HeaderSiaaf($data));
            }
        }

        foreach ($eventos as $evento) //se recorren  los datos de los eventos
        {
            if($evento['EVNT_Fecha_Notificacion'] == $fechaActual) // cuando la fecha actual es igual a la de la fecha de notificar el eventos se crea la notificación
            {
                $data = [
                    'url' => route('talento.humano.calendario.index'), //ruta que muestra el calendario
                    'description' => '¡Evento pendiente!',
                    'image' => 'assets/layouts/layout2/img/avatar3.jpg'
                ];
                $user->notify(new HeaderSiaaf($data));
            }
        }

        return back()->withInput();
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Yeison Gomez
 * Date: 11/07/2017
 * Time: 10:49 PM
 */

namespace App\Container\Humtalent\src\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Container\Users\Src\Interfaces\UserInterface;
use App\Container\Humtalent\src\Event;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Container\Humtalent\src\Persona;
use App\Container\Humtalent\src\Asistent;
use App\Container\Overall\Src\Facades\AjaxResponse;


class EventoController extends Controller
{
    protected $userRepository;
    protected $id;
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function tablaEventos(Request $request){ //funcion que consulta los eventos registrados y los envía al datatable correspondiente
        if ($request->ajax()) {
            return DataTables::of(Event::all())
                ->addIndexColumn()
                ->make(true);
        } else {
            return response()->json([
                'message' => 'Incorrect request',
                'code' => 412
            ], 412);
        }
    }
    public function tablaAsistentes(Request $request, $id){
        $asistentes=Asistent::with('Personas')->where('FK_TBL_Eventos_IdEvento',$id)->get();
        $empleados=[];
        foreach ($asistentes as $asistente){
            $empleados=array_merge($empleados,[$asistente->personas]);
        }
        if ($request->ajax()) {
            return DataTables::of($empleados)
                ->addIndexColumn()
                ->make(true);
        } else {
            return response()->json([
                'message' => 'Incorrect request',
                'code' => 412
            ], 412);
        }
    }
    public function posiblesAsistentes(Request $request, $id_Evento){
        $this->id=$id_Evento;
        $asistentes=Persona::whereDoesntHave('Asistents',function ($query) {
            $query->where('FK_TBL_Eventos_IdEvento',$this->id);
        })->get();
        if ($request->ajax()) {
            return DataTables::of($asistentes)
                ->addIndexColumn()
                ->make(true);
        } else {
            return response()->json([
                'message' => 'Incorrect request',
                'code' => 412
            ], 412);
        }
    }
    public function registrarAsistentes(Request $request,$id, $ced){
        if($request->ajax() && $request->isMethod('GET')) {
            Asistent::create([
                'ASIST_Informe' => 'No',
                'FK_TBL_Eventos_IdEvento' => $id,
                'FK_TBL_Persona_Cedula' => $ced,
            ]);
            return AjaxResponse::success(
                '¡Registro exitoso!',
                'El asistente fue registrado correctamente.'
            );
        }else{
                return AjaxResponse::fail(
                    '¡Lo sentimos!',
                    'No se pudo completar tu solicitud.'
                );
            }

    }

    public function consultarAsistentes(Request $request, $id)
    {
        if($request->ajax() && $request->isMethod('GET'))
        {
            return view('humtalent.eventos.consultarAsistentes',compact('id'));
        }
        else{
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }
    }

    public function listaEmpleados(Request $request, $id){
        if($request->ajax() && $request->isMethod('GET')) {
            return view('humtalent.eventos.registrarAsistentes',compact('id'));
        }
        else{
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }
    }

    public function registrarTodosAsistentes(Request $request,$id, $datos){
        $datos=explode(';',$datos);
        if($request->ajax() && $request->isMethod('POST')){
            for ($i=0; $i< count($datos)-1; $i++){
                Asistent::create([
                    'ASIST_Informe' => 'No',
                    'FK_TBL_Eventos_IdEvento' => $id,
                    'FK_TBL_Persona_Cedula'   => $datos[$i],
                ]);
            }
            return AjaxResponse::success(
                '¡Registro exitoso!',
                'Todos los asistentes fueron registrados correctamente.'
            );
        }else{
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }

    }
    public function deleteAsistentes(Request $request,$id, $ced){
        if($request->ajax() && $request->isMethod('GET')){
        Asistent::where('FK_TBL_Persona_Cedula',$ced)
                ->where('FK_TBL_Eventos_IdEvento',$id)->delete();
        return AjaxResponse::success(
            '¡Proceso exitoso!',
            'El asistente fue eliminado correctamente.'
        );}else {
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }
    }
    /**
     * @return UserInterface
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//muestra todos los eventos que esten registrados
    {
        return view('humtalent.eventos.listaEventos');
    }

    public function indexAjax(Request $request)//muestra todos los eventos que esten registrados
    {
        if($request->ajax() && $request->isMethod('GET')) {
            return view('humtalent.eventos.ajaxListaEventos');
        }
        else{
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)//preseta el formulario para registrar un documento
    {
        if($request->ajax() && $request->isMethod('GET')) {
            return view('humtalent.eventos.registrarEvento');
        }
        else{
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//almacena un documento enviado desde el formulario del la funcion create
    {
        if($request->ajax() && $request->isMethod('POST')){
            $hora=$request['EVNT_Hora'];
            $hora=strtotime($hora);
            $hora=date("H:i",$hora);
            Event::create([
                'EVNT_Descripcion'  => $request['EVNT_Descripcion'],
                'EVNT_Fecha_Inicio' => $request['EVNT_Fecha_Inicio'],
                'EVNT_Fecha_Fin' => $request['EVNT_Fecha_Fin'],
                'EVNT_Fecha_Notificacion' => $request['EVNT_Fecha_Notificacion'],
                'EVNT_Hora'         => $hora,
            ]);
            return AjaxResponse::success(
                '¡Bien hecho!',
                'Datos almacenados correctamente.'
            );
        }else{
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)//presenta el formulario para editar un evento deseado
    {
        if($request->ajax() && $request->isMethod('GET'))
        {
            $evento = Event::find($id);
            return view('humtalent.eventos.editarEvento', [
                'evento' => $evento]);
        }
        else
        {
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)//se realiza la actulización de datos de los eventos
    {
        if($request->ajax() && $request->isMethod('POST')) {
            $request['EVNT_Hora']=strtotime($request['EVNT_Hora']);
            $request['EVNT_Hora']=date("H:i",$request['EVNT_Hora']);

            $documento= Event::find($request['PK_EVNT_IdEvento']);
            $documento->fill($request->all());
            $documento->save();
            return AjaxResponse::success(
                '¡Bien hecho!',
                'Datos modificados correctamente.'
            );
        }else{
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)//se elimina el registro de un documento
    {
        if($request->ajax() && $request->isMethod('DELETE')){
        Asistent::where('FK_TBL_Eventos_IdEvento',$id)->delete();
        Event::destroy($id);
            return AjaxResponse::success(
                '¡Bien hecho!',
                'Datos eliminados correctamente.'
            );
        }else{
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }
    }
}
<?php

namespace App\Container\Audiovisuals\Src\Controllers;

use App\Container\Audiovisuals\src\Articulo;
use App\Container\Audiovisuals\Src\Interfaces\CarrerasInterface;
use App\Container\Audiovisuals\Src\Interfaces\FuncionarioInterface;
use App\Container\Audiovisuals\src\Kit;
use App\Container\Audiovisuals\src\Programas;
use App\Container\Audiovisuals\src\Solicitudes;
use App\Container\Audiovisuals\src\TipoArticulo;
use App\Container\Audiovisuals\src\UsuarioAudiovisuales;
use App\Container\Audiovisuals\src\Validaciones;
use App\Container\Overall\Src\Facades\AjaxResponse;
use App\Container\Users\Src\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Scalar\String_;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class FuncionarioController extends Controller
{

    protected $funcionarioRepository;
    protected $carrerasRepository;

    public function __construct(FuncionarioInterface $funcionarioRepository, CarrerasInterface $carrerasRepository)
    {
        $this->funcionarioRepository = $funcionarioRepository;
        $this->carrerasRepository    = $carrerasRepository;
    }
    public function opcionReservaArticuloAjax(){
        $validaciones = Validaciones::all();
        $tipo = TipoArticulo::whereHas('consultarArticulos')->pluck('TPART_Nombre', 'id');
        //dd($array);
        return view('audiovisuals.funcionario.prestamoAjax.reservarArticuloAjax', [
            'tipoArticulos' => $tipo->toArray(),
            'validaciones' => $validaciones,
        ]);
    }
	//datatable articulos1
    public function dataArticulo(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
			$user    = Auth::user();
			$userid  = $user->id;
            //solicitudes con el usuario autenticado
			//consulta las reservas realizadas por el funcionario logueado
			$solicitudes = Solicitudes::with(['consultaTipoArticulo' ])->where([
					['PRT_FK_Funcionario_id','=',$userid],
                    ['PRT_FK_Tipo_Solicitud','=',1]//reservas
				]
			)->get();
            $solicitudes =($solicitudes)->groupBy('PRT_Num_Orden');
            $array = array();
            foreach ($solicitudes as $le) {
                array_push($array, $le[0]);
            }
			return DataTables::of($array)
			->addIndexColumn()
			->make(true);
			} else {
				return AjaxResponse::fail(
				'¡Lo sentimos!',
				'No se pudo completar tu solicitud.'
				);
			}
    }
    //dataTable kits
	public function dataKit(Request $request)
	{
		if ($request->ajax() && $request->isMethod('GET')) {
			$user    = Auth::user();
			$userid  = $user->id;
			//solicitudes con el usuario autenticado
			//consulta las reservas realizadas por el funcionario logueado
			$solicitudes = Solicitudes::with(['consultaKitArticulo' ])->where([
					['PRT_FK_Funcionario_id','=',$userid],
					['PRT_FK_Tipo_Solicitud','=',1],
                    ['PRT_FK_Kits_id','!=',1]
				]
			)->get();
			return DataTables::of($solicitudes)
				->addIndexColumn()
				->make(true);
		} else {
			return AjaxResponse::fail(
				'¡Lo sentimos!',
				'No se pudo completar tu solicitud.'
			);
		}
	}
	//indexarticulo
    public function reserva(Request $request)
    {
		//consulta si el usuario logueado esxite en la tabla Audiovisuales User
    	$usario = $this->consultarUsuario();
        //$validaciones = Validaciones::all();
		//array de carreras disponibles para el funcionario
		//$carreras = $this->carrerasRepository->index([])->pluck('PRO_Nombre', 'id');
        $carreras = Programas::all()->pluck('PRO_Nombre', 'id');
		return view('audiovisuals.funcionario.reservarArticulo',[
			'programas'=>$carreras->toArray(),
			'numero'=>$usario, //bandera para abrir el modal de registro del usuairo que esta logueado
            //'validaciones'=>$validaciones
		]);
	}
    public function reservaindexAjax(Request $request)
    {
        //consulta si el usuario logueado esxite en la tabla Audiovisuales User
        $usario = $this->consultarUsuario();
        $carreras = Programas::all()->pluck('PRO_Nombre', 'id');
        return view('audiovisuals.funcionario.prestamoAjax.reservarAjax',[
            'programas'=>$carreras->toArray(),
            'numero'=>$usario, //bandera para abrir el modal de registro del usuairo que esta logueado
            //'validaciones'=>$validaciones
        ]);
    }
	//indexkit
	public function reservaKits(){
		//consulta si el usuario logueado esxite en la tabla Audiovisuales User
		$usario = $this->consultarUsuario();
		//array de carreras disponibles para el funcionario
		//$carreras = $this->carrerasRepository->index([])->pluck('PRO_Nombre', 'id');
        $carreras = Programas::all()->pluck('PRO_Nombre', 'id');
        $validaciones= Validaciones::all();
    	return view('audiovisuals.funcionario.reservarKit',
			[
			    'programas'=>$carreras->toArray(),
				'numero'=>$usario,
                'validaciones'=>$validaciones
			]);
	}
    public function almacenarArticulo(Request $request)
    {
		if ($request->ajax() && $request->isMethod('POST')) {
			$user=Auth::user();
            $id=$user->id;
			$valores=$this->consultarArticulo($request['PRT_FK_Articulos_id']);
            Solicitudes::create([
                    'PRT_FK_Articulos_id'=> $valores['FK_ART_Tipo_id'],
                    'PRT_Fecha_Inicio'  => $request['PRT_Fecha_Inicio'],
                    'PRT_Fecha_Fin'     => $request['PRT_Fecha_Fin'],
					'PRT_FK_Funcionario_id'=> $id,
					'PRT_FK_Kits_id'=> $valores['FK_ART_Kit_id'],
					'PRT_Observacion_Entrega'=> '',
					'PRT_Observacion_Recibe'=> '',
					'PRT_FK_Estado'=> 1,
					'PRT_FK_Tipo_Solicitud'=> 1,//reserva
					'PRT_FK_Administrador_Entrega_id'=>0,
					'PRT_FK_Administrador_Recibe_id'=>0

            ]);
			return AjaxResponse::success(
				'¡Bien hecho!',
				'Reserva registrada correctamente.'
			);

		} else {
			return AjaxResponse::fail(
				'¡Lo sentimos!',
				'No se pudo completar tu solicitud.'
			);
		}
	}
    public function cargarVistaReservaArticulo(Request $request){
        if ($request->ajax() && $request->isMethod('POST')) {
            $dtI=Carbon::parse($request['PRT_Fecha_Inicio']);
            $dtF=Carbon::parse($request['PRT_Fecha_Inicio']);
            $dtF->addDays(((int)$request['numDias']));
            $dtF->addHours(((int)$request['numHoras']));
            $dtF=$dtF->toDateTimeString();
            $dtI=$dtI->toDateTimeString();
            //$dt->format('l jS \\of F Y h:i:s A');
            $array=array();
            $array2=array();
            $array = array_add($array,'fechaInicial',$dtI);
            array_push($array2,$array);
            $array = array_add($array,'fechaFinal',$dtF);
            array_push($array2,$array);
            //dd($data);

            return AjaxResponse::success(
                '¡Bien hecho!',
                'Reserva registrada correctamente.',
                $array
            );
        } else {
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }
    }
	public function storeKit(Request $request)
	{
		if ($request->ajax() && $request->isMethod('POST')) {
			$user=Auth::user();
			$id=$user->id;
            $numOrden = (Solicitudes::max('PRT_Num_Orden')) + 1;
			//$valores=$this->consultarKit($request['PRT_FK_Kits_id']);
            $dtI=Carbon::parse($request['PRT_Fecha_Inicio']);
            $dtF=Carbon::parse($request['PRT_Fecha_Inicio']);
            $dtF->addDays(((int)$request['numDias']));
            $dtF->addHours(((int)$request['numHoras']));
			Solicitudes::create([
				'PRT_FK_Articulos_id'=> 1,
				'PRT_Fecha_Inicio'  => $request['PRT_Fecha_Inicio'],
				'PRT_Fecha_Fin'     => $dtF,
				'PRT_FK_Funcionario_id'=> $id,
				'PRT_FK_Kits_id'=> $request['PRT_FK_Kits_id'],
				'PRT_Observacion_Entrega'=> '',
				'PRT_Observacion_Recibe'=> '',
				'PRT_FK_Estado'=> 1,
				'PRT_FK_Tipo_Solicitud'=> 1,//reserva
				'PRT_FK_Administrador_Entrega_id'=>0,
				'PRT_FK_Administrador_Recibe_id'=>0,
                'PRT_Num_Orden'=>$numOrden,
                'PRT_Cantidad'=>1
			]);
//		}
			return AjaxResponse::success(
				'¡Bien hecho!',
				'Reserva registrada correctamente.'
			);
		} else {
			return AjaxResponse::fail(
				'¡Lo sentimos!',
				'No se pudo completar tu solicitud.'
			);
		}
	}
	public function storePrograma(Request $request){

		if ($request->ajax() && $request->isMethod('POST')) {
            $user    = Auth::user();
            $userid  = $user->id;
			UsuarioAudiovisuales::create([
				'USER_FK_Programa'=>$request->get('FK_FUNCIONARIO_Programa'),
				'USER_FK_User'=>$userid,
			]);
			return AjaxResponse::success(
				'¡Bien hecho!',
				'Programa registrado correctamente.'
			);
		} else {
			return AjaxResponse::fail(
				'¡Lo sentimos!',
				'No se pudo completar tu solicitud.'
			);
		}
	}
	public function reservaRepeatcrear(Request $request){
        if ($request->ajax() && $request->isMethod('POST')) {
            $infoRepeat = json_decode($request->get('infoPrestamo'));
            $numOrden = (Solicitudes::max('PRT_Num_Orden')) + 1;
            $user = Auth::user();
            $funcionarioId = $user->id;
            foreach ($infoRepeat as $prestamo) {
                $dtI = Carbon::parse($prestamo->fechaInicio);
                $dtF = Carbon::parse($prestamo->fechaFin);
                Solicitudes::create([
                    'PRT_FK_Articulos_id' => $prestamo->tipoArticulosSelect,
                    'PRT_Fecha_Inicio' => $dtI,
                    'PRT_Fecha_Fin' => $dtF,
                    'PRT_FK_Funcionario_id' => $funcionarioId,
                    'PRT_FK_Kits_id' => 1,
                    'PRT_Observacion_Entrega' => '',
                    'PRT_Observacion_Recibe' => '',
                    'PRT_FK_Estado' => 2,
                    'PRT_FK_Tipo_Solicitud' => 1,//reserva
                    'PRT_FK_Administrador_Entrega_id' => 0,
                    'PRT_FK_Administrador_Recibe_id' => 0,
                    'PRT_Num_Orden' => $numOrden,
                    'PRT_Cantidad' => 1//verificar porque este campo
                ]);
            }
            return AjaxResponse::success(
                '¡Bien hecho!',
                'Reserva registrada correctamente.'
            );
        } else {
            return AjaxResponse::fail(
                '¡Lo sentimos!',
                'No se pudo completar tu solicitud.'
            );
        }

    }
	//funcion la cual lista el textArea con los tipos de articulos que el kit tiene
	public function consultarArticulosKit(Request $request,$idKit){

		if($request->ajax() && $request->isMethod('GET')){

			$articulos = Articulo::with(['consultaTipoArticulo','consultaKitArticulo'])->where([
				['FK_ART_Kit_id','=',$idKit]
			])->get();
			return AjaxResponse::success(
				'¡Bien hecho!',
				'Datos consultados correctamente.',
				json_decode($articulos)

			);
		}else{
			return AjaxResponse::fail(
				'¡Lo sentimos!',
				'No se pudo completar tu solicitud.'
			);
		}

	}

    public function consultarKitsDisposnibles(Request $request){
		if($request->ajax() && $request->isMethod('GET')){
			$kits = Kit::all();
			return AjaxResponse::success(
				'¡Bien hecho!',
				'Datos consultados correctamente.',
				$kits
			);
		}else{
			return AjaxResponse::fail(
				'¡Lo sentimos!',
				'No se pudo completar tu solicitud.'
			);
		}
	}
    public function consultarTiposArticulosDisposnibles(Request $request){

		if($request->ajax() && $request->isMethod('GET')){
			$tipo = TipoArticulo::whereHas('consultarArticulos', function ($query) {
				$query->where('FK_ART_Estado_id', '=', 1);
			})->get();
			return AjaxResponse::success(
				'¡Bien hecho!',
				'Datos consultados correctamente.',
				$tipo
			);
		}else{
			return AjaxResponse::fail(
				'¡Lo sentimos!',
				'No se pudo completar tu solicitud.'
			);
		}
	}
    public function consultarUsuario(){
		$user    = Auth::user();
		$userid  = $user->id;
		$usuario  = UsuarioAudiovisuales::where('USER_FK_User', '=',$userid)->first();
		$bandera=1;
		if ($usuario == null) {
			$bandera = 0;
		}
		return $bandera;
	}
    public function consultarArticulo($reserva){

		$query=Articulo::where([
			['FK_ART_Tipo_id','=',$reserva],
			['FK_ART_Estado_id','=',1]

		])->first();
		/////////////
		/// si el articulo pertenece a un kit , cambia el estado del kit
		/// el kit ya no estara completo para ser reservado
		/// // /////////////
		if( $query['FK_ART_Kit_id'] != 1 ){

			Articulo::where([
				['id','=',$query['id']],

			])->update(['FK_ART_Estado_id'=>3]);

			Kit::where([
				['id','=',$query['FK_ART_Kit_id']],

			])->update(['KIT_FK_Estado_id' => 3]);

		}else{

			Articulo::where([
				['id','=',$query['id']],
			])->update(['FK_ART_Estado_id'=>3]);
		}
		return $query;

	}
	public function consultarKit($PRT_FK_Kits_id){
		$query=Kit::where([
			['id','=',$PRT_FK_Kits_id],
		])->update(['KIT_FK_Estado_id' => 3]);
		$query=Articulo::where([
			['FK_ART_Kit_id','=',$PRT_FK_Kits_id],
		])->update(['FK_ART_Estado_id' => 3]);

	}

}

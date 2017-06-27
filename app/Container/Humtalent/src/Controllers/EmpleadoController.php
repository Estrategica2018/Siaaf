<?php
/**
 * Created by PhpStorm.
 * User: Yeison Gomez
 * Date: 19/06/2017
 * Time: 2:20 PM
 */

namespace App\Container\Humtalent\src\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Container\Users\Src\Interfaces\UserInterface;
use App\Container\Humtalent\src\Persona;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{

    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('humtalent.empleado.registroEmpleado');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Persona::create([
            'PK_PRSN_Cedula'          => $request['cedula'],
            //'PRSN_Rol'                => $request['cedula'],
            'PRSN_Nombres'            => $request['name'],
            //'PRSN_Apellidos'          => $request['cedula'],
            'PRSN_Telefono'           => $request['telefono'],
            'PRSN_Correo'             => $request['email'],
            'PRSN_Direccion'          => $request['direccion'],
            'PRSN_Ciudad'             => $request['ciudad'],
            'PRSN_Eps'                => $request['eps'],
            'PRSN_Fpensiones'         => $request['fondoP'],
            'PRSN_Area'               => $request['area'],
            'PRSN_Caja_Compensacion'  => $request['cajaC'],
            //'PRSN_Estado_Persona'     => $request['cedula'],
        ]);
        return "Usuaruio Registrado";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('humtalent.empleado.consultaEmpleado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleado = Persona::find($id);
        return view('humtalent.empleado.editarEmpleado', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $empleado= Persona::find($id);
        $empleado->fill($request->all());
        $empleado->save();
        return "Usuario Actualizado";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Persona::destroy($id);
        return "Eliminando  ";
    }

}
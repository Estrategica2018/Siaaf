<?php

namespace App\Container\Carpark\src\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Container\Carpark\src\Dependencias;
use App\Container\Carpark\src\Estados;
use App\Container\Carpark\src\Usuarios;
use App\Container\Carpark\src\Motos;
use App\Container\Carpark\src\Ingresos;
use App\Container\Carpark\src\Historiales;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Container\Overall\Src\Facades\AjaxResponse;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class DependenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('carpark.dependencias.tablaDependencias');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response | \App\Container\Overall\Src\Facades\AjaxResponse
     */
    public function create(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            return view('carpark.dependencias.registroDependencias');
        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );

    }

    /**
     * Función que almacena en la base de datos un nuevo registro de acción.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Container\Overall\Src\Facades\AjaxResponse
     */
    public function store(Request $request)
    {
        if ($request->ajax() && $request->isMethod('POST')) {
            $generadorID = date_create();
            Dependencias::create([
                'PK_CD_IdDependencia' => date_timestamp_get($generadorID),
                'CD_Dependencia' => $request['CD_Dependencia'],
            ]);
            return AjaxResponse::success(
                '¡Bien hecho!',
                'Datos almacenados correctamente.'
            );
        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );

    }


    /**
     * Presenta el formulario con los datos para editar el regitro de una dependencia.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response | \App\Container\Overall\Src\Facades\AjaxResponse
     */
    public function edit(Request $request, $id)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $dependenciaRegistrada = Dependencias::find($id);
            return view('carpark.dependencias.editarDependencia',
                [
                    'dependenciaRegistrada' => $dependenciaRegistrada,
                ]);
        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );

    }

    /**
     * Se realiza la actualización de los datos de una dependencia.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Container\Overall\Src\Facades\AjaxResponse
     */
    public function update(Request $request)//
    {
        if ($request->ajax() && $request->isMethod('POST')) {
            $empleado = Dependencias::find($request['PK_CD_IdDependencia']);
            $empleado->fill($request->all());
            $empleado->save();
            return AjaxResponse::success(
                '¡Bien hecho!',
                'Datos modificados correctamente.'
            );
        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );

    }


    /**
     * Muestra todos las dependencias registradas por medio de una petición ajax.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response  | \App\Container\Overall\Src\Facades\AjaxResponse
     */
    public function indexAjax(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            return view('carpark.dependencias.ajaxTablaDependencias');
        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );

    }

}

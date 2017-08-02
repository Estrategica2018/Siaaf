<?php
/**
 * Talento Humano.
 */

use App\Container\Humtalent\src\Persona;
use App\Container\Humtalent\src\Event;
use App\Container\Humtalent\src\DocumentacionPersona;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

//RUTA DE EJEMPLO
Route::get('/', [
    'as' => 'talento.humano.index',
    'uses' => function(){
        return view('humtalent.example');
    }
]);

$controller = "\\App\\Container\\Humtalent\\Src\\Controllers\\";

//Rutas para el manejo de los empleados
Route::group(['prefix' => 'empleado'], function () {
    $controller = "\\App\\Container\\Humtalent\\Src\\Controllers\\";
    Route::get('index',[
        'uses' => $controller.'EmpleadoController@index',
        'as' => 'talento.humano.empleado.index'
    ]);
    Route::get('create',[
        'uses' => $controller.'EmpleadoController@create',
        'as' => 'talento.humano.empleado.create'
    ]);
    Route::post('store',[
        'uses' => $controller.'EmpleadoController@store',
        'as' => 'talento.humano.empleado.store'
    ]);
    Route::delete('empleado/destroy/{id?}',[
        'uses' => $controller.'EmpleadoController@destroy',
        'as' => 'talento.humano.empleado.destroy'
    ]);
    Route::get('empleado/edit/{id?}',[
        'uses' => $controller.'EmpleadoController@edit',
        'as' => 'talento.humano.empleado.edit'
    ]);
    Route::post('empleado/update/{id?}',[
        'uses' => $controller.'EmpleadoController@update',
        'as' => 'talento.humano.empleado.update'
    ]);
    Route::get('tablaEmpleados',[   //ruta que realiza la consulta de los empleados registrados
        'as' => 'talento.humano.tablaEmpleados',
        'uses' => function (Request $request) {
            if ($request->ajax()) {
                return Datatables::of(Persona::all())
                    ->addIndexColumn()
                    ->make(true);
            } else {
                return response()->json([
                    'message' => 'Incorrect request',
                    'code' => 412
                ], 412);
            }
        }
    ]);
});
Route::resource('document', $controller.'DocumentController',[  //ruta para el controlador encargado del CRUD de la Documentación
    'names'=>[
        'index'=> 'talento.humano.document.index',
        'create'=> 'talento.humano.document.create',
        'store'=> 'talento.humano.document.store',
        //'edit'=> 'talento.humano.document.edit',
        'update'=> 'talento.humano.document.update',
        'destroy'=> 'talento.humano.document.destroy',
        //'destroy'=> 'talento.humano.document.destroy',

    ]
]);

/*Route::get('empleadoList', function ()    { //ruta que prsenta la lista de los empleados registrados
    return view('humtalent.empleado.tablasEmpleados');
})->name('talento.humano.rrhh.empleadoList');*/

Route::get('buscarRadicar', [    //ruta para buscar los empleados  para hacer la radicación de documentos
    'as' => 'talento.humano.buscarRadicar', //Este es el alias de la ruta
    'uses' => function(){
        return view('humtalent.empleado.buscarEmpleado');
    }
]);
Route::post('listarDocsRad', [    //ruta listar los documentos requeridos y asociarlos a un empleado
    'as' => 'talento.humano.listarDocsRad', //Este es el alias de la ruta
    'uses' => $controller.'DocumentController@listarDocsRad'
]);
Route::post('radicarDocumentos', [    //ruta para  asociarlos los documentos requeridos a un empleado
    'as' => 'talento.humano.radicarDocumentos', //Este es el alias de la ruta
    'uses' => $controller.'DocumentController@radicarDocumentos'
]);
Route::post('afiliarEmpleado', [    //ruta para  asociarlos los documentos requeridos a un empleado
    'as' => 'talento.humano.afiliarEmpleado', //Este es el alias de la ruta
    'uses' => $controller.'DocumentController@afiliarEmpleado'
]);
Route::get('reiniciarRadicacion/{id}', [    //ruta para  asociarlos los documentos requeridos a un empleado
    'as' => 'talento.humano.reiniciarRadicacion', //Este es el alias de la ruta
    'uses' => $controller.'DocumentController@reiniciarRadicacion'
]);

Route::get('tablaDocumentos',[   //ruta que realiza la consulta de los empleados registrados
    'as' => 'talento.humano.tablaDocumentos',
    'uses' => function (Request $request) {
        if ($request->ajax()) {
            return Datatables::of(DocumentacionPersona::all())
                ->addIndexColumn()
                ->make(true);
        } else {
            return response()->json([
                'message' => 'Incorrect request',
                'code' => 412
            ], 412);
        }
    }
]);

Route::resource('evento', $controller.'EventoController',[  //ruta para el controlador encargado del CRUD de Eventos
    'names'=>[
        'index'=> 'talento.humano.evento.index',
        'create'=> 'talento.humano.evento.create',
        'store'=> 'talento.humano.evento.store',
        //'edit'=> 'talento.humano.evento.edit',
        'update'=> 'talento.humano.evento.update',
        //'destroy'=> 'talento.humano.evento.destroy',
    ]
]);

Route::get('listaEventos',[   //ruta que realiza listar los eventos registrados
    'as' => 'talento.humano.listaEventos',
    'uses' =>function() {
        return view('humtalent.eventos.listaEventos');
    }
]);

Route::get('tablaEventos',[   //ruta que realiza la consulta de los eventos registrados
    'as' => 'talento.humano.tablaEventos',
    'uses' => $controller.'EventoController@tablaEventos'
]);

Route::get('evento/asistentes/{id?}', [    //ruta para listar los empleados  asistentes a un evento seleccionado, recibe el id del evento seleccionado
    'as' => 'talento.humano.evento.asistentes', //Este es el alias de la ruta
    'uses' => function($id){
        return view('humtalent.eventos.consultarAsistentes',compact('id'));
    }
]);
Route::get('tablaAsistentes/{id}',[   //ruta que realiza la consulta de los empleados asistentes a un evento, recibe el id del evento seleccionado
    'as' => 'talento.humano.tablaAsistentes',
    'uses' => $controller.'EventoController@tablaAsistentes'
]);
Route::get('posAsitentes/{id}',[   //ruta que realiza la consulta de los empleados que no esten registrados en el evento, recibe el id del evento seleccionado
    'as' => 'talento.humano.posAsitentes',
    'uses' => $controller.'EventoController@posiblesAsistentes'
]);
Route::get('evento/regAsist/{id}', [    //ruta para listar los empleados  para agregar asistentes a un evento seleccionado, recibe el id del evento seleccionado
    'as' => 'talento.humano.evento.regAsist', //Este es el alias de la ruta
    'uses' => function($id){
        return view('humtalent.eventos.registrarAsistentes',compact('id'));
    }
]);
Route::get('evento/regAsist/saveAsist/{id?}/{ced?}',[   //ruta que registrar los empleados asistentes a un evento, recibe el id del evento seleccionado y la cedula del empleado a registrar como asistente
    'as' => 'talento.humano.evento.regAsist.saveAsists',
    'uses' => $controller.'EventoController@registrarAsistentes'
]);
Route::post('evento/regAsist/regTotAsist/{id?}/{datos?}',[   //ruta que registrar los empleados asistentes a un evento, recibe el id del evento seleccionado y la cedula del empleado a registrar como asistente
    'as' => 'talento.humano.evento.regAsist.regTotAsist',
    'uses' => $controller.'EventoController@registrarTodosAsistentes'
]);
Route::get('evento/asistentes/deleteAsist/{id?}/{ced?}',[   //ruta que eliminar un asistente a un evento, recibe la cedula  del empleado seleccionado y el id del evento
    'as' => 'talento.humano.evento.asistentes.deleteAsist',
    'uses' => $controller.'EventoController@deleteAsistentes'
]);

/*Route::get('docentesList/{rol}', function ($rol)    {
    return view('humtalent.empleado.tablasEmpleados', compact('rol'));
})->name('talento.humano.docentesList');
*/


Route::group(['prefix' => 'induccion'], function () {
    $controller = "\\App\\Container\\Humtalent\\Src\\Controllers\\";

    Route::get('tablaInduccion', [    //ruta para mostrar una lista de los empleados nuevos
        'as' => 'talento.humano.Tinduccion', //Este es el alias de la ruta
        'uses' => function(){
            return view('humtalent.inducciones.tablaEmpleadosNuevos');
        }
    ]);

    Route::get('tablaEmpleadosNuevos',[   //ruta para realizar la cosnulta de los empleados nuevos
        'as' => 'talento.humano.tablaEmpleadosNuevos',
        'uses' => $controller.'InduccionController@listarEmpleadosNuevos'
    ]);

    Route::get('procesoInduccion/{id}', [    //ruta que muestra el proceso de inducción o re-inducción para un empleado nuevo.
        'as' => 'talento.humano.procesoInduccion', //Este es el alias de la ruta
        'uses' => $controller . 'InduccionController@index'
    ]);

    Route::post('induccion/store', [   //ruta para registrar el proceso de inducción para un empleado
        'as' => 'talento.humano.induccion.store',
        'uses' => $controller . 'InduccionController@store'
    ]);
});
Route::delete('evento/destroy/{id?}',[
    'uses' => $controller.'EventoController@destroy',
    'as' => 'talento.humano.evento.destroy'
]);
Route::get('evento/edit/{id?}',[
    'uses' => $controller.'EventoController@edit',
    'as' => 'talento.humano.evento.edit'
]);
Route::delete('document/destroy/{id?}',[
    'uses' => $controller.'DocumentController@destroy',
    'as' => 'talento.humano.document.destroy'
]);
Route::get('document/edit/{id?}',[
    'uses' => $controller.'DocumentController@edit',
    'as' => 'talento.humano.document.edit'
]);


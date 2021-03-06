<?php

namespace App\Container\Administrative\Src\Controllers;


use Yajra\DataTables\DataTables;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Container\Overall\Src\Facades\AjaxResponse;
use App\Container\Users\src\Interfaces\UsersUdecInterface;
use App\Container\Administrative\Src\Interfaces\RegistroIngresoInterface;
use App\Container\Users\src\UsersUdec;

class RegistroController extends Controller
{
    protected $usersudecRepository;
    protected $registroIngresoRepository;

    public function __construct(UsersUdecInterface $usersudecRepository,RegistroIngresoInterface $registroIngresoRepository)
    {
        $this->usersudecRepository = $usersudecRepository;
        $this->registroIngresoRepository = $registroIngresoRepository;
    }

    public function checkDocument(Request $request)
    {
        if ($request->ajax() && $request->isMethod('POST')) {

            $validator = Validator::make($request->all(), [
                'number_document' => 'unique:developer.users_udec'
            ]);

            if (empty($validator->errors()->all())) {
                return response('true');
            }

            return response('false');

        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );
    }

    public function store(Request $request)
    {
        if ($request->ajax() && $request->isMethod('POST')) {

            /*Guarda Usuario*/
            $user = $this->usersudecRepository->store($request->all());

            return AjaxResponse::success(
                '¡Bien hecho!',
                'Datos guardados correctamente.'
            );
        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {

            $user = UsersUdec::query();

            return DataTables::of($user)
                ->removeColumn('company')
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('deleted_at')
                ->addIndexColumn()
                ->make(true);
        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );
    }

    public function entry(Request $request)
    {
        if ($request->ajax() && $request->isMethod('POST')) {
            $validator = Validator::make($request->all(), [
                'number_document' => 'unique:developer.users_udec'
            ]);

            if (empty($validator->errors()->all())) {
                return AjaxResponse::success(
                    'false',
                    'false'
                );
            } else {
                $this->registroIngresoRepository->store([ 'id_proceso' => $request['process'], 'id_registro' => $request['number_document']
                ]);
                /*$user = Registro::find($request['number_document']);
                $user->registroIngreso()->create([ 'id_proceso' => $request['id_proceso']]);*/
                return AjaxResponse::success(
                    '¡Bien hecho!',
                    'Registro de ingreso correcto.'
                );
            }
        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );
    }

    public function history_data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {

            $history = $this->registroIngresoRepository->index(['registro','proceso']);

            return DataTables::of($history)
                ->removeColumn('registro.number_document')
                ->removeColumn('registro.company')
                ->removeColumn('registro.created_at')
                ->removeColumn('registro.updated_at')
                ->removeColumn('registro.number_phone')
                ->removeColumn('registro.email')
                ->removeColumn('proceso.id')
                ->removeColumn('proceso.updated_at')
                ->removeColumn('proceso.created_at')
                ->removeColumn('proceso.id_macro')
                ->removeColumn('registro.updated_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);
        }

        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );
    }

}
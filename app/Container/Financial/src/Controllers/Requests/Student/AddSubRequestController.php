<?php

namespace App\Container\Financial\src\Controllers\Requests\Student;

use App\Container\Financial\src\Repository\AddSubRepository;
use App\Container\Financial\src\Requests\Requests\Student\AddSubStudentRequest;
use App\Container\Overall\Src\Facades\AjaxResponse;
use App\Http\Controllers\Controller;

class AddSubRequestController extends Controller
{
    /**
     * @var AddSubRepository
     */
    private $addSubRepository;


    /**
     * AddSubRequestController constructor.
     * @param AddSubRepository $addSubRepository
     */
    public function __construct(AddSubRepository $addSubRepository)
    {
        $this->middleware( 'request.status:'.status_type_addition_subtraction(), ['only' => ['edit'] ] );
        $this->middleware( 'check.available:'.status_type_addition_subtraction(), ['only' => ['store', 'update', 'destroy'] ] );
        $this->middleware( 'check.cost:'.status_type_addition_subtraction(), ['only' => ['store'] ] );
        $this->middleware( 'check.latest.request:'.status_type_addition_subtraction(), ['only' => ['store'] ] );
        $this->addSubRepository = $addSubRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->isMethod('GET') )
            return view('financial.requests.student.addsub.index');

        return abort( 405 );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( request()->isMethod('GET') )
            return view('financial.requests.student.addsub.create');

        return abort( 405 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddSubStudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddSubStudentRequest $request)
    {
        if ( request()->isMethod('POST') )
            return ( $this->addSubRepository->storeStudentAddSub( $request ) ) ?
                jsonResponse() :
                jsonResponse('error', 'processed_fail', 422);

        return AjaxResponse::make(__('javascript.http_status.error', ['status' => 405]), __('javascript.http_status.method', ['method' => 'POST']), '', 405);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( request()->isMethod('GET') )
            return view('financial.requests.student.addsub.show', compact('id'));

        return abort( 405 );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        if ( request()->isMethod('GET') )
            return view('financial.requests.student.addsub.edit', compact('id'));

        return abort( 405 );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddSubStudentRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddSubStudentRequest $request, $id )
    {
        if ( request()->isMethod('PUT') || request()->isMethod('PATCH') )
            return ( $this->addSubRepository->updateStudentAddSub( $request, $id ) ) ?
                jsonResponse('success', 'updated_done', 200) :
                jsonResponse('error', 'updated_fail', 422);

        return AjaxResponse::make(__('javascript.http_status.error', ['status' => 405]), __('javascript.http_status.method', ['method' => 'PUT / PATCH']), '', 405);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( request()->isMethod('DELETE') )
            return ( $this->addSubRepository->deleteStudentAddSub( $id ) ) ?
                jsonResponse('success', 'deleted_done', 200) :
                jsonResponse('error', 'deleted_fail', 422);

        return AjaxResponse::make(__('javascript.http_status.error', ['status' => 405]), __('javascript.http_status.method', ['method' => 'DELETE']), '', 405);

    }
}
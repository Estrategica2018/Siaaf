<?php

namespace App\Container\Financial\src\Controllers\Management;


use App\Container\Financial\src\Repository\FileTypeRepository;
use App\Container\Financial\src\Requests\FileType\StoreFileTypeRequest;
use App\Container\Overall\Src\Facades\AjaxResponse;
use App\Http\Controllers\Controller;

class ManageFileTypesController extends Controller
{
    /**
     * @var FileTypeRepository
     */
    private $fileTypeRepository;

    /**
     * ManageFileTypesController constructor.
     * @param FileTypeRepository $fileTypeRepository
     */
    public function __construct(FileTypeRepository $fileTypeRepository)
    {
        $this->fileTypeRepository = $fileTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->isMethod('GET') )
            return view('financial.management.file-type.index');

        return abort( 405 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFileTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileTypeRequest $request)
    {
        if ( request()->isMethod('POST') )
            return ( $this->fileTypeRepository->store( $request ) ) ?
                jsonResponse() :
                jsonResponse('error', 'processed_fail', 422);

        return AjaxResponse::make(__('javascript.http_status.error', ['status' => 405]), __('javascript.http_status.method', ['method' => 'POST']), '', 405);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreFileTypeRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFileTypeRequest $request, $id)
    {
        if ( request()->isMethod('PUT') || request()->isMethod('PATCH') )
            return ( $this->fileTypeRepository->update($request, $id ) ) ?
                jsonResponse('success', 'updated_done', 200) :
                jsonResponse('error', 'updated_fail', 422);

        return AjaxResponse::make(__('javascript.http_status.error', ['status' => 405]), __('javascript.http_status.method', ['method' => 'PUT / PATCH']), '', 405);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( request()->isMethod('DELETE') )
            return ( $this->fileTypeRepository->destroy( $id ) ) ?
                jsonResponse('success', 'deleted_done', 200) :
                jsonResponse('error', 'deleted_fail', 422);

        return AjaxResponse::make(__('javascript.http_status.error', ['status' => 405]), __('javascript.http_status.method', ['method' => 'DELETE']), '', 405);
    }
}
<?php

namespace App\Container\Financial\src\Controllers\Api;


use App\Container\Financial\src\Repository\StatusRequestRepository;
use App\Container\Overall\Src\Facades\AjaxResponse;
use App\Http\Controllers\Controller;

class StatusRequestController extends Controller
{
    /**
     * @var StatusRequestRepository
     */
    private $statusRequestRepository;

    /**
     * StatusRequestController constructor.
     * @param StatusRequestRepository $statusRequestRepository
     */
    public function __construct(StatusRequestRepository $statusRequestRepository)
    {
        $this->statusRequestRepository = $statusRequestRepository;
    }

    /**
     * Return a list of status in tree format
     *
     * @param $type
     * @return \Illuminate\Http\Response
     */
    public function tree($type)
    {
        if ( request()->isMethod('GET') ) {
            $status = $this->statusRequestRepository->tree($type);
            $array = [
                'id' => $type,
                'text' => ucfirst(trans("validation.attributes.$type")),
                'icon' => 'fa fa-tachometer',
                'state' => [
                    'opened' => true,
                    'disabled' => true,
                    'selected' => true,
                ]
            ];
            foreach ($status->cursor() as $value) {
                $children[] = [
                    'id' => isset($value->{primaryKey()}) ? $value->{primaryKey()} : null,
                    'text' => isset($value->{status_name()}) ? $value->{status_name()} : trans('financial.generic.empty'),
                    'icon' => 'fa fa-cogs'
                ];
            }

            $array = isset($children) ? array_add($array, 'children', $children) : $array;

            return response()->json($array, 200);
        }
        return AjaxResponse::make(__('javascript.http_status.error', ['status' => 405]), __('javascript.http_status.method', ['method' => 'GET']), '', 405);
    }
}
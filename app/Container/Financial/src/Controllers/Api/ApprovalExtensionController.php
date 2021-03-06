<?php

namespace App\Container\Financial\src\Controllers\Api;

use App\Container\Financial\src\Repository\ExtensionRepository;
use App\Container\Overall\Src\Facades\AjaxResponse;
use App\Http\Controllers\Controller;

class ApprovalExtensionController extends Controller
{
    /**
     * @var ExtensionRepository
     */
    private $extensionRepository;

    /**
     * ApprovalExtensionController constructor.
     * @param ExtensionRepository $extensionRepository
     */
    public function __construct(ExtensionRepository $extensionRepository)
    {
        $this->extensionRepository = $extensionRepository;
    }

    /**
     * Return a sidebar withs counts and status
     *
     * @return \Illuminate\Http\Response
     */
    public function sidebar()
    {
        if ( request()->isMethod('GET') ) {
            $status = $this->extensionRepository->availableStatus();
            $sidebar[] = [
                'id' => null,
                'count' => $this->extensionRepository->getModel()->count(),
                'text' => toUpper(__('validation.attributes.all')),
                'class' => randomClassesBadge()
            ];
            foreach ($status as $status) {
                $sidebar[] = [
                    'id' => $status->{primaryKey()},
                    'count' => $this->extensionRepository->count([$status->{primaryKey()}]),
                    'text' => $status->{status_name()},
                    'class' => randomClassesBadge()
                ];
            }
            return response()->json(isset($sidebar) ? $sidebar : [], 200);
        }
        return AjaxResponse::make(__('javascript.http_status.error', ['status' => 405]), __('javascript.http_status.method', ['method' => 'GET']), '', 405);
    }

    /**
     * Get all extensions with paginate and status
     *
     * @param null $status
     * @return \Illuminate\Http\Response
     */
    public function extensions( $status = null )
    {
        if ( request()->isMethod('GET') )
            return response()->json(
                $this->extensionRepository->getAllPaginate( 10, $status ),
                200 );

        return AjaxResponse::make(__('javascript.http_status.error', ['status' => 405]), __('javascript.http_status.method', ['method' => 'GET']), '', 405);
    }
}
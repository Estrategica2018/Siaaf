<?php

namespace App\Container\Financial\src\Repository;

use App\Container\Financial\src\Interfaces\FinancialValidationInterface;
use App\Container\Financial\src\Interfaces\Methods;
use App\Container\Financial\src\SubjectProgram;
use App\Container\Financial\src\Validation;
use App\Transformers\Financial\ValidationTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class ValidationRepository extends Methods implements FinancialValidationInterface
{
    /**
     * @var StatusRequestRepository
     */
    private $statusRequestRepository;
    /**
     * @var CostServiceRepository
     */
    private $costServiceRepository;

    /**
     * ExtensionRepository constructor.
     * @param StatusRequestRepository $statusRequestRepository
     * @param CostServiceRepository $costServiceRepository
     */
    public function __construct(StatusRequestRepository $statusRequestRepository, CostServiceRepository $costServiceRepository)
    {
        parent::__construct( Validation::class );
        $this->statusRequestRepository = $statusRequestRepository;
        $this->costServiceRepository = $costServiceRepository;
    }

    /**
     * Store a new data
     *
     * @param $model
     * @param $request
     * @return mixed
     */
    public function process( $model, $request )
    {
        $status = $this->statusRequestRepository->getId( status_type_validation(), sent_status() );
        $cost_service = $this->costServiceRepository->getId( status_type_validation() );
        if ( isset( $status->{ primaryKey() } ) && isset( $cost_service->{ primaryKey() } ) ) {
            $model->{action_subject()} = $request->action;
            $model->{subject_fk()} = $request->subject_matter;
            $model->{student_fk()} = auth()->user()->id;
            $model->{status_fk()} = $status->{primaryKey()};
            $model->{cost_service_fk()} = $cost_service->{primaryKey()};
            return $model->save();
        }
        return false;
    }

    public function updateAdminValidation( $request, $id )
    {
        $approved = $this->statusRequestRepository->getId( status_type_validation(), approved_status() );
        $model = $this->getModel()->find( $id );

        if ( isset( $approved->{ primaryKey() }, $model ) ) {
            if ($request->status == $approved->{primaryKey()}) {
                if (!isset($model->{approval_date()})) {
                    $model->{approval_date()} = now();
                    $model->{approved_by()} = auth()->user()->id;
                }
                $model->{realization_date()} = $request->date;
            }
            $model->{status_fk()} = $request->status;
            return $model->save();
        }

        return false;
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function canUpdateStatus($request, $id)
    {
        $approved = $this->statusRequestRepository->getId( status_type_validation(), approved_status() );
        $paid = $this->statusRequestRepository->getId( status_type_validation(), paid_status() );
        $waiting_pay = $this->statusRequestRepository->getId( status_type_validation(), waiting_pay_status() );
        $canceled = $this->statusRequestRepository->getId( status_type_validation(), canceled() );
        $model = $this->getModel()->find( $id );

        if ( isset( $model->{ status_fk() }, $approved->{ primaryKey() }, $paid->{ primaryKey() }, $waiting_pay->{ primaryKey() }, $canceled->{ primaryKey() } ) ) {
            $status = $this->statusRequestRepository->getModel()->select(status_name())->find($request->status);
            if ( $model->{ status_fk() } == $approved->{ primaryKey() } ) {
                if (isset($status->{status_name()}) && !approvedStatusIsEditable($status->{status_name()})) {
                    return false;
                }
            }
            if ( $model->{ status_fk() } == $paid->{ primaryKey() }) {
                return false;
            }
            if ( $model->{ status_fk() } == $canceled->{ primaryKey() }) {
                return false;
            }
            if ( $model->{ status_fk() } == $waiting_pay->{ primaryKey() } ) {
                if (isset($status->{status_name()}) && !waitingPaidStatusIsEditable($status->{status_name()})) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get count data
     *
     * @param array $status
     * @return mixed
     */
    public function count( $status = [] )
    {
        $model = $this->getModel();
        $model = ( $status ) ? $model->whereIn( status_fk(),  $status ) : $model;
        return $model->count();
    }

    /**
     * Get available status
     *
     * @return mixed
     */
    public function availableStatus()
    {
        return $this->statusRequestRepository->getNames( status_type_validation() );
    }

    /**
     * Store a new student with initial status and cost
     *
     * @param $request
     * @return mixed
     */
    public function storeStudentValidation( $request )
    {
        $status = $this->statusRequestRepository->getId( status_type_validation(), sent_status() );
        $cost_service = $this->costServiceRepository->getId( status_type_validation() );
        if ( isset( $status->{ primaryKey() } ) && isset( $cost_service->{ primaryKey() } ) ) {
            $model = $this->getModel();
            $model->{subject_fk()} = $request->subject_matter;
            $model->{student_fk()} = auth()->user()->id;
            $model->{cost_service_fk()} = $cost_service->{primaryKey()};
            $model->{status_fk()} = $status->{primaryKey()};
            return $model->save();
        }
        return false;
    }

    /**
     * Update status request
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public function updateStudentValidation( $request, $id )
    {
        $model = auth()->user()->validations()->find( $id );
        $model->{ subject_fk() }   =  $request->subject_matter;
        return $model->save();
    }

    /**
     * Delete status request
     *
     * @param $id
     * @return bool
     */
    public function deleteStudentValidation( $id )
    {
        $model = $this->getAuth(['status'], $id);
        return ( $model && $model->status->{ status_name() } == 'PENDIENTE' || $model->status->{ status_name() } == 'ENVIADO' ) ? $model->forceDelete() : false;
    }

    /**
     * Get subject relations stored
     *
     * @param $id
     * @param bool $whitRelations
     * @return mixed
     */
    public function subjectRelation($id, $whitRelations = false )
    {
        $model = $this->getAuth( [], $id );
        $model = SubjectProgram::where( subject_fk() , isset( $model->{ subject_fk() }) ? $model->{ subject_fk() } : 0);
        $model = $whitRelations ? $model->with(['programs', 'subjects', 'teachers:id,name,lastname,phone,email']) : $model;
        return $model->first();
    }

    /**
     * Get data paginate
     *
     * @param int $quantity
     * @param null $status
     * @return Collection
     */
    public function getAllPaginate($quantity = 5, $status = null )
    {
        $items = $this->getModel()->with([
            'subject' => function ($q) {
                return $q->with([
                    'programs',
                    'teachers:id,name,lastname,phone,email'
                ]);
            },
            'status',
            'secretary:id,name,lastname,phone,email',
            'student:id,name,lastname,phone,email',
        ])->withCount('comments')->latest();

        if ( $status ) {
            $items = $items->whereHas('status', function ($query) use ($status) {
                $query->where( primaryKey(), $status );
            });
        }

        $items = $items->paginate( $quantity );


        $resource = $items->getCollection()
            ->map(function($model) {
                return $this->formatData( $model );
            })->toArray();

        return customPagination( $resource,  $items);
    }

    /**
     * Retrieve the auth user extension
     *
     * @param array $relations
     * @param $id
     * @return mixed
     */
    public function getAuth(array $relations = [], $id)
    {
        $model = auth()->user()->validations();
        return ( count( $relations ) ) ? $model->with( $relations )->findOrFail( $id ) : $model->findOrFail( $id ) ;
    }

    /**
     * Get data transformed
     *
     * @param $model
     * @return array
     */
    public function formatData( $model )
    {
        return ( new ValidationTransformer )->transform( $model );
    }
}
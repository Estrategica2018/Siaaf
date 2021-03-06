<?php

namespace App\Container\Financial\src\Repository;

use App\Container\Financial\src\Extension;
use App\Container\Financial\src\Interfaces\Methods;
use App\Container\Financial\src\Interfaces\FinancialExtensionInterface;
use App\Container\Financial\src\SubjectProgram;
use App\Container\Overall\Src\Facades\AjaxResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class ExtensionRepository extends Methods implements FinancialExtensionInterface
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
        parent::__construct( Extension::class );
        $this->statusRequestRepository = $statusRequestRepository;
        $this->costServiceRepository = $costServiceRepository;
    }

    /**
     * Store data in database
     *
     * @param $model
     * @param $request
     * @return mixed
     */
    public function process($model, $request )
    {
        $model->{ approval_date() }         =  $request->approval_date;
        $model->{ realization_date() }      =  $request->realization_date;
        $model->{ subject_fk() }            =  $request->subject_matter;
        $model->{ student_fk() }            =  auth()->user()->id;
        $model->{ status_fk() }             =  2;
        $model->{ cost_service_fk() }       =  1;
        return $model->save();
    }

    /**
     * Update status of the specific resource
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public function updateAdminExtension($request, $id )
    {
        $approved = $this->statusRequestRepository->getId( status_type_extension(), approved_status() );
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
        $approved = $this->statusRequestRepository->getId( status_type_extension(), approved_status() );
        $paid = $this->statusRequestRepository->getId( status_type_extension(), paid_status() );
        $waiting_pay = $this->statusRequestRepository->getId( status_type_extension(), waiting_pay_status() );
        $canceled = $this->statusRequestRepository->getId( status_type_extension(), canceled() );
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
     * Get a count data
     *
     * @param array $status
     * @return mixed
     */
    public function count( $status = [] )
    {
        return $this->getModel()->whereIn( status_fk(),  $status )->count();
    }

    /**
     * Get available status
     *
     * @return mixed
     */
    public function availableStatus()
    {
        return $this->statusRequestRepository->getNames( status_type_extension() );
    }

    /**
     * Store a new student with initials status and cost
     *
     * @param $request
     * @return mixed
     */
    public function storeStudentExtension( $request )
    {
        $status = $this->statusRequestRepository->getId( status_type_extension(), sent_status() );
        $cost_service = $this->costServiceRepository->getId( status_type_extension() );
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
     * Update student request
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public function updateStudentExtension( $request, $id )
    {
        $model = auth()->user()->extensions()->find( $id );
        $model->{ subject_fk() }   =  $request->subject_matter;
        return $model->save();
    }

    /**
     * Delete a student request
     *
     * @param $id
     * @return bool
     */
    public function deleteStudentExtension( $id )
    {
        $extension = $this->getAuth(['status'], $id);
        return ( $extension && $extension->status->{ status_name() } == pending_status() || $extension->status->{ status_name() } == sent_status() ) ? $extension->forceDelete() : false;
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
        $extension = $this->getAuth( [], $id );
        $extension = SubjectProgram::where( subject_fk() , isset($extension->{ subject_fk() }) ? $extension->{ subject_fk() } : 0 );
        $extension = $whitRelations ? $extension->with(['programs', 'subjects', 'teachers:id,name,lastname,phone,email']) : $extension;
        return $extension->first();
    }

    /**
     * Get data paginate
     *
     * @param int $quantity
     * @param null $status
     * @return LengthAwarePaginator
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

        $data = $items->getCollection()
            ->map(function($model) {
                return $this->fillPagination( $model );
            })->toArray();

        return customPagination( $data,  $items);
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
        $extension = auth()->user()->extensions();
        return ( count( $relations ) ) ? $extension->with( $relations )->findOrFail( $id ) : $extension->findOrFail( $id ) ;
    }

    public function fillArray( $extension )
    {
        return [
            'id'                => isset( $extension->{ primaryKey() } )                            ? $extension->{ primaryKey() } : 0,
            'subject_code'      => isset( $extension->subject->{ subject_code() } )                 ? $extension->subject->{ subject_code() } : 0,
            'subject_name'      => isset( $extension->subject->{ subject_name() } )                 ? $extension->subject->{ subject_name() } : __('financial.generic.empty'),
            'subject_credits'   => isset( $extension->subject->{ subject_credits() } )              ? $extension->subject->{ subject_credits() } : 0,
            'subject_program'   => isset( $extension->subject->programs[0]->{ program_name() } )    ? $extension->subject->programs[0]->{ program_name() } : __('financial.generic.empty'),
            'total_cost'        => isset( $extension->total_cost )                                  ? toMoney( $extension->total_cost ) : toMoney( 0 ),
            'status'            => isset( $extension->status->{ status_name() } )                   ? $extension->status->{ status_name() } : __('financial.generic.empty'),
            'unit_cost'         => isset( $extension->cost->{ cost() } )                            ? $extension->cost->cost_to_money : toMoney( 0 ),
            'teacher'           => isset( $extension->subject->teachers[0]->full_name )             ? $extension->subject->teachers[0]->full_name : __('financial.generic.empty'),
            'phone'             => isset( $extension->subject->teachers[0]->phone )                 ? $extension->subject->teachers[0]->phone : __('financial.generic.empty'),
            'email'             => isset( $extension->subject->teachers[0]->email )                 ? $extension->subject->teachers[0]->email : __('financial.generic.empty'),
            'approve_date'      => isset( $extension->{ approval_date() } )                         ? $extension->{ approval_date() }->format('Y-m-d H:i:s ') : null,
            'approve_by'        => isset( $extension->secretary->full_name )                        ? $extension->secretary->full_name : __('financial.generic.empty'),
            'extension_date'    => isset( $extension->{ realization_date() } )                      ? $extension->{ realization_date() }->format('Y-m-d H:i:s ') : null,
            'student'           => isset( $extension->student->full_name )                          ? $extension->student->full_name : __('financial.generic.empty'),
            'student_phone'     => isset( $extension->student->phone )                              ? $extension->student->phone : __('financial.generic.empty'),
            'student_email'     => isset( $extension->student->email )                              ? $extension->student->email : __('financial.generic.empty'),
            'created_at'        => isset( $extension->{ created_at() } )                            ? $extension->{ created_at() }->format('Y-m-d H:i:s ') : null,
        ];
    }

    /**
     * Retrieve formatted data
     *
     * @param $model
     * @return array
     */
    public function fillPagination($model )
    {
        return [
            'id'                =>  isset( $model->{ primaryKey() } ) ? $model->{ primaryKey() } : 0,
            'approval_date'     =>  isset( $model->{ approval_date() } ) ? $model->{ approval_date() }->format('Y-m-d H:i:s ') : null,
            'realization_date'  =>  isset( $model->{ realization_date() } ) ? $model->{ realization_date() }->format('Y-m-d H:i:s ') : null,
            'created_at'        =>  isset( $model->{ created_at() } ) ? $model->{ created_at() }->format('Y-m-d H:i:s ') : null,
            'subject_code'      =>  isset( $model->subject->{ subject_code() } ) ? $model->subject->{ subject_code() } : 0,
            'subject_name'      =>  isset( $model->subject->{ subject_name() } ) ? $model->subject->{ subject_name() } : __('financial.generic.empty'),
            'subject_credits'   =>  isset( $model->subject->{ subject_credits() } ) ? $model->subject->{ subject_credits() } : 0,
            'program_name'      =>  isset( $model->subject->programs[0]->{ program_name() } ) ? $model->subject->programs[0]->{ program_name() } : __('financial.generic.empty'),
            'status_name'       =>  isset( $model->status->{ status_name() } ) ? $model->status->{ status_name() } : __('financial.generic.empty'),
            'teacher_name'      =>  isset( $model->subject->teachers[0]->full_name ) ? $model->subject->teachers[0]->full_name : __('financial.generic.empty'),
            'teacher_picture'   =>  isset( $model->subject->teachers[0]->profile_picture ) ? $model->subject->teachers[0]->profile_picture : iconHash(),
            'teacher_phone'     =>  isset( $model->subject->teachers[0]->phone ) ? $model->subject->teachers[0]->phone : __('financial.generic.empty'),
            'teacher_email'     =>  isset( $model->subject->teachers[0]->email ) ? $model->subject->teachers[0]->email : __('financial.generic.empty'),
            'secretary_name'    =>  isset( $model->secretary->full_name ) ? $model->secretary->full_name : __('financial.generic.empty'),
            'secretary_picture' =>  isset( $model->secretary->profile_picture ) ? $model->secretary->profile_picture : iconHash(),
            'secretary_phone'   =>  isset( $model->secretary->phone ) ? $model->secretary->phone : __('financial.generic.empty'),
            'secretary_email'   =>  isset( $model->secretary->email ) ? $model->secretary->email : __('financial.generic.empty'),
            'student_name'      =>  isset( $model->student->full_name ) ? $model->student->full_name : __('financial.generic.empty'),
            'student_picture'   =>  isset( $model->student->profile_picture ) ? $model->student->profile_picture : iconHash(),
            'student_phone'     =>  isset( $model->student->phone ) ? $model->student->phone : __('financial.generic.empty'),
            'student_email'     =>  isset( $model->student->email ) ? $model->student->email : __('financial.generic.empty'),
            'cost'              =>  isset( $model->cost->cost_to_money ) ? $model->cost->cost_to_money : toMoney( 0 ),
            'total_cost'        =>  isset( $model->total_cost ) ? toMoney( $model->total_cost ) : toMoney( 0 ),
            'comments_count'    =>  isset( $model->comments_count ) ? $model->comments_count : 0
        ];
    }
}
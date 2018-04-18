<?php

namespace App\Container\Financial\src\Repository;


use App\Container\Financial\src\Interfaces\FinancialSubjectProgramTeacherInterface;
use App\Container\Financial\src\Interfaces\Methods;
use App\Container\Financial\src\SubjectProgram;
use Illuminate\Http\Request;

class SubjectProgramTeacherRepository extends Methods implements FinancialSubjectProgramTeacherInterface
{
    /**
     * SubjectProgramTeacherRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(SubjectProgram::class);
    }

    /**
     * @return mixed
     */
    public function assignedSubjectsIds()
    {
        return $this->getModel()->select( subject_fk() )->pluck( subject_fk() )->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function teachersIdsWhereHasSubject( $id )
    {
        return $this->getModel()->where( subject_fk(), $id )
            ->get()->pluck( teacher_fk() )->toArray();
    }

    /**
     * @return mixed
     */
    public function assigned()
    {
        return $this->getModel()->with('teachers:id,name,lastname', 'programs', 'subjects');
    }

    /**
     * @param Request $request
     * @return bool|mixed
     */
    public function updateSubjectProgramTeacher(Request $request)
    {
        return $this->getModel()->where([
                    [ subject_fk(), $request->old_subject ],
                    [ teacher_fk(), $request->old_teacher ],
                    [ program_fk(), $request->old_program ],
                ])->update([
                    subject_fk() => $request->subject,
                    teacher_fk() => $request->teacher,
                    program_fk() => $request->program,
                ]);
    }

    /**
     * @param Request $request
     * @return bool|mixed
     */
    public function destroySubjectProgramTeacher(Request $request)
    {
        return $this->getModel()->where([
                    [ subject_fk(), $request->subject ],
                    [ teacher_fk(), $request->teacher ],
                    [ program_fk(), $request->program ],
                ])->delete();
    }

    /**
     * @param $model
     * @param $request
     * @return mixed
     */
    public function process($model, $request)
    {
        $model->{ subject_fk() }    =   $request->subject;
        $model->{ program_fk() }    =   $request->program;
        $model->{ teacher_fk() }    =   $request->teacher;
        return $model->save();
    }
}
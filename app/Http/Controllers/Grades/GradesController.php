<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::all();
        return view('pages.grades.grades', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradeRequest $request)
    {
        if(Grade::where('Name->ar', $request->Name)->orWhere('Name->en', $request->Name_en)->exists()){
            toastr()->error(trans('messages.name_exists'));
            return redirect()->back();
        }
        try {
            $validated = $request->validated();

            $grade = new Grade();
            $grade->Name = [
                'en' => $request->Name_en,
                'ar' => $request->Name
            ];
            $grade->Notes = $request->Notes;
            $grade->save();

            toastr()->success(trans('messages.success'));
            return redirect()->route('grades.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGradeRequest $request)
    {
        try {
            $validated = $request->validated();
            $grade = Grade::findOrFail($request->id);
            $grade->update([
                $grade->Name = ['ar' => $request->Name, 'en' => $request->Name_en],
                $grade->Notes = $request->Notes,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('grades.index');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $class_id = Classroom::where('Grade_id',$request->id)->pluck('Grade_id');
        if($class_id->count() == 0){
            $grade = Grade::FindOrFail($request->id);
            $grade->delete();
            toastr()->success(trans('messages.Delete'));
            return redirect()->route('grades.index');
        } else{
            toastError(trans('grade_trans.delete_Grade_Error'));
            return redirect()->route('grades.index');

        }
    }
}

<?php

namespace App\Http\Controllers\Classroom;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassesRequest;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Classroom::all();
        $grades = Grade::all();
        return view('pages.classrooms.classrooms', compact(['classrooms', 'grades']));
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
     * @param StoreClassesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreClassesRequest $request)
    {
        $list_classes = $request->List_Classes;
        try {
            $validated = $request->validated();
            foreach ($list_classes as $class) {
                $new_class = new Classroom();
                $new_class->Name = ['en' => $class['Name_class_en'], 'ar' => $class['Name']];
                $new_class->Grade_id = $class['Grade_id'];
                $new_class->save();
            }
            toastSuccess(trans('messages.success'));
            return redirect()->route('classrooms.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
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
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $classroom = Classroom::findOrFail($request->id);
            $classroom->update([
                $classroom->Name = ['en' => $request->Name_en, 'ar' => $request->Name],
                $classroom->Grade_id = $request->Grade_id,
            ]);
            toastSuccess(trans('messages.Update'));
            return redirect()->route('classrooms.index');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $classroom = Classroom::findOrFail($request->id);
            $classroom->delete();
            toastSuccess(trans('messages.Delete'));
            return redirect()->route('classrooms.index');
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove multiple row from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAll(Request $request)
    {
        $id = explode(",", $request->all_id);
        Classroom::whereIn('id', $id)->Delete();
        toastr()->success(trans('messages.Delete'));
        return redirect()->route('classrooms.index');
    }

    public function filterByGrade(Request $request)
    {
        $grades = Grade::all();
        $Search = Classroom::select('*')->where('Grade_id','=',$request->Grade_id)->get();
        return view('pages.classrooms.classrooms',compact('grades'))->withDetails($Search);

    }
}

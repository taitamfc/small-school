<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Course::select('id','name','price','status');
        $items = $query->paginate(20);
        $params = [
            'items'        => $items,
        ];
        return view('admin.courses.index',$params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item = new Course();
        $params = [
            'item'        => $item,
        ];
        return view('admin.courses.create',$params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $this->authorize('update', Course::class);
        $data = $request->except(['_token','_method']);
        try {
            Course::create($data);
            return redirect()->route('courses.index')->with('success', 'Thêm thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Lưu không thành công!.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $params = [
            'item'        => $course,
        ];
        return view('admin.courses.edit',$params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', Course::class);
        $data = $request->except(['_token','_method']);
        try {
            $course->update($data);
            return redirect()->route('courses.index')->with('success', 'Lưu thành công.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Lưu không thành công!.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', Course::class);
        try {
            $course->delete();
            return back()->with('success', 'Xóa thành công!.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->with('error', 'Xóa không thành công!.');
        }
    }
}

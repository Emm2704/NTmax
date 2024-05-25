<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }
    
    public function create() {
        return view('courses.create');
    }
    
    public function store(Request $request) {
        $course = new Course($request->all());
        $course->save();
        return redirect()->route('courses.index');
    }
    
    public function edit($id) {
        $course = Course::find($id);
        return view('courses.edit', compact('course'));
    }
    
    public function update(Request $request, $id) {
        $course = Course::find($id);
        $course->update($request->all());
        return redirect()->route('courses.index');
    }
    
    public function destroy($id) {
        $course = Course::find($id);
        $course->delete();
        return redirect()->route('courses.index');
    }
    
    public function toggleStatus($id) {
        $course = Course::find($id);
        $course->is_active = !$course->is_active;
        $course->save();
        return redirect()->route('courses.index');
    }
}

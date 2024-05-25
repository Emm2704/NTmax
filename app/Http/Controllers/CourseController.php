<?php

// app/Http/Controllers/CourseController.php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'level' => 'required',
            'duration' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses');
        }

        Course::create($data);
        return redirect()->route('courses.index')->with('success', 'Curso creado exitosamente.');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'level' => 'required',
            'duration' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses');
        }

        $course->update($data);
        return redirect()->route('courses.index')->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Curso eliminado exitosamente.');
    }

    public function toggleStatus(Course $course)
    {
        $course->is_active = !$course->is_active;
        $course->save();
        return redirect()->route('courses.index')->with('success', 'Estado del curso actualizado.');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }
}

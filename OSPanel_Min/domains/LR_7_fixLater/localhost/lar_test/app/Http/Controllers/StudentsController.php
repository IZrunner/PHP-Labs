<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index() {
        $students = \App\Student::all()->sortBy("name");

        return view('students/index', [
            'students' => $students,
            'pageTitle' => 'Студенти груп 308, 309',
        ]);
    }

    public function create() {
        return view('students/create');
    }

    public function store() {
        $student = new \App\Student();

        $student->name = \request('stud-name');
        $student->group = \request('stud-group');

        $student->save();
        return redirect('/students');
    }

    public function edit($id) {
        $student = \App\Student::find($id);
        return view('students/edit', [
            'student' => $student,
        ]);
    }

    public function update($id) {
        $student = \App\Student::find($id);

        $student->name = \request('stud-name');
        $student->group = \request('stud-group');

        $student->save();
        return redirect('/students');
    }

    public function destroy($id) {
        $student = \App\Student::find($id);
        $student->delete();
    }

    public function getList() {
        return \App\Student::all();
    }
}
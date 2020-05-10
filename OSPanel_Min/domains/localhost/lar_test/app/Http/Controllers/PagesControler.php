<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\Util\Str;

class MyStudent {
    private $name;
    private $group;

    public function __construct(String $name, String $group)
    {
        $this->name = $name;
        $this->group = $group;
    }

    public function getName(): String {
        return $this->name;
    }

    public function getGroup(): String {
        return $this->group;
    }

    public static function getStudents() {
        return [
            new MyStudent('Абрамець Б. В.', '308'),
            new MyStudent('Ганькевич Д. Е.', '308'),
            new MyStudent('Єсиленко Ж. З.', '309'),
        ];
    }
}

class PagesControler extends Controller
{
    public function home() {
        return view("home");
    }

    public function about() {
        return view("about");
    }

    public function students() {
        return view("students", [
            'students' => MyStudent::getStudents(),
            'pageTitle' => 'Студенти груп 308, 309',
        ]);
    }
}

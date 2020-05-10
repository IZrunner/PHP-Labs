@extends("layout")

@section("app-title", "Список студентів")
@section("page-title", "Додати студента")

@section("page-content")
    <form method="post" action="/students" class="text-left">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="stud-name">Прізвище</label>
            <input type="text" class="form-control" name="stud-name" id="stud-name" placeholder="Ввведіть ім'я">
        </div>
        <div class="form-group">
            <label for="stud-group">Група</label>
            <input type="text" class="form-control" name="stud-group" id="stud-group" placeholder="Номер групи">
        </div>
        <button type="submit" class="btn btn-primary float-right">Додати</button>
    </form>
@endsection
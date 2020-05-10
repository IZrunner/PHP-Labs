@extends("layout")

@section("app-title")
    Список студентів
@endsection

@section("page-title")
    {{ $pageTitle }}
@endsection

@section("page-content")
            <a href="/students/create" class="btn btn-online-success float-left"
               style="margin-bottom: 10px;">Додати студента</a>
        <table class="table table-stripped table-dark">
                <thead>
                <tr>
                    <th scope="col">Група</th>
                    <th scope="col">Прізвище</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->group }}</td>
                        <td><a href="/students/{{ $student->id}}/edit"
                               class="btn btn-outline-primary">Редагування</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
@endsection

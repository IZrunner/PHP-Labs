@extends("layout")

@section("app-title")
    Список студентів
@endsection

@section("page-title")
    {{ $pageTitle }}
@endsection

@section("page-content")
    <table>
        <tr><th>Група</th><th>Прізвище</th></tr>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->getName() }}</td>
            <td>{{ $student->getGroup() }}</td>
        </tr>
        @endforeach
    </table>
@endsection

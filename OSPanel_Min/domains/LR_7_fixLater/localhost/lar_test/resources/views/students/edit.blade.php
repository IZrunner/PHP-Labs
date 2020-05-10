@extends("layout")

@section("app-title", "Список студентів")
@section("page-title", "Редагування студента")

@section("page-content")
    <form method="post" action="/students/{{ $student->id }}}"
        class="text-left">

        @csrf
        {{ method_field("patch") }}
        <div class="form-group">
            <label for="stud-name">Прізвище</label>
            <input type="text" class="form-control" name="stud-name"
                   id="stud-name" placeholder="Введіть ім'я"
                   value="{{ $student->name }}}">
        </div>
        <div class="form-group">
            <label for="stud-group">Група</label>
            <input type="text" class="form-control" name="stud-group"
                   id="stud-group" placeholder="Номер групи"
                   value="{{ $student->group }}">
        </div>
        <button type="submit" class="btn btn-primary float-right">
            Змінити
        </button>
        <button type="button" class="btn btn-danger" data-toggle="modal"
            data-target="#deleteModal">
            Видалити
        </button>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
        aria-tableledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">
                        <p>Підтвердіть видалення студента</p>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    Видалити студента {{ $student->name }}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-dismiss="modal">Hi</button>
                    <button type="button" class="btn btn-danger"
                        id="delete-student">Видалити</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#delete-student").click(function () {
                var id = {!! $student->id !!};
                $.ajax({
                    url: '/students/' + id,
                    type: 'post',
                    data: {
                        _method: 'delete',
                        _token: "{!! csrf_token() !!}"
                    },

                    success:function(msg) {
                        location.href="/students";
                    }
                });
            });
        });
    </script>
@endsection
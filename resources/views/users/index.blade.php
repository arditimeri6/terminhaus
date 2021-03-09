@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @if (session('resetLink'))
            <script>
                toastr.success('{{ session('resetLink') }}', {timeOut:5000})
            </script>
        @endif
        @if (session('UserIsConfirmed'))
            <script>
                toastr.info('{{ session('UserIsConfirmed') }}', {timeOut:5000})
            </script>
        @endif
        @if (session('UserIsUnconfirmed'))
            <script>
                toastr.info('{{ session('UserIsUnconfirmed') }}', {timeOut:5000})
            </script>
        @endif
        @if (session('successRegister'))
            <script>
                toastr.success('{{ session('successRegister') }}', {timeOut:5000})
            </script>
        @endif
        @if (session('updateSuccessfully'))
            <script>
                toastr.success('{{ session('updateSuccessfully') }}', {timeOut:5000})
            </script>
        @endif
    </div>
</div>




<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-danger">
            <div class="card-header bg-white border-danger">
                    @hasrole('Administrator|Call Center Admin|Berater Admin')
                    <a href="{{ route('indexPartners') }}" class="btn btn-outline-danger indexPartner-button ml-3 float-right">Partner</a>
                    @endhasrole
                    <a href="{{route('showUsers')}}" class="btn btn-outline-danger indexUsers-button float-right">Mitarbeiter</a>
                    <a href="{{ route('register') }}" title="register" class="createUsers-Button mr-2 float-left"><i class="fas fa-plus-circle fa-2x"></i></a>
                </div>
                <div class="card-body">
                    <table class="table table-hover border-0 bg-white" id="usersTable" style="width:100vw !important">
                        <thead>
                            <tr>
                                <th>Voller Name</th>
                                <th>Email</th>
                                <th>Arbeitsposition</th>
                                <th>Virtual User</th>
                                <th>Benutzertyp</th>
                                <th>Passwort zurücksetzen</th>
                                <th>Aktivieren</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Confirm User -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Benutzer aktivieren</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Möchten Sie diesen Benutzer wirklich aktivieren?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                <button type="button" class="btn btn-success" id="confirmUser">Aktivieren</button>
            </div>
        </div>
    </div>
</div>
<!-- Unconfirm User -->
<div class="modal fade" id="unconfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Benutzer Deaktivieren</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Möchten Sie diesen Benutzer wirklich deaktivieren?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                <button type="button" class="btn btn-danger" id="unconfirmUser">Deaktivieren</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete User -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="deleteUser">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $('#usersTable').DataTable({
            pageLength: 50,
            language: {
                paginate: {
                next: '<i class="fa fa-arrow-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-arrow-left" aria-hidden="true"></i>'
                },
                info: '_START_ bis _END_ von _TOTAL_ Einträge',
                infoEmpty: "_START_ bis _END_ von _TOTAL_ Einträge",
                sEmptyTable: "Keine Daten in der Tabelle verfügbar",
                infoFiltered: "(gelfiltert von _MAX_ Einträgen)",
                zeroRecords: "Keine übereinstimmenden Aufzeichnungen gefunden"
            },
            "dom": '<"top"ft><"bottom"ipl>',
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.users') !!}',
            columns: [
                { data: 'first_name', name: 'first_name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'roles.name' },
                { data: 'virtual', name: 'virtual' },
                { data: 'country', name: 'country' },
                { data: 'reset_password', name: 'reset_password', orderable: false, searchable: false},
                { data: 'confirm', name: 'confirm', orderable: false, searchable: false}
            ]
        });
        $('.dataTables_length > label > select').addClass('cloneselect');
        $('.cloneselect').appendTo('.dataTables_length');
        $('.dataTables_length > select').addClass('form-control').css('width','300px');
        $('.dataTables_length > label').remove();
        $('.dataTables_length').append('<label class="label-right">Einträge anzeigen</label>');

        $('.dataTables_filter > label > input').addClass('cloneinput form-control');
        $('.cloneinput').appendTo('.dataTables_filter');
        $('.dataTables_filter > label').html('<i class="fa fa-search" id="search-icon"></i>');
        $('.dataTables_filter input[type="search"]').attr("placeholder", "Sunchen...");
    });
    // ============ Confirm User ================
    $('body').on('click', '.confirmUser', function () {
        $('#confirmModal').modal('show')
        id = $(this).parent().parent().attr('id')
        // console.log(id);
    });
    $('#confirmUser').click(function () {
        $.ajax({
            type: 'GET',
            data: { _token: '{{ csrf_token() }}' },
            url: '/users/'+id+'/confirm',
            success: function (e) {
                $('#usersTable').DataTable().draw()
                $('#confirmModal').modal('hide')
                toastr.success('Benutzer aktiviert', {timeOut:5000})
            },
            error: function (xhr) {
                console.log(xhr)
            }
        })

    });// ============ Confirm User ================

     // ============ Unconfirm User ================
     $('body').on('click', '.unconfirmUser', function () {
        $('#unconfirmModal').modal('show')
        id = $(this).parent().parent().attr('id')
        // console.log(id);
    });
    $('#unconfirmUser').click(function () {
        $.ajax({
            type: 'GET',
            data: { _token: '{{ csrf_token() }}' },
            url: '/users/'+id+'/unconfirm',
            success: function (e) {
                $('#usersTable').DataTable().draw()
                $('#unconfirmModal').modal('hide')
                toastr.success('Benutzer deaktiviert', {timeOut:5000})
            },
            error: function (xhr) {
                console.log(xhr)
            }
        })

    });// ============ Unconfirm User ================


@hasrole('Administrator|Call Center Admin|Berater Admin')
    // ============ Delete User ================
        $('body').on('click', '.deleteUser', function () {
            $('#deleteModal').modal('show')
            id = $(this).parent().parent().parent().attr('id')
        });
        $('#deleteUser').click(function () {
            $.ajax({
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                url: '/users/'+id+'/delete',
                success: function (result) {
                    console.clear();
                    $('#usersTable').DataTable().draw()
                    $('#deleteModal').modal('hide')
                    toastr.success(result, {timeOut:5000})
                },
                error: function () {
                    // console.clear();
                    $('#usersTable').DataTable().draw()
                    $('#deleteModal').modal('hide')
                        toastr.error('User cannot be deleted. This user has employees', {timeOut:5000})
                }
            })
        });// ============ Confirm User ================

@endhasrole
</script>

@endsection

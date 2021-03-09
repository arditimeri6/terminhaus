@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @if (session('successKunden'))
            <script>
                toastr.success('{{ session('successKunden') }}', {timeOut:5000})
            </script>
        @endif
        <div class="col-md-11">
            <table class="table table-hover bg-white border-0" id="kundenTable">
                <thead>
                    <tr>
                        <th>Berater</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Client Source</th>
                        <th>Phonenumber</th>
                        <th>PLZ</th>
                        <th>Ort</th>
                        <th>Address</th>
                        <th>Type of contract</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
            <div class="top-inputs">
                <a href="{{ route('create.kunden') }}" title="Create" class="addButton"><i class="fas fa-plus-circle fa-2x"></i></a>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>

$(function() {
        $('#kundenTable').DataTable({
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
            ajax: '{!! route('get.kunden') !!}',
            order: [[ 1, 'asc' ]],
            columns: [
                { data: 'berater', name: 'users.first_name' },
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'client_source', name: 'client_sources.name' },
                { data: 'telefon', name: 'telefon' },
                { data: 'plz', name: 'plz' },
                { data: 'ort', name: 'ort' },
                { data: 'address', name: 'address' },
                { data: 'types_of_contract', name: 'types_of_contracts.name' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
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
        $('#kundenTable > tbody > td').addClass('costumborder');
        // $('.top').addClass('topAppointment');
    });

</script>
@endsection

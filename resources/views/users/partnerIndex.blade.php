@extends('layouts.app')

@section('content')

    @if (session('errorPartner'))
        <script>
            toastr.error('{{ session('errorPartner') }}', {timeOut:5000})
        </script>
    @endif
    @if (session('successPartner'))
        <script>
            toastr.success('{{ session('successPartner') }}', {timeOut:5000})
        </script>
    @endif

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-danger">
                <div class="card-header bg-white border-danger">
                    @hasrole('Administrator|Call Center Admin|Berater Admin')
                        <a href="{{route('indexPartners')}}" class="btn btn-outline-danger float-right createPartner-button">Partner</a>
                        <a href="{{ route('showUsers') }}" class="btn btn-outline-danger float-right indexPartner-button mr-3 ">Mitarbeiter</a>
                        <a href="#" class="float-left addButton createPartner"><i class="fas fa-plus-circle fa-2x"></i></a>
                    @endhasrole</div>
                    <div class="card-body">
                    <table class="table table-hover border-0 bg-white" id="partnersTable" style="width:100vw !important">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>First Partner</th>
                                <th>Second Partner</th>
                                <th>Created At</th>
                                @hasrole('Administrator')
                                    <th>Actions</th>
                                @endhasrole
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Partner -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Partner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this Partner?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="deletePartner">Confirm</button>
            </div>
        </div>
    </div>
</div>


<!-- Create Partner -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Partner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('storePartners')}}" method="post">
                    @csrf
                        <div class="form-group row">
                            <label for="first_partner" class="col-md-4 col-form-label text-md-right">First Partner</label>
                            <div class="col-md-6">
                                <select name="first_partner" id="first_partner" class="form-control">
                                    <option value="" id="partner_label1">Select First Partner</option>
                                    @hasrole('Administrator')
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                        @endforeach
                                    @endhasrole
                                    @hasrole('Call Center Admin')
                                        @foreach ($ccdirektors as $ccdirektor)
                                            <option value="{{$ccdirektor->id}}">{{$ccdirektor->first_name}} {{$ccdirektor->last_name}}</option>
                                        @endforeach
                                    @endhasrole
                                    @hasrole('Berater Admin')
                                        @foreach ($brdirektors as $brdirektor)
                                            <option value="{{$brdirektor->id}}">{{$brdirektor->first_name}} {{$brdirektor->last_name}}</option>
                                        @endforeach
                                    @endhasrole
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="second_partner" class="col-md-4 col-form-label text-md-right">Second Partner</label>
                            <div class="col-md-6">
                                <select name="second_partner" id="second_partner" class="form-control">
                                    <option value="" id="partner_label2" >Select First Partner</option>
                                    @hasrole('Administrator')
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                        @endforeach
                                    @endhasrole
                                    @hasrole('Call Center Admin')
                                        @foreach ($ccdirektors as $ccdirektor)
                                            <option value="{{$ccdirektor->id}}">{{$ccdirektor->first_name}} {{$ccdirektor->last_name}}</option>
                                        @endforeach
                                    @endhasrole
                                    @hasrole('Berater Admin')
                                        @foreach ($brdirektors as $brdirektor)
                                            <option value="{{$brdirektor->id}}">{{$brdirektor->first_name}} {{$brdirektor->last_name}}</option>
                                        @endforeach
                                    @endhasrole
                                </select>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="Submit" class="btn btn-danger" id="createPartner">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(function() {
        $('#partnersTable').DataTable({
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
            ajax: '{!! route('get.partners') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'first_partner_name', name: 'first_partner_name' },
                { data: 'second_partner_name', name: 'second_partner_name' },
                { data: 'created_at', name: 'created_at' },
                @hasrole('Administrator')
                    { data: 'buttons', name: 'buttons' },
                @endhasrole
            ]
        });
        $('.dataTables_length > label > select').addClass('cloneselect');
        $('.cloneselect').appendTo('.dataTables_length');
        $('.dataTables_length > select').addClass('form-control').css('width','16vw');
        $('.dataTables_length > label').remove();
        $('.dataTables_length').append('<label class="label-right">Einträge anzeigen</label>');

        $('.dataTables_filter > label > input').addClass('cloneinput form-control');
        $('.cloneinput').appendTo('.dataTables_filter');
        $('.dataTables_filter > label').html('<i class="fa fa-search" id="search-icon"></i>');
        $('.dataTables_filter input[type="search"]').attr("placeholder", "Sunchen...");

    });

        (function () {
            var _first;

            $("#first_partner").on('focus', function () {

                _first = this.value;
            }).change(function() {
                // console.log(_first);
                first_id = $('#first_partner').val();
                second_id = $('#second_partner').val();
                $('#partner_label1').hide();
                $("#second_partner [value="+ first_id +"]").hide();
                $("#second_partner [value="+ _first +"]").show();
            });
        })();

        (function () {
            var previous_second;

            $("#second_partner").on('focus', function () {
                previous_second = this.value;
            }).change(function() {
                // console.log(previous_second);
                first_id = $('#first_partner').val();
                second_id = $('#second_partner').val();
                $('#partner_label2').hide();

                $("#first_partner [value="+ second_id +"]").hide();
                $("#first_partner [value="+ previous_second +"]").show();
            });
        })();

@hasrole('Administrator')
    // ============ Delete Partner ================
    $('body').on('click', '.deletePartner', function () {
            $('#deleteModal').modal('show')
            id = $(this).parent().parent().attr('id')
        });
        $('#deletePartner').click(function () {
            $.ajax({
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                url: '/partners/'+id+'/delete',
                success: function (e) {
                    $('#partnersTable').DataTable().draw()
                    $('#deleteModal').modal('hide')
                    toastr.success('Partner Deleted', {timeOut:5000})
                },
                error: function (xhr) {
                    console.log(xhr)
                }
            })
        });// ============ Delete Partner ================
@endhasrole

        // ============ Create Partner ================
        $('body').on('click', '.createPartner', function () {
            $('#createModal').modal('show')
            id = $(this).parent().parent().attr('id')
        }); // ============ Create Partner ================

    </script>
@endsection

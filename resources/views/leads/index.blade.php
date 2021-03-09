@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @if (session('successLead'))
            <script>
                toastr.success('{{ session('successLead') }}', {timeOut:5000})
            </script>
        @endif
        <div class="col-md-11">
            @hasrole('Administrator|Call Center Admin|Berater Admin')
                <a type="button" class="leadsingleexport" id="btnSingleExport">
                    <span class="btn btn-outline-danger">Single Export</span>
                </a>
                <a href="{{ route('exportall_lead') }}" class="exportall-lead" id="exportall">
                    <span class="btn btn-outline-danger">Export All</span>
                </a>
            @endhasrole
            <table class="table table-hover bg-white border-0" id="leadsTable">
                <thead>
                    <tr>
                        @hasrole('Administrator|Broker Direktor|Call Center Admin|Berater Admin|Call Center Direktor')
                            <th> <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="checkAll"><label class="custom-control-label checkbox-inline costumcheckbox1" for="checkAll"></label></div></th>
                        @endhasrole
                        <th>Id</th>
                        <th>Voller Name && Strasse</th>
                        <th>Company</th>
                        <th>Created By</th>
                        <th>Call Datum</th>
                        <th>Ort</th>
                        <th>Kanton</th>
                        @hasrole('Administrator|Berater Admin|Call Center Admin')
                            <th>Assigned from</th>
                        @endhasrole
                        @unlessrole('Agent')
                            <th>Zugewiesen an</th>
                        @endhasrole
                        <th>Status</th>
                        <th>Status</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
            </table>
            <div class="top-inputs">
                <div class="row">
                    <div class="form-inline">
                        <div class="form-group vertielen-form">
                            <a href="{{ route('create.lead') }}" title="Create" class="addButton"><i class="fas fa-plus-circle fa-2x"></i></a>
                        </div>
                        @hasrole('Administrator|Call Center Admin|Berater Admin|Call Center Direktor')
                            <div class="form-group vertielen-form">
                                <select id="direktor" class="form-control costum-select dynamic" data-dependent="agents" disabled>
                                    <option value="">Admin wählen</option>
                                    @foreach($directors as $director)
                                        <option value="{{$director->id}}">{{$director->first_name}} {{$director->last_name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group vertielen-form">
                                <select class="form-control costum-select" id="agents" disabled>

                                </select>
                            </div>
                            <div class="form-group vertielen-form">
                                <button type="submit" disabled id="assignButton" class="btn btn-outline-danger costumbtn">Verteilen</button>
                            </div>
                        @endhasrole
                    </div>
                </div>
            </div>
            <div class="filter-date">
                <div class="row">
                    <div class="form-inline">
                        <div class="form-group">
                            <select id="filter_by" name="filter_by" class="form-control">
                                <option id="filter_option" value="0">Filter By</option>
                                <option value="2">Call Datum</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="costum-date fromlabel" for="from_input">From - To: &nbsp;</label>
                            <input class="form-control" name="from" id="filter_datepicker" placeholder="dd/mm/yyyy" autocomplete="off">
                        </div>
                        <div class="form-group ml-3">
                            <button type="submit" id="filtersubmit" class="btn btn-outline-danger">Search</button>
                        </div>
                        <div class="form-group ml-3">
                            <button type="button"  class="btn btn-outline-secondary ml-2" id="clearFilter-leads">Clear Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Leads Status -->
<div class="modal fade" id="statusModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Leads id: <span class="modal-id"> </span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="row">
                        <label for="Leads Status" class="col-md-4 h5 mt-2">Leads Status</label>

                    <div class="col-md-6">
                        <select name="call_status" id="callStatus" class="form-control">

                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-danger status-submit">Save</button>
            </div>
        </div>
    </div>
</div>



<!-- Delete Lead -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Lead</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this Lead?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-danger" id="deleteLead">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

$(function() {
        var table = $('#leadsTable').DataTable({
            pageLength: 50,
            lengthMenu: [
                [ 10, 25, 50, 100 ],
                [ '10', '25', '50', '100' ]
                ],
                buttons: [
                    @hasrole('Administrator|Call Center Admin|Berater Admin')
                    {
                        extend: 'excelHtml5',
                        text: 'Export selected',
                        filename: 'Exported Selected',
                        title: '',
                        exportOptions: {
                            modifier: {
                                selected: true
                            },
                            columns: [2, 3, 4, 5, 6, 7, 8, 9]
                        },
                    }
                    @endhasrole
                ],
            select: {
                    style : "multi",
                    selector: 'td:first-child div input'
                },
            language: {
                paginate: {
                next: '<i class="fa fa-arrow-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-arrow-left" aria-hidden="true"></i>'
                },
                info: '_START_ bis _END_ von _TOTAL_ Einträge',
                infoEmpty: "_START_ bis _END_ von _TOTAL_ Einträge",
                sEmptyTable: "Keine Daten in der Tabelle verfügbar",
                infoFiltered: "(gelfiltert von _MAX_ Einträgen)",
                zeroRecords: "Keine übereinstimmenden Aufzeichnungen gefunden",
                select: {
                rows: {
                    _: " (%d termine ausgewählt)",
                    0: ""
                    }
                }
            },
            "dom": '<"top"Bft><"bottom"ipl>',
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.lead') !!}',
            @hasrole('Administrator|Call Center Admin|Berater Admin|Call Center Direktor|Broker Direktor')
                order: [ 1, 'desc' ],
            @endhasrole
            @hasrole('Agent Team Leader|Quality Controll|Berater Team Leader|Agent|Berater')
                order: [ 0, 'desc' ],
            @endhasrole
            columns: [
                @hasrole('Administrator|Broker Direktor|Call Center Admin|Berater Admin|Call Center Direktor')
                    { data: 'check', name: 'check' , orderable: false, searchable: false },
                @endhasrole
                { data: 'id', name: 'id' },
                { data: 'first_name', name: 'first_name' },
                { data: 'usercompany', name: 'direktors.company_name' },
                { data: 'createdByUser', name: 'createdBy.email' },
                { data: 'created_at_filter', name: 'created_at_filter',
                    render: function(data) {
                        return moment(data).format("DD.MM.YYYY");
                    }
                },
                { data: 'place', name: 'place' },
                { data: 'canton', name: 'canton' },
                @hasrole('Administrator|Berater Admin|Call Center Admin')
                    { data: 'userfrom', name: 'userAssigned.email' },
                @endhasrole
                @unlessrole('Agent')
                    { data: 'user', name: 'users.email' },
                @endhasrole
                { data: 'callstatus', name: 'status.call_status' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
                { data: 'last_name', name: 'last_name', searchable: true, sortable : true, visible:false },
                { data: 'post_code', name: 'post_code', searchable: true, sortable : true, visible:false},
                { data: 'qcstatus', name: 'status.qc_status', searchable: true, sortable : true, visible:false},
            ]
        });

        $(document).on( 'draw.dt', function () {
            table.rows().deselect();
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
        $('.top').addClass('topAppointment');
        $('.dt-buttons button').addClass('costumBtn')
        $('.dt-button').parent().css('margin-right','-85px')


        // $('.dt-buttons button:nth-child(1)').hide();
        // $('.dt-buttons button:nth-child(2)').hide();

    //    $('#leadsTable tbody').on('click', 'tr', function () {
    //         $(this).removeClass('selected')
    //         var selected = $(this);
    //         $("input[type='checkbox']", this).each( function() {
    //             if($(this).is(':checked')){
    //                 $('.costum-select').removeAttr('disabled');
    //                 table.row(selected, { page: 'current' }).select();
    //                 selected.addClass('selected')
    //             }
    //             else{
    //                 $('.costum-select').attr('disabled',true)
    //                 table.row(selected, { page: 'current' }).deselect();
    //                 selected.removeClass('selected')
    //             }
    //                 var all_id = [];
    //                 var alldata = table.rows( $('.selected') ).data();
    //                 let selected_len = $('.selected').length;
    //                 for(i = 0; i < selected_len; i++){
    //                     all_id.push(alldata[i]['id'])
    //                 }
    //                 $('#btnSingleExport').on('click', function(){
    //                     location.href = '/single-export/'+all_id;
    //                 });
    //             });
    //         });

    //     $('#checkAll').on('click',function() {
    //         if($(this).is(':checked')){
    //             $('#leadsTable tbody tr').addClass('selected')
    //             table.rows().select();

    //             $('#btnSingleExport').on('click', function(){
    //                 var ids = table.data();
    //                 var allids = [];
    //                 for(var i=0;i<ids.length;i++){
    //                     allids.push(ids[i]['id']);
    //                 }
    //                 location.href = '/single-export/'+allids;
    //             });
    //         }
    //         else{
    //             $('#leadsTable tbody tr').removeClass('selected')
    //             table.rows().deselect();
    //         }
    //     })

    $(document).ready(function(){
        $('.dt-buttons button:nth-child(1)').hide();
            $('#btnSingleExport').hide();
            $('#leadsTable tbody').on('click', 'tr', function () {
                $(this).removeClass('selected')
                var selected = $(this);
                $("input[type='checkbox']", this).each( function() {
                    if($(this).is(':checked')){
                        $('.costum-select').removeAttr('disabled');
                        table.row(selected, { page: 'current' }).select();
                        selected.addClass('selected')

                        if($('.selected').length > 0){
                            $('.dt-buttons button:nth-child(1)').show();
                            $('#btnSingleExport').show();
                        }
                    }
                    else{
                        $('.costum-select').attr('disabled',true)
                        table.row(selected, { page: 'current' }).deselect();
                        selected.removeClass('selected')

                        if($('.selected').length == 0) {
                            $('.dt-buttons button:nth-child(1)').hide();
                            $('#btnSingleExport').hide();
                        }
                    }
                        var all_id = [];
                        var alldata = table.rows( $('.selected') ).data();
                        let selected_len = $('.selected').length;
                        for(i = 0; i < selected_len; i++){
                            all_id.push(alldata[i]['id'])
                        }
                        $('#btnSingleExport').on('click', function(){
                            location.href = '/single-export/'+all_id;
                        });
                    });
                });

            $('#checkAll').on('click',function() {
                if($(this).is(':checked')){
                    $('#leadsTable tbody tr').addClass('selected')
                    table.rows().select();
                    $('.dt-buttons button:nth-child(1)').show();
                    $('#btnSingleExport').show();
                    $('#btnSingleExport').on('click', function(){
                        var ids = table.data();
                        var allids = [];
                        for(var i=0;i<ids.length;i++){
                            allids.push(ids[i]['id']);
                        }
                        location.href = '/single-export/'+allids;
                    });
                }
                else{
                    $('#leadsTable tbody tr').removeClass('selected')
                    table.rows().deselect();
                    $('.dt-buttons button:nth-child(1)').hide();
                    $('#btnSingleExport').hide();
                }
            })
})


        $('.form-inline').addClass('costum-from-inline')

        // ============ Leads Status ================
        $('body').on('click', '.status-modal', function () {
                $('#statusModal').modal('show')
                id = $(this).parent().parent().attr('id')
                $('.modal-id').html(id)
                $.ajax({
                    type: 'GET',
                    url: '/leads/'+id+'/status/show',
                    success: function (result) {
                    $('#callStatus').html(result)
                    },
                    error: function (xhr) {
                        console.log(xhr)
                    }
                })
        });


        $('.status-submit').on('click',function(){

            var data =  $('#callStatus').val();
            var id = $('.modal-id').text();

                $.ajax({
                    type: 'POST',
                    url: '/leads/'+id+'/status/store',
                    data: {
                        _token: '{{ csrf_token() }}',
                        data:data,
                    },

                    success: function (result) {
                        $('#leadsTable').DataTable().draw()
                        $('#statusModal').modal('hide');
                        toastr.success(result, {timeOut:5000})
                        // console.log(result);
                    },
                    error: function (xhr) {
                        console.log(xhr)
                    }
                })
        });

        // ============ Delete Lead ================
        @role('Administrator')
            $('body').on('click', '.deleteLead', function () {
                $('#deleteModal').modal('show')
                id = $(this).parent().parent().parent().attr('id')
                // console.log(id)
            });
            $('#deleteLead').click(function () {
                $.ajax({
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    url: '/lead/'+id+'/delete',
                    success: function (e) {
                        $('#leadsTable').DataTable().draw()
                        $('#deleteModal').modal('hide')
                        toastr.success('Lead Deleted', {timeOut:5000})
                    },
                    error: function (xhr) {
                        console.log(xhr)
                    }
                })

            });// ============ Delete Lead ================
        @endrole

        $('.dynamic').change( function() {
            if($(this).val() != ''){
                var select = $(this).attr('id');
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('select.leadAgent') }}",
                    method: "POST",
                    data: {
                        select:select,
                        value:value,
                        _token:_token,
                        dependent:dependent,
                    },
                    success: function(result) {
                        $('#'+dependent).html(result);
                        $("#agents option:first").text("Agent wählen");
                    },
                    error: function(xhr) {
                        console.log(xhr)
                    }
                })
            }
        });




        $('#assignButton').click(function(){
            selectBoxArray = []
            $.each($('input[name="checkAppointment"]:checked'), function(){
                selectBoxArray.push(this.value)
            })
            var agent = $('#agents').val();
            var direktor = $('#direktor').val();

            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('leadAssign.to') }}",
                method: "POST",
                data: {
                    agent:agent,
                    direktor:direktor,
                    selectBoxArray:selectBoxArray,
                    _token:_token,
                },
                success: function(result) {
                    $('#leadsTable').DataTable().draw()
                    toastr.success('Leads erfolgreich Zugewiesen', {timeOut:5000})
                    $('.costum-select').attr('disabled',true)
                    $('#direktor').val('');
                    $('#agents').val('');
                    $('#assignButton').attr('disabled',true)
                    $('#checkAll').prop('checked', false)
                },
                error: function(xhr) {
                    console.log(xhr);
                },
            })
        });

        $('#direktor').on('change',function(){
                if($('#direktor').val() == ''){
                    // $('#agents').prop( "disabled", true );
                    $("#agents").html('<option value=""></option>');
                    $("#agents option:first").text("Remove Assign");
                    $("#agents option:first").attr('selected','selected');
                }else{
                    // $('#agents').prop( "disabled", false );
                    $("#agents option:first").text("Agent wählen");
                }
        });

        $('#agents').on('change',function(){
            $('#agents option:first').hide();
        });

        $('body').on('change', '.check', function() {
            $('.check:checked').length ? $('.costum-select').removeAttr('disabled') : $('.costum-select').attr('disabled',true)
            $('.check:checked').length ? $('#assignButton').attr('disabled', false) : $('#assignButton').attr('disabled', true)

            if($('#direktor').val() == ''){
                $("#agents").html('<option value=""></option>');
                $("#agents option:first").text("Remove Assign");
                $("#agents option:first").attr('selected','selected');
            }else{
                $("#agents option:first").text("Agent wählen");
            }
        })


        $('#checkAll').change(function() {
            $('input[name="checkAppointment"]').prop("checked", $(this).prop("checked"));
            if($('#checkAll:checked').length != 0){
                $('#direktor').removeAttr('disabled')
                $('#agents').removeAttr('disabled')
                $("#agents").html('<option value=""></option>');
                $("#agents option:first").text("Remove Assign");
                $("#agents option:first").attr('selected','selected');
                $('#assignButton').removeAttr('disabled')
            }else{
                $('.costum-select').attr('disabled',true);
                $('#agents').attr('disabled',true);
                $('#assignButton').attr('disabled', true)
            }
        })
    })
   //Start Data filter Function
$(function() {

       var nowDate = new Date();
       var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
       var from = today.getDate();

       ////// Format Date for send requests to controller
       var twoDigitMonth = ((nowDate.getMonth().length+1) === 1)? (nowDate.getMonth()+1) : '0' + (nowDate.getMonth()+1);
       var currentDate = nowDate.getFullYear() + "-" + twoDigitMonth + "-" + nowDate.getDate();
       ///// Set today date value for requests if not picked date
       var from = currentDate;
       var to = currentDate;

   ///// Data Range Picker
   $('#filter_datepicker').daterangepicker({
       opens: 'center',
       showDropdowns: true,
       showButtonPanel: false,
       locale: {
           format: 'DD/MM/YYYY'
       }
       }, function (start, end, label) {
           from = start.format('YYYY-MM-DD');
           to = end.format('YYYY-MM-DD');
       });
       $('.applyBtn').remove();
       $('.cancelBtn').remove();

       // Submit Filter Ajax
           $('#filtersubmit').click( function() {
           var _token = "{{ csrf_token() }}";
           var filter_by = $('#filter_by').val();
               $.ajax({
                   url:"{!! route('get.LeadsTimeFilter') !!}",
                   method: "POST",
                   data: {
                       filter_by:filter_by,
                       from:from,
                       to:to,
                       _token:_token,

                   },
                   success: function(result) {
                    //    console.log(result)
                       $('#leadsTable').DataTable().draw()
                   },
                   erorr: function(xhr){
                       console.log(xhr)
                   }
               })
       });

       /// Filter by , Call Datum , Termin Datum on change
       $('#filter_datepicker').attr('disabled', true)
       $('#filtersubmit').attr('disabled', true)

       $('#filter_by').change(function(){
           if($('#filter_by').val() != 0){
               $('#filter_datepicker').attr('disabled', false)
               $('#filtersubmit').attr('disabled', false)
           }
           else{
               $('#filter_datepicker').attr('disabled', true)
               $('#filtersubmit').attr('disabled', true)
           }
       })

   });// End Data Filter function

    $('body').on('click', '#clearFilter-leads', function (){
        $('#leadsTable').DataTable().draw()
    })


</script>
@endsection

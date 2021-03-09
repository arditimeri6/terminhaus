@extends('layouts.app')
@section('content')
<script src="{{ asset('js/location/de.js') }}"></script>
<div class="container-fluid">
    <div class="row justify-content-center">
        @if (session('successAppointmentUpdating'))
            <script>
                toastr.success('{{ session('successAppointmentUpdating') }}', {timeOut:5000})
            </script>
        @endif
        @if (session('errorAppointmentUpdating'))
            <script>
                toastr.success('{{ session('errorAppointmentUpdating') }}', {timeOut:5000})
            </script>
        @endif
        @if (session('successAppointment'))
            <script>
                toastr.success('{{ session('successAppointment') }}', {timeOut:5000})
            </script>
        @endif
        @if ($errors->any())
            @foreach($errors->all() as $error)
                <script>
                    toastr.error('{{$error}}', {timeOut:50000})
                </script>
            @endforeach
        @endif
        <div class="col-11">
            <div class="modal fade" id="importModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Import Excel File</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" action="{{ route('import_excel') }}">
                        @csrf
                        <input type="file" name="excel_import" required/>
                        <input type="submit" name="upload" class="btn btn-outline-danger" value="Upload">
                        </form>
                    </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="showFeedbackModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <form method="post" enctype="multipart/form-data"  id="feedbackForm">
                        @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Feedback - Id: <span id="appointmentid"></span></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            @unlessrole('Berater')
                                <div class="col-md-6 mb-2">
                                    <div class="form-control">
                                        <div class="custom-checkbox ml-4">
                                            <input type="hidden" id="appointmentidvalue" name="appointmentid">
                                            <input type="checkbox" class="custom-control-input" id="unzuteilbar" name="unzuteilbar" value="unzuteilbar">
                                            <label class="custom-control-label pl-3" for="unzuteilbar">Unzuteilbar</label>
                                        </div>
                                    </div>
                                </div>
                            @endunlessrole
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="zeitlich_nicht_geschafft" name="zeitlich_nicht_geschafft" value="zeitlich_nicht_geschafft">
                                        <label class="custom-control-label pl-3" for="zeitlich_nicht_geschafft">Zeitlich nicht geschafft</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="berater_nicht_besucht" name="berater_nicht_besucht" value="berater_nicht_besucht">
                                        <label class="custom-control-label pl-3" for="berater_nicht_besucht">Berater nicht besucht</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="kunde_nicht_auffindbar" name="kunde_nicht_auffindbar" value="kunde_nicht_auffindbar">
                                        <label class="custom-control-label pl-3" for="kunde_nicht_auffindbar">Kunde nicht auffindbar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="falsche_adresse" name="falsche_adresse" value="falsche_adresse">
                                        <label class="custom-control-label pl-3" for="falsche_adresse">Falsche Adresse</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="kunde_nicht_err" name="kunde_nicht_err" value="kunde_nicht_err">
                                        <label class="custom-control-label pl-3" for="kunde_nicht_err">Kunde nicht err.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="nicht_zu_hause" name="nicht_zu_hause" value="nicht_zu_hause">
                                        <label class="custom-control-label pl-3" for="nicht_zu_hause">Nicht zu Hause</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="wollte_kein_termin" name="wollte_kein_termin" value="wollte_kein_termin">
                                        <label class="custom-control-label pl-3" for="wollte_kein_termin">Wollte kein Termin</label>
                                    </div>
                                </div>
                            </div>
                            @hasrole('Administrator|Call Center Admin|Berater Admin')
                                <div class="col-md-6 mb-2">
                                    <div class="form-control">
                                        <div class="custom-checkbox ml-4">
                                            <input type="checkbox" class="custom-control-input" id="verspatet_angemeldet" name="verspatet_angemeldet" value="verspatet_angemeldet">
                                            <label class="custom-control-label pl-3" for="verspatet_angemeldet">Verspätet angemeldet</label>
                                        </div>
                                    </div>
                                </div>
                            @endhasrole
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="stattgefunden" name="stattgefunden" value="stattgefunden">
                                        <label class="custom-control-label pl-3" for="stattgefunden">Stattgefunden</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="konnte_nicht_beraten" name="konnte_nicht_beraten" value="konnte_nicht_beraten">
                                        <label class="custom-control-label pl-3" for="konnte_nicht_beraten">Konnte nicht beraten</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="mjv" name="mjv" value="mjv">
                                        <label class="custom-control-label pl-3" for="mjv">MJV</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="behandlung" name="behandlung" value="behandlung">
                                        <label class="custom-control-label pl-3" for="behandlung">Behandlung</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="zu_alt" name="zu_alt" value="zu_alt">
                                        <label class="custom-control-label pl-3" for="zu_alt">Zu alt</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="socialfall" name="socialfall" value="socialfall">
                                        <label class="custom-control-label pl-3" for="socialfall">Socialfall</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="schulden_betreibung" name="schulden_betreibung" value="schulden_betreibung">
                                        <label class="custom-control-label pl-3" for="schulden_betreibung">Schulden/Betreibung</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="negativ" name="negativ" value="negativ">
                                        <label class="custom-control-label pl-3" for="negativ">Negativ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-control">
                                    <div class="custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="offen" name="offen" value="offen">
                                        <label class="custom-control-label pl-3" for="offen">Offen</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2 offenSecondDate hidden-field">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="seconddate">Termin Datum</label>
                                        <input type="text" id="selectSecondDate" name="seconddate" autocomplete="off" class="form-control" placeholder="dd/mm/yyyy">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="secondtime">Termin Zeit</label>
                                        <input type="text" name="secondtime" id="timepicker" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="from-group border feedback-bottom">
                                    <div class="row form-control-positiv">
                                        <div class="custom-checkbox ml-4 col-md-12">
                                            <input type="checkbox" class="custom-control-input" id="positiv" name="positiv" value="positiv">
                                            <label class="custom-control-label pl-3" for="positiv">Positiv</label>
                                        </div>
                                        <div class="col-md-12 positiv-label mt-3"><p>Anzahl Abschlüsse</p></div>
                                        <div class="form-group row col-4 positiv-label">
                                            <label class="col-md-6 col-form-label text-md-right">KVG &amp; VVG</label>
                                            <div class="col-md-6">
                                                <input type="text" id="kvg_vvg" class="form-control" name="kvg_vvg">
                                            </div>
                                        </div>
                                        <div class="form-group row col-4 positiv-label">
                                            <label class="col-md-6 col-form-label text-md-right">Nur VVG</label>
                                            <div class="col-md-6">
                                                <input type="text" id="nur_vvg" class="form-control" name="nur_vvg">
                                            </div>
                                        </div>
                                        <div class="form-group row col-4 positiv-label">
                                            <label class="col-md-6 col-form-label text-md-right">Andere</label>
                                            <div class="col-md-6">
                                                <input type="text" id="andere" class="form-control" name="andere">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label>Bemerkung</label>
                                <textarea class="form-control" name="comment" id="comment" cols="10" rows="4"></textarea>
                            </div>
                            <div class="col-md-12 feedback-files">
                            <label for="file">Hochladen</label>
                                <input type="file" name="file[]" id="fileUpload" accept="image/png, image/jpeg, audio/mp3, video/*" class="form-control" multiple>
                                @if ($errors->has('file.*'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file.*') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-5"  style="width: 100%;">
                        <div class="float-left">
                            <button type="button" class="btn btn-outline-info" id="countFeedBacks"> History </button>
                        </div>
                        <div class="float-right">
                            <button type="button"  class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-danger">Save</button>
                        </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            @hasrole('Administrator')
                <button type="button" class="btn btn-outline-danger btnModal" data-toggle="modal" data-target="#importModal"> Import</button>
            @endrole
            @hasrole('Administrator|Call Center Admin|Berater Admin')
                <a type="button" class="btnSingleExport" id="btnSingleExport">
                    <span class="btn btn-outline-danger">Single Export</span>
                </a>
                <a href="{{ route('export_all') }}" class="exportall" id="exportall">
                    <span class="btn btn-outline-danger">Export All</span>
                </a>
            @endhasrole
            <table class="table table-hover bg-white border-0" id="appointmentTable">
                <thead>
                    <tr>
                        @hasrole('Administrator|Broker Direktor|Call Center Admin|Berater Admin|Berater Team Leader')
                            <th> <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="checkAll"><label class="custom-control-label checkbox-inline costumcheckbox1" for="checkAll"></label></div></th>
                        @endhasrole
                        <th>Id</th>
                        <th>Voller Name & Strasse</th>
                        <th>Company</th>
                        <th>Created By</th>
                        @unlessrole('Agent')
                            <th>Members & KK</th>
                        @endunlessrole
                        <th>Termin Datum</th>
                        <th>Termin Zeit</th>
                        <th>Kanton</th>
                        @unlessrole('Agent')
                            <th>Sprache</th>
                        @endhasrole
                        <th>Status</th>
                        @hasrole('Administrator|Berater Admin|Call Center Admin')
                            <th>Assigned from</th>
                        @endhasrole
                        @unlessrole('Agent')
                            @if(Auth::user()->assign_view_access == 1)
                                <th>Zugewiesen an</th>
                            @endif
                        @endunlessrole
                        <th>Feedback</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
            </table>
            <div class="top-inputs">
                <div class="row">
                    <div class="form-inline">
                        <div class="form-group vertielen-form">
                            <a href="{{ route('create.appointment') }}" title="Create" class="addButton"><i class="fas fa-plus-circle fa-2x"></i></a>
                        </div>
                         @hasrole('Administrator|Call Center Admin|Berater Admin|Broker Direktor|Berater Team Leader')
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
                                <option value="1">Termin Datum</option>
                                <option value="2">Call Datum</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="costum-date fromlabel" for="from_input">From - To: &nbsp;</label>
                            <input class="form-control" name="from" id="filter_datepicker" placeholder="dd/mm/yyyy - dd/mm/yyyy" autocomplete="off">
                        </div>
                        <div class="form-group ml-3">
                            <button type="submit" id="filtersubmit" class="btn btn-outline-danger">Search</button>
                        </div>
                    </div>

                    <div class="form-inline">
                        @hasrole('Administrator|Call Center Admin')
                            <div class="form-group ml-3">
                                <select id="filter_by_hierarchy" name="filter_by_hierarchy" class="form-control">
                                    <option id="filter_hierarchy_option" value="0" style="display:none;">Filter By</option>
                                    <option value="1">Call Center</option>
                                    <option value="2">Broker</option>
                                </select>
                            </div>
                        @endhasrole
                        <div class="form-group ml-3">
                            <button type="button"  class="btn btn-outline-secondary ml-2" id="clearFilter-Appointments">Clear Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Feedback History -->
<div class="modal fade" id="historyModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Feedback History <span id="historyId"> </span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
            <table class="table table-hover bg-white border-0" id="historyTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        @hasrole('Administrator|Call Center Admin|Call Center Direktor|Berater Admin')
                            <th>Name</th>
                        @endhasrole
                        <th>Feedback</th>
                        <th>Comment</th>
                        <th>KVG & VVG</th>
                        <th>Nur VVG</th>
                        <th>Andere</th>
                        <th>Created At</th>
                        <th style="text-align: center !important;">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Feedback History Second-->
<div class="modal fade" id="historyModalSecond">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Feedback History <span id="historyIdSecond"> </span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
            <table class="table table-hover bg-white border-0" id="historyTableSecond">
                <thead>
                    <tr>
                        <th>ID</th>
                        @hasrole('Administrator|Call Center Admin|Call Center Direktor|Berater Admin')
                            <th>Name</th>
                        @endhasrole
                        <th>Feedback</th>
                        <th>Comment</th>
                        <th>KVG & VVG</th>
                        <th>Nur VVG</th>
                        <th>Andere</th>
                        <th>Created At</th>
                        <th style="text-align: center !important;">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Feedback History -->
<div class="modal fade" id="deleteFeedbackModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Feedback Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                Are you sure to delete this Feedback?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-danger" id="deleteFeedback">Delete</button>
            </div>
        </div>
    </div>
</div>




<!-- Feedback Files -->
<div class="modal fade" id="filesModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Feedback Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">

                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Delete Appointment -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this Appointment?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-danger" id="deleteAppointment">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    $(function() {

        var table = $('#appointmentTable').DataTable({
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
                            columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 12]
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
            ajax: {
                url: '{!! route('get.appointments') !!}',
                data: function(d) {
                    d.filter_by_hierarchy = $('#filter_by_hierarchy').val();
                }
            },
            @hasrole('Administrator|Call Center Admin|Berater Admin|Broker Direktor|Berater Team Leader')
                order: [ 1, 'desc' ],
            @endhasrole
            @hasrole('Call Center Direktor|Agent Team Leader|Quality Controll|Agent|Berater')
                order: [ 0, 'desc' ],
            @endhasrole
            columns: [
                @hasrole('Administrator|Berater Admin|Broker Direktor|Call Center Admin|Berater Team Leader')
                    { data: 'check', name: 'check', orderable: false, searchable: false },
                @endhasrole
                { data: 'id', name: 'id' },
                { data: 'first_name', name: 'first_name' },
                { data: 'createdByCompany', name: 'createdBy.company_name' },
                { data: 'createdByUser', name: 'createdBy.email' },
                @unlessrole('Agent')
                    { data: 'members_count', name: 'members_count' },
                @endunlessrole
                { data: 'date', name: 'date' ,
                    render: function(data) {
                        return moment(data).format("DD.MM.YYYY");
                    }
                },
                { data: 'time', name: 'time' },
                { data: 'canton', name: 'canton' },
                @unlessrole('Agent')
                    { data: 'language', name: 'language' },
                @endunlessrole
                { data: 'status', name: 'status' },
                @hasrole('Administrator|Berater Admin|Call Center Admin')
                    { data: 'userfrom', name: 'userAssigned.email' },
                @endhasrole
                @unlessrole('Agent')
                    @if(Auth::user()->assign_view_access == 1)
                        { data: 'user', name: 'users.email' },
                    @endif
                @endunlessrole
                { data: 'feedback', name: 'feedback', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
                { data: 'last_name', name: 'last_name', searchable: true, sortable : true, visible:false},
                { data: 'street', name: 'street', searchable: true, sortable : true, visible:false},
                { data: 'krankenkassen', name: 'krankenkassen', searchable: true, sortable : true, visible:false},
                { data: 'post_code', name: 'post_code', searchable: true, sortable : true, visible:false},
                { data: 'date_for_search', name: 'date_for_search', searchable: true, sortable : true, visible:false},
                { data: 'usercompany', name: 'direktors.company_name', searchable: true, sortable : true, visible:false},

            ]
        });

        $(document).on( 'draw.dt', function () {
            table.rows().deselect();
        });

        $('.dt-buttons button').addClass('costumBtn')
    $('.dt-buttons button:nth-child(1)').hide();
    $('#btnSingleExport').hide();
        $('#appointmentTable tbody').on('click', 'tr', function () {
            $(this).removeClass('selected')
            var selected = $(this);

            $("input[type='checkbox']", this).each( function() {

                if($(this).is(':checked')){
                    table.row(selected, { page: 'current' }).select();
                    selected.addClass('selected')
                    if($('.selected').length > 0){
                        $('.dt-buttons button:nth-child(1)').show();
                        $('#btnSingleExport').show();
                    }
                }
                else{
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
                    location.href = '/singleExcel/'+all_id;
                });

                });
            });


            $('#checkAll').on('click',function() {

                if($(this).is(':checked')){
                    $('#appointmentTable tbody tr').addClass('selected')
                    table.rows().select();
                    $('.dt-buttons button:nth-child(1)').show();
                    $('#btnSingleExport').show();
                    $('#btnSingleExport').on('click', function(){
                        var ids = table.data();
                        var allids = [];
                        for(var i=0;i<ids.length;i++){
                            allids.push(ids[i]['id']);
                        }
                        location.href = '/singleExcel/'+allids;
                    });
                }
                else{
                    $('#appointmentTable tbody tr').removeClass('selected')
                    table.rows().deselect();
                    $('.dt-buttons button:nth-child(1)').hide();
                    $('#btnSingleExport').hide();
                }
            })

        $('.dataTables_length > label > select').addClass('cloneselect');
        $('.cloneselect').appendTo('.dataTables_length');
        $('.dataTables_length > select').addClass('form-control').css('width','300px');
        $('.dataTables_length > label').remove();
        $('.dataTables_length').append('<label class="label-right">Einträge anzeigen</label>');

        $('.dataTables_filter > label > input').addClass('cloneinput form-control');
        $('.cloneinput').appendTo('.dataTables_filter');
        $('.dataTables_filter > label').html('<i class="fa fa-search" id="search-icon"></i>');
        $('.dataTables_filter input[type="search"]').attr("placeholder", "Sunchen...");
        $('#appointmentTable > tbody > td').addClass('costumborder');
        $('.top').addClass('topAppointment');

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

    $('#assignButton').click(function(){
        selectBoxArray = []
        $.each($('input[name="checkAppointment"]:checked'), function(){
            selectBoxArray.push(this.value)
        })
        var agent = $('#agents').val();
        var direktor = $('#direktor').val();

            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('assign.to') }}",
                method: "POST",
                data: {
                    agent:agent,
                    direktor:direktor,
                    selectBoxArray:selectBoxArray,
                    _token:_token,
                },
                success: function(result) {
                    $('#appointmentTable').DataTable().draw()
                    toastr.success('Termin erfolgreich Zugewiesen', {timeOut:5000})
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
                $("#agents").html('<option value=""></option>');
                $("#agents option:first").text("Remove Assign");
                $("#agents option:first").attr('selected','selected');
            }else{
                $("#agents option:first").text("Agent wählen");
            }
    });

    $('#agents').on('change',function(){
        $('#agents option:first').hide();
    });

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

    $('.dynamic').change( function() {
        if($(this).val() != ''){
            var select = $(this).attr('id');
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('select.agent') }}",
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

            })
        }
    });

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
                url:"{!! route('get.AppointmentsTimeFilter') !!}",
                method: "POST",
                data: {
                    filter_by:filter_by,
                    from:from,
                    to:to,
                    _token:_token,

                },
                success: function(result) {
                //    console.log(result)
                    $('#appointmentTable').DataTable().draw()
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

   $('#filter_by_hierarchy').on('change', function() {
        if ($('#filter_by_hierarchy').val() == 1 || $('#filter_by_hierarchy').val() == 2) {
            var _token = "{{ csrf_token() }}";
            var filter_by = 3;
            var value = '';
            if ($('#filter_by_hierarchy').val() == 1) {
                value = 'Call Center'
            } else {
                value = 'Broker'
            }
            $.ajax({
                url:"{!! route('get.AppointmentsTimeFilter') !!}",
                method: "POST",
                data: {
                    filter_by:filter_by,
                    from:value,
                    _token:_token,
                },
                success: function(result) {
                //    console.log(result)
                    $('#appointmentTable').DataTable().draw()
                },
                erorr: function(xhr){
                   console.log(xhr)
                }
            })
        }
   })

$(document).ready(function(){
    $('#feedbackForm').on('submit', function(e){
        // console.log('asd')
        e.preventDefault();
        var appointmentid = $('#appointmentidvalue').val();
        $.ajax({
            url: "/appointment-feedback/"+appointmentid,
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(result) {
                // console.log(result)
                $('#appointmentTable').DataTable().draw()
                toastr.success('Feedback Created', {timeOut:5000})
                $('#showFeedbackModal').modal('hide');
                // $('#comment').html('');
            },
            error: function(xhr){
                // console.log('error')
                console.log(xhr)
            }
        });
    });
});

$(document).ready(function(){
    $('body').on('click', '.image-button',function(){
            var id = $(this).attr('id')
            $('#filesModal').modal('show');
            $('.idd').text(id)
            $.ajax({
                url:"/feedback/"+id+"/files",
                method: "GET",
                data: {
                    id:id,
                },
                success: function(result) {
                    // console.log(result)
                    $('.carousel-inner').html(result)
                }
            });

    })
});
        $('body').on('click', '#feedbackHistory', function () {
            console.log('asd')
            var id = $(this).parent().parent().attr('id')
            $('#historyIdSecond').text(id)
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"/feedback/"+id+"/history",
                method: "GET",
                data: {
                    id:id,
                    _token:_token
                },
                success: function(result) {
                    setTimeout(function(){
                        $('#historyModalSecond').modal('show');
                        @unlessrole('Administrator')
                            $('.deleteFeedback').remove()
                        @endrole
                    }, 300);
                    $('#historyTableSecond > tbody').html(result)

                },
                error: function(xhr){
                    console.log(xhr)
                }
            })
        })


    // ============ Feedback modal ================
    $('#modalBody').css('height', '80vh');
    $('#modalBody').css('overflowY', 'scroll');
    $('#countFeedBacks').css('min-width', '8vh')
    //   $('#historyModal').css('overflow', 'scroll');
    $('body').on('click', '#feedback', function () {
        console.log('qwe')
        $('#fileUpload').fileinput('reset');
        var id = $(this).parent().parent().attr('id')
        $('#historyId').text(id)
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"/feedback/"+id+"/history",
            method: "GET",
            data: {
                id:id,
                _token:_token
            },
            success: function(result) {
                $('#countFeedBacks').click(function(){

                    $('#showFeedbackModal').modal('hide');
                        setTimeout(function(){
                            $('#historyModal').modal('show');
                        }, 300);

                        @unlessrole('Administrator')
                            $('.deleteFeedback').remove()
                        @endrole

                });
                // console.log(result)
                $('#historyTable > tbody').html(result)
                $('#comment').val("");

                $('#historyModal').on('hidden.bs.modal', function () {
                    $('#showFeedbackModal').modal('show');
                })
            },
            error: function(xhr){
                console.log(xhr)
            }
        });

        $.ajax({
                url:"/feedback/"+id+"/count",
                method: "GET",
                data: {
                    id:id,
                    _token:_token
                },
                success: function(result) {
                    // console.log(result)
                        var a =  result;
                    $('#countFeedBacks').on('mouseover',function(){
                        $('#countFeedBacks').html("<span style='color:white;'>"+a+"</span>")
                    });
                    $('#countFeedBacks').on('mouseleave',function(){
                        $('#countFeedBacks').text("History")
                    });
                },
                error: function(xhr){
                    console.log(xhr)
                }
        });

        $.ajax({
                url:"/feedback/"+id+"/get",
                method: "GET",
                data: {
                    id:id,
                    _token:_token
                },
                success: function(result) {
                    // console.log(result)

                    var unzuteilbar = result['unzuteilbar'];
                    var zeitlich_nicht_geschafft = result['zeitlich_nicht_geschafft'];
                    var berater_nicht_besucht = result['berater_nicht_besucht'];
                    var kunde_nicht_auffindbar = result['kunde_nicht_auffindbar'];
                    var falsche_adresse = result['falsche_adresse'];
                    var kunde_nicht_err = result['kunde_nicht_err'];
                    var nicht_zu_hause = result['nicht_zu_hause'];
                    var wollte_kein_termin = result['wollte_kein_termin'];
                    var verspatet_angemeldet = result['verspatet_angemeldet'];
                    var stattgefunden = result['stattgefunden'];
                    var konnte_nicht_beraten = result['konnte_nicht_beraten'];
                    var mjv = result['mjv'];
                    var behandlung = result['behandlung'];
                    var zu_alt = result['zu_alt'];
                    var socialfall = result['socialfall'];
                    var schulden_betreibung = result['schulden_betreibung'];
                    var negativ = result['negativ'];
                    var offen = result['offen'];
                    var positiv = result['positiv'];
                    var kvg_vvg = result['kvg_vvg'];
                    var nur_vvg = result['nur_vvg'];
                    var andere = result['andere'];
                    var comment = result['comment'];

                    // Insert data into modal
                    $('#appointmentid').html(id)
                    $('#appointmentidvalue').val(id)

                    var obj = {
                        "unzuteilbar": unzuteilbar,
                        "zeitlich_nicht_geschafft": zeitlich_nicht_geschafft,
                        "berater_nicht_besucht": berater_nicht_besucht,
                        "kunde_nicht_auffindbar": kunde_nicht_auffindbar,
                        "falsche_adresse": falsche_adresse,
                        "kunde_nicht_err": kunde_nicht_err,
                        "nicht_zu_hause": nicht_zu_hause,
                        "wollte_kein_termin": wollte_kein_termin,
                        "verspatet_angemeldet": verspatet_angemeldet,
                        "stattgefunden": stattgefunden,
                        "konnte_nicht_beraten": konnte_nicht_beraten,
                        "mjv": mjv,
                        "behandlung": behandlung,
                        "zu_alt": zu_alt,
                        "socialfall": socialfall,
                        "schulden_betreibung": schulden_betreibung,
                        "negativ": negativ,
                        "offen": offen,
                        "positiv": positiv,
                    };

                    var checkfeedback = false;
                    $.each( obj, function( key, value ) {
                    if(value==key){
                        $('#'+key).prop('checked',true)
                        checkfeedback = true;
                        if(key=='positiv'){
                            $('.positiv-label').removeClass('hidden-field')
                        }
                        if(key=='offen'){
                            $('.offenSecondDate').removeClass('hidden-field')
                        }
                    }
                    else {
                        $('.positiv-label').addClass('hidden-field')
                        $('.offenSecondDate').addClass('hidden-field')

                        $('#'+key).prop('checked',false)
                        $('#'+key).prop('disabled',true)
                    }
                    });
                    if(checkfeedback==false){
                        $('.positiv-label').addClass('hidden-field')
                        $('.offenSecondDate').addClass('hidden-field')
                        $('#kvg_vvg').val(null)
                        $('#nur_vvg').val(null)
                        $('#andere').val(null)
                        $('.form-control .custom-checkbox input[type=checkbox]').prop('disabled', false)
                        $('.form-control-positiv .custom-checkbox input[type=checkbox]').prop('disabled', false)
                        @hasrole('Agent')
                            $('#unzuteilbar').prop('disabled', true);
                        @endhasrole
                    }
                    // show modal
                    $('#showFeedbackModal').modal('show')

                    $('input[type=checkbox]').change(function(){
                        var getinput_id = $(this).attr('id');
                        if($(this).is(':checked')){
                            $('.form-control .custom-checkbox input[type=checkbox]').prop('disabled', true)
                            $('.form-control-positiv .custom-checkbox input[type=checkbox]').prop('disabled', true)
                            $(this).prop('disabled',false)
                            if((getinput_id=='konnte_nicht_beraten')||(getinput_id=='mjv')||(getinput_id=='behandlung')||(getinput_id=='zu_alt')||(getinput_id=='socialfall')||(getinput_id=='schulden_betreibung')||(getinput_id=='negativ')){
                                $('#stattgefunden').prop('checked',true)
                                $('#stattgefunden').prop('disabled',false)
                            }else if(getinput_id=='positiv'){
                                $('.positiv-label').removeClass('hidden-field')
                                $('#stattgefunden').prop('checked',true)
                                $('#stattgefunden').prop('disabled',false)
                            }
                            else if(getinput_id=='offen'){
                                $('.offenSecondDate').removeClass('hidden-field')
                                $('#stattgefunden').prop('checked',true)
                                $('#stattgefunden').prop('disabled',false)
                            }
                            else if(getinput_id=='stattgefunden'){
                                $('#konnte_nicht_beraten').prop('disabled',false)
                                $('#mjv').prop('disabled',false)
                                $('#behandlung').prop('disabled',false)
                                $('#zu_alt').prop('disabled',false)
                                $('#socialfall').prop('disabled',false)
                                $('#schulden_betreibung').prop('disabled',false)
                                $('#negativ').prop('disabled',false)
                                $('#offen').prop('disabled',false)
                                $('#positiv').prop('disabled',false)
                            }
                        }else {
                            $('.form-control .custom-checkbox input[type=checkbox]').prop('disabled', false)
                            $('.form-control-positiv .custom-checkbox input[type=checkbox]').prop('disabled', false)
                            if((getinput_id=='konnte_nicht_beraten')||(getinput_id=='mjv')||(getinput_id=='behandlung')||(getinput_id=='zu_alt')||(getinput_id=='socialfall')||(getinput_id=='schulden_betreibung')||(getinput_id=='negativ')){
                                $('#unzuteilbar').prop('disabled',true)
                                $('#zeitlich_nicht_geschafft').prop('disabled',true)
                                $('#berater_nicht_besucht').prop('disabled',true)
                                $('#kunde_nicht_auffindbar').prop('disabled',true)
                                $('#falsche_adresse').prop('disabled',true)
                                $('#kunde_nicht_err').prop('disabled',true)
                                $('#nicht_zu_hause').prop('disabled',true)
                                $('#wollte_kein_termin').prop('disabled',true)
                                $('#verspatet_angemeldet').prop('disabled',true)
                            }else if(getinput_id=='positiv'){
                                $('#unzuteilbar').prop('disabled',true)
                                $('#zeitlich_nicht_geschafft').prop('disabled',true)
                                $('#berater_nicht_besucht').prop('disabled',true)
                                $('#kunde_nicht_auffindbar').prop('disabled',true)
                                $('#falsche_adresse').prop('disabled',true)
                                $('#kunde_nicht_err').prop('disabled',true)
                                $('#nicht_zu_hause').prop('disabled',true)
                                $('#wollte_kein_termin').prop('disabled',true)
                                $('#verspatet_angemeldet').prop('disabled',true)
                                $('.positiv-label').addClass('hidden-field')
                                $('#kvg_vvg').val(null)
                                $('#nur_vvg').val(null)
                                $('#andere').val(null)
                            }else if(getinput_id=='offen'){
                                $('#unzuteilbar').prop('disabled',true)
                                $('#zeitlich_nicht_geschafft').prop('disabled',true)
                                $('#berater_nicht_besucht').prop('disabled',true)
                                $('#kunde_nicht_auffindbar').prop('disabled',true)
                                $('#falsche_adresse').prop('disabled',true)
                                $('#kunde_nicht_err').prop('disabled',true)
                                $('#nicht_zu_hause').prop('disabled',true)
                                $('#wollte_kein_termin').prop('disabled',true)
                                $('#verspatet_angemeldet').prop('disabled',true)
                                $('.offenSecondDate').addClass('hidden-field')
                                $('#selectSecondDate').val(null)
                                $('#timepicker').val(null)
                            }
                            else if(getinput_id=='stattgefunden'){
                                $('#konnte_nicht_beraten').prop('checked',false)
                                $('#mjv').prop('checked',false)
                                $('#behandlung').prop('checked',false)
                                $('#zu_alt').prop('checked',false)
                                $('#socialfall').prop('checked',false)
                                $('#schulden_betreibung').prop('checked',false)
                                $('#negativ').prop('checked',false)
                                $('#offen').prop('checked',false)
                                $('#positiv').prop('checked',false)
                            }
                        }
                    })
                    $('#showFeedbackModal').on('hidden.bs.modal', function () {
                        $('.form-control .custom-checkbox input[type=checkbox]').prop('disabled', false)
                        $('.form-control-positiv .custom-checkbox input[type=checkbox]').prop('disabled', false)
                    })
                },
                error: function(xhr){
                    console.log(xhr)
                }
            })
        });



            // ================ Files upload =================
        $("#fileUpload").fileinput({
        language: "de",
        theme: 'fa',
        allowedFileExtensions: ['jpg', 'png', 'jpeg', 'mp3', 'mp4'],
        overwriteInitial: false,
        maxFileSize:20000,
        maxFilesNum: 10,
        showPreview: true,
        fileActionSettings: {showUpload: false},
        showUpload: false,
        dropZoneEnabled: false,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        },
    })// ================ Files upload ================


  // ============ Delete Appointment ================
  $('body').on('click', '.deleteAppointment', function (e) {
            $('#deleteModal').modal('show')
            id = $(this).parent().parent().parent().attr('id')
            e.preventDefault()

        $('#deleteAppointment').click(function (e) {
            $.ajax({
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                url: '/appointment/'+id+'/delete',
                success: function (e) {
                    $('#appointmentTable').DataTable().draw()
                    $('#deleteModal').modal('hide')
                    toastr.success('Appointment Deleted', {timeOut:5000})
                    e.preventDefault()
                },
                error: function (xhr) { console.log(xhr); }
            })
            e.preventDefault()

        });// ============ Delete Appointment ================
    });

    $('body').on('click', '.deleteFeedback', function(e){
        $('#deleteFeedbackModal').modal('show');
        id = $(this).attr('id')
        staticId = $('#historyId').text();

        $('#deleteFeedback').off("click");
        $('#deleteFeedback').click(function(e){
            //// first ajax
            $.ajax({
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                url: '/appointment/'+id+'/feedback/delete',
                success: function (result) {
                    toastr.success(result, {timeOut:5000})
                    $('#deleteFeedbackModal').modal('hide')
                    // Second ajax
                    $.ajax({
                        url:"/feedback/"+staticId+"/history",
                        method: "GET",
                        data: {
                            id:staticId,
                        },
                        success: function(result) {

                            $('#historyTable > tbody').html(result)
                        },

                    });/// end second ajax
                },
            });/// end first ajax
        });
    });

    ///// Feedback Slider ///////

    $('.carousel').carousel({
            interval: false
    })

    /////////Clear Fiter Appointments
    $('body').on('click', '#clearFilter-Appointments', function (){
        $('#appointmentTable').DataTable().draw()
    })

 // Select Date ---- Date Picker ----
    $(function() {
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        $('#selectSecondDate').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minDate:today,
            // minYear: parseInt(moment().format('YYYY')),
            // maxYear: parseInt(moment().format('YYYY'))+10,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        $('#timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            minTime: '7',
            maxTime: '22',
            defaultTime: '10',
            startTime: '1:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            use24hours: true
        });
    });// End Select Date ---- Date Picker ----

</script>
@endsection

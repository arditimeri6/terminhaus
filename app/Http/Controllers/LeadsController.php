<?php

namespace App\Http\Controllers;

use File;
use Excel;
use Response;
use App\Lead;
use App\User;
use Carbon\Carbon;
use App\LeadLanguage;
use Illuminate\Http\Request;
use App\AppointmentTimeFilter;
use App\Http\Requests\LeadRequest;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\QueryDataTable;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TimeFilterRequest;
use PHPExcel_Style_Border;

class LeadsController extends Controller
{
    public function index() {
        $directors = User::role('Call Center Admin')->get();
        return view('leads.index', ['directors' => $directors]);
    }

    public function create() {
        return view('leads.create');
    }

    public function LeadsTimeFilter(TimeFilterRequest $request){
        $filter_by = $request['filter_by'];
        $from = $request['from'];
        $to = $request['to'];
        $appointmentTime = AppointmentTimeFilter::first()->update([
            'from' => $from,
            'to' => $to,
            'filter_by' => $filter_by,
        ]);
    }

    public function getLead() {

        $leadsTime = AppointmentTimeFilter::first();
        $from = $leadsTime->from;
        $to = $leadsTime->to;
        $filter = $leadsTime->filter_by;
        $filter_by = '';
        $query = '';
        if($filter==1){
            $filter_by = 'date';
        }elseif ($filter==2) {
            $filter_by = 'created_at_filter';
        }

        if(Auth::user()->hasRole('Administrator')){
            $query = DB::table('leads')
            ->leftjoin('leads_status as status', 'leads.id', '=', 'status.lead_id')
            ->leftJoin('users', 'leads.assigned_to', '=', 'users.id')
            ->leftJoin('users as userAssigned', 'leads.assigned_from', '=', 'userAssigned.id')
            ->leftJoin('users as direktors', 'leads.leads_direktor', '=', 'direktors.id')
            ->leftJoin('users as createdBy', 'leads.user_id', '=', 'createdBy.id')
            ->select('leads.*', 'status.call_status as callstatus', 'status.qc_status as qcstatus', 'users.email as user', 'userAssigned.email as userfrom', 'direktors.company_name as usercompany', 'createdBy.email as createdByUser');

            if($leadsTime->from && $leadsTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                ->whereDate($filter_by, '<=', $to);
                $leadsTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }
        }elseif(Auth::user()->hasRole('Quality Controll')){
            $qualityControll = DB::table('users')->where('id', '=', Auth::user()->id)->first();

            $query = DB::table('leads')
            ->leftjoin('leads_status as status', 'leads.id', '=', 'status.lead_id')
            ->leftJoin('users', 'leads.assigned_to', '=', 'users.id')
            ->leftJoin('users as direktors', 'leads.leads_direktor', '=', 'direktors.id')
            ->leftJoin('users as createdBy', 'leads.user_id', '=', 'createdBy.id')
            ->select('leads.*', 'status.call_status as callstatus', 'status.qc_status as qcstatus', 'users.email as user', 'direktors.company_name as usercompany', 'createdBy.email as createdByUser')
            ->where(function($query) use($qualityControll) {
                $query->where('user_id', Auth::user()->id)
                ->orWhere('assigned_to', Auth::user()->id)
                ->orWhere('leads_direktor', Auth::user()->id);

                if($qualityControll->quality_responsibility == 'all'){
                    $result = DB::table('users')->where('direktor', '=', $qualityControll->direktor)->pluck('id');
                    $query->orWhere('leads_direktor', $qualityControll->direktor);
                    $query->orWhereIn('leads_direktor', $result);
                } else {
                    if ($qualityControll->quality_responsibility != null) {
                        $query->orWhere('leads_direktor', $qualityControll->quality_responsibility);
                    }
                }
            });
            if($leadsTime->from && $leadsTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                ->whereDate($filter_by, '<=', $to);
                $leadsTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }
        } elseif(Auth::user()->hasRole('Call Center Admin|Berater Admin')) {
            $getUserCountry = DB::table('users')
                ->where('id', Auth::user()->id)
                ->get()->pluck('country');

            $getAllCallCenter = DB::table('users')
            ->where('country', $getUserCountry)
            ->get()->pluck('id');

            $query = DB::table('leads')
            ->leftjoin('leads_status as status', 'leads.id', '=', 'status.lead_id')
            ->leftJoin('users', 'leads.assigned_to', '=', 'users.id')
            ->leftJoin('users as userAssigned', 'leads.assigned_from', '=', 'userAssigned.id')
            ->leftJoin('users as direktors', 'leads.leads_direktor', '=', 'direktors.id')
            ->leftJoin('users as createdBy', 'leads.user_id', '=', 'createdBy.id')
            ->select('leads.*', 'status.call_status as callstatus', 'status.qc_status as qcstatus', 'users.email as user', 'userAssigned.email as userfrom', 'direktors.company_name as usercompany', 'createdBy.email as createdByUser')
            ->where(function ($query) use ($getAllCallCenter){
                $query->orWhereIn('leads.assigned_to', $getAllCallCenter)
                ->orWhereIn('leads.leads_direktor', $getAllCallCenter)
                ->orWhereIn('leads.user_id', $getAllCallCenter);

            });
            if($leadsTime->from && $leadsTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                ->whereDate($filter_by, '<=', $to);
                $leadsTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }

        } elseif(Auth::user()->hasRole('Call Center Direktor|Broker Direktor')) {

            $getDirektorsByCreated = DB::table('users')
            ->where('created_by', Auth::user()->id)
            ->get()->pluck('id');

            $getDirektorsByDirektor = DB::table('users')
            ->where('direktor', Auth::user()->id)
            ->get()->pluck('id');

            $secondPartner = DB::table('director_partners')
                ->where('first_partner', Auth::user()->id)
                ->get()->pluck('second_partner');

            $secondPartnerUsers = '';
            if ($secondPartner->count() != 0) {
                $secondPartnerUsers = DB::table('users')
                    ->where('created_by', $secondPartner)
                    ->orWhere('direktor', $secondPartner)
                    ->get()->pluck('id');
            }

            $query = DB::table('leads')
            ->leftjoin('leads_status as status', 'leads.id', '=', 'status.lead_id')
            ->leftJoin('users', 'leads.assigned_to', '=', 'users.id')
            ->leftJoin('users as direktors', 'leads.leads_direktor', '=', 'direktors.id')
            ->leftJoin('users as createdBy', 'leads.user_id', '=', 'createdBy.id')
            ->select('leads.*', 'status.call_status as callstatus', 'status.qc_status as qcstatus', 'users.email as user', 'direktors.company_name as usercompany', 'createdBy.email as createdByUser')
            ->where(function ($query) use ($getDirektorsByCreated, $getDirektorsByDirektor, $secondPartner, $secondPartnerUsers) {
                $query->where('leads.user_id', Auth::user()->id)
                ->orWhere('assigned_to', Auth::user()->id)
                ->orWhere('leads_direktor', Auth::user()->id)
                ->orWhereIn('leads.assigned_to', $getDirektorsByCreated)
                ->orWhereIn('leads.leads_direktor', $getDirektorsByCreated)
                ->orWhereIn('leads.user_id', $getDirektorsByCreated)
                ->orWhereIn('leads.assigned_to', $getDirektorsByDirektor)
                ->orWhereIn('leads.leads_direktor', $getDirektorsByDirektor)
                ->orWhereIn('leads.user_id', $getDirektorsByDirektor);
                if ($secondPartner->count() != 0) {
                    $query->orWhere('leads.leads_direktor', $secondPartner)
                    ->orWhere('leads.assigned_to', $secondPartner)
                    ->orWhere('leads.user_id', $secondPartner)
                    ->orWhereIn('leads.assigned_to', $secondPartnerUsers)
                    ->orWhereIn('leads.leads_direktor', $secondPartnerUsers)
                    ->orWhereIn('leads.user_id', $secondPartnerUsers);
                }
            });
            if($leadsTime->from && $leadsTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                ->whereDate($filter_by, '<=', $to);
                $leadsTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }

        } else {

            $getCreatedBy = DB::table('users')
                ->where('created_by', Auth::user()->id)
                ->get()->pluck('id');

            $query = DB::table('leads')
            ->leftjoin('leads_status as status', 'leads.id', '=', 'status.lead_id')
            ->leftJoin('users', 'leads.assigned_to', '=', 'users.id')
            ->leftJoin('users as direktors', 'leads.leads_direktor', '=', 'direktors.id')
            ->leftJoin('users as createdBy', 'leads.user_id', '=', 'createdBy.id')
            ->select('leads.*', 'status.call_status as callstatus', 'status.qc_status as qcstatus', 'users.email as user', 'direktors.company_name as usercompany', 'createdBy.email as createdByUser')
            ->where(function($query) use ($getCreatedBy){
                $query->where('leads.user_id', Auth::user()->id)
                ->orWhereIn('leads.user_id', $getCreatedBy)
                ->orWhere('assigned_to', Auth::user()->id)
                ->orWhere('leads_direktor', Auth::user()->id);
            });
            if($leadsTime->from && $leadsTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                ->whereDate($filter_by, '<=', $to);
                $leadsTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }
        }

        if (Auth::user()->hasRole('Administrator')) {
            return (new QueryDataTable($query))
            ->editColumn('user', '@if($assigned_to == null) @else {{$user}} @endif')
            ->editColumn('first_name', '{{ $first_name . " " . $last_name . " " . $street . " " . $post_code}}')
            ->editColumn('callstatus', '{{ $callstatus . " " . $qcstatus}}')
            ->addColumn('status', '<button title="Status" class="btn btn-sm btn-outline-secondary status-modal">
                    <i class="far fa-window-restore fa-lg"></i>
                </button>')
            ->addColumn('actions', '<div class="row"><a title="Edit" target="_blank" class="btn btn-sm btn-outline-secondary mr-2" href="{{ route("edit.lead",$id) }}">
                    <i class="fa fa-edit fa-lg"></i>
                </a>
                <button title="Delete" class="btn btn-sm btn-outline-secondary deleteLead">
                    <i class="fas fa-trash-alt fa-lg"></i>
                </button></div>'
            )
            ->addColumn('check', '<div class="custom-control custom-checkbox under-checkbox"><input type="checkbox" class="check custom-control-input" value="{{ $id }}" id="checkboxlead{{ $id }}" name="checkAppointment"><label class=" custom-control-label checkbox-inline costumcheckbox1" for="checkboxlead{{ $id }}"></label></div>')
            ->setRowId('{{$id}}')
            ->rawColumns(['actions', 'check', 'status'])
            ->toJson();
        }else{
            return (new QueryDataTable($query))
            ->editColumn('first_name', '{{ $first_name . " " . $last_name . " " . $street . " " . $post_code}}')
            ->editColumn('callstatus', '{{ $callstatus . " " . $qcstatus}}')
            ->addColumn('status', '@if(Auth::user()->id == $assigned_to)<button title="Status" class="btn btn-sm btn-outline-secondary status-modal">
                    <i class="far fa-window-restore fa-lg"></i>
                </button> @endif')
            ->addColumn('actions', '@if(Auth::user()->hasRole("Call Center Admin|Call Center Direktor|Agent Team Leader|Quality Controll|Berater Admin|Broker Direktor|Berater Team Leader|Berater"))
                    <a title="Edit" target="_blank" class="btn btn-sm btn-outline-secondary" href="{{ route("edit.lead",$id) }} ">
                        <i class="fa fa-edit fa-lg"></i>
                    </a>
                @elseif (Auth::user()->hasRole("Agent") && Auth::user()->id == $assigned_to)
                    <a title="Edit" target="_blank" class="btn btn-sm btn-outline-secondary" href="{{ route("edit.lead",$id) }} ">
                        <i class="fa fa-edit fa-lg"></i>
                    </a>
                @endif'
            )
            ->addColumn('check', '<div class="custom-control custom-checkbox under-checkbox"><input type="checkbox" class="check custom-control-input" value="{{ $id }}" id="checkboxlead{{ $id }}" name="checkAppointment"><label class=" custom-control-label checkbox-inline costumcheckbox1" for="checkboxlead{{ $id }}"></label></div>')
            ->setRowId('{{$id}}')
            ->rawColumns(['actions', 'check', 'status'])
            ->toJson();
        }
    }

    public function store(LeadRequest $request) {
        // dd($request->all());
        $lead = Lead::create([
            'kunden_type' => $request['kunden_type'],
            'salutation' => $request['salutation'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'year' => $request['year'],
            'mobile_number' => $request['mobile_number'],
            'house_number' => $request['house_number'],
            'street' => $request['street'],
            'post_code' => $request['post_code'],
            'place' => $request['place'],
            'canton' => $request['canton'],
            'company_name' => $request['company_name'],
            'autoversicherung' => $request['autoversicherung'],
            'hausrat_privathaftpflicht' => $request['hausrat_privathaftpflicht'],
            'lebensversicherung' => $request['lebensversicherung'],
            'rechtsschutzversicherung' => $request['rechtsschutzversicherung'],
            'krankenversicherung' => $request['krankenversicherung'],
            'vertrag_seit_wann' => $request['vertrag_seit_wann'],
            'letzte_optimierung' => $request['letzte_optimierung'],
            'anzahl_personen' => $request['anzahl_personen'],
            'anruf_erwünscht' => $request['anruf_erwunscht'],
            'ereichbar' => $request['ereichbar'],
            'comment' => $request['comment'],
            'user_id' => Auth::user()->id,
            'assigned_to' => null,
            'leads_direktor' => Auth::user()->direktor,
            'created_at_filter' => Carbon::now()->format('Y-m-d'),
        ]);
        if ($lead) {
            if ($request['language']) {
                $count = count($request['language']);
                for ($i=0; $i < $count; $i++) {
                    LeadLanguage::create([
                        'language' => $request['language'][$i],
                        'lead_id' => $lead->id,
                    ]);
                };
            }
            return redirect('/leads')->with('successLead', 'The Lead was created successfully');
        }
        return redirect('/createLead')->with('error', 'There was an error while creating the Lead');
    }

    public function edit(Lead $lead){
        $username = User::where('id', $lead->user_id)->select('first_name','last_name')->first();

        $multipleComments = DB::table('multiple_comment_leads')
        ->where('leads_id', $lead->id)
        ->leftJoin('users', 'users.id', '=', 'multiple_comment_leads.user_id')
        ->select('multiple_comment_leads.*','users.first_name as name', 'users.last_name as lastname')
        ->get();

        $languages = LeadLanguage::where('lead_id', $lead->id)->get();
        return view('leads.edit',['lead'=>$lead,'languages'=>$languages, 'username' => $username, 'multipleComments' => $multipleComments]);
    }

    public function update(LeadRequest $request, Lead $lead){

        if(Auth::user()->hasRole('Administrator|Call Center Admin|Berater Admin|Call Center Direktor|Broker Direktor|Quality Controll')){
            $lead->update([
                'kunden_type' => $request['kunden_type'],
                'salutation' => $request['salutation'],
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'year' => $request['year'],
                'mobile_number' => $request['mobile_number'],
                'house_number' => $request['house_number'],
                'street' => $request['street'],
                'post_code' => $request['post_code'],
                'place' => $request['place'],
                'canton' => $request['canton'],
                'company_name' => $request['company_name'],
                'autoversicherung' => $request['autoversicherung'],
                'hausrat_privathaftpflicht' => $request['hausrat_privathaftpflicht'],
                'lebensversicherung' => $request['lebensversicherung'],
                'rechtsschutzversicherung' => $request['rechtsschutzversicherung'],
                'krankenversicherung' => $request['krankenversicherung'],
                'vertrag_seit_wann' => $request['vertrag_seit_wann'],
                'letzte_optimierung' => $request['letzte_optimierung'],
                'anzahl_personen' => $request['anzahl_personen'],
                'anruf_erwünscht' => $request['anruf_erwunscht'],
                'ereichbar' => $request['ereichbar'],
                'comment' => $request['comment'],
                'status' => ($request->has('status')) ? $request['status'] : null ,
                'qccomment_access_cc' =>$request->has('commentAccessCC') ? 1 : 0,
                'qccomment_access_br' =>$request->has('commentAccessBr') ? 1 : 0,
                'created_at_filter' => Carbon::now()->format('Y-m-d'),
            ]);

            if($request['qcComment'] != null){
                $multipleComment = DB::table('multiple_comment_leads')->insert([
                    'comment' => $request['qcComment'],
                    'user_id' => Auth::user()->id,
                    'leads_id' => $lead->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            if ($lead) {
                if ($request['language']) {
                    LeadLanguage::where('lead_id',$lead->id)->delete();
                    $count = count($request['language']);
                    for ($i=0; $i < $count; $i++) {
                        LeadLanguage::create([
                            'language' => $request['language'][$i],
                            'lead_id' => $lead->id,
                        ]);
                    };
                }
                return redirect('/leads')->with('successLead', 'The Lead was updated successfully');
            }
            return redirect('/leads')->with('error', 'There was an error while updating the Lead');
        } else {

        }
    }

    public function showStatusLeads(Lead $lead){
        $status = DB::table('leads_status')->where('lead_id', $lead->id)->first();

        if(Auth::user()->hasRole('Administrator|Call Center Admin|Berater Admin|Call Center Direktor|Broker Direktor|Agent Team Leader|Berater Team Leader|Agent|Berater')){

            $Nicht = '';
            $Terminiert = '';
            $Falsche = '';
            $Nichtüberzeugt = '';
            $Behandlung = '';
            $MJV = '';
            if($status != null){

                if (($status->call_status == 'Terminiert')) {
                    $Terminiert = 'selected';

                }elseif($status->call_status == 'Nicht erreicht'){
                    $Nicht = 'selected';

                }elseif($status->call_status == 'Falsche angaben'){
                    $Falsche = 'selected';

                }elseif($status->call_status == 'Nicht überzeugt'){
                    $Nichtüberzeugt = 'selected';

                }elseif($status->call_status == 'Behandlung'){
                    $Behandlung = 'selected';

                }elseif($status->call_status == 'MJV'){
                    $MJV = 'selected';
                }

            }
            $table = '';
            $table .= '<option value=""> Select Status </option>'
            .'<option value="Terminiert" '.$Terminiert.'> Terminiert </option>'
            .'<option value="Nicht erreicht" '.$Nicht.'> Nicht erreicht </option>'
            .'<option value="Falsche angaben" '.$Falsche.'> Falsche angaben </option>'
            .'<option value="Nicht überzeugt" '.$Nichtüberzeugt.'> Nicht überzeugt </option>'
            .'<option value="Behandlung" '.$Behandlung.'> Behandlung </option>'
            .'<option value="MJV" '.$MJV.'> MJV </option>';

        }
        else if(Auth::user()->hasRole('Quality Controll')){
            $AngenommenJA = '';
            $AngenommenNEIN = '';
            $Abgelehnt = '';

            if($status != null){

                if (($status->qc_status == 'Angenommen-JA')) {
                    $AngenommenJA = 'selected';

                }elseif($status->qc_status == 'Angenommen-NEIN'){
                    $AngenommenNEIN = 'selected';

                }elseif($status->qc_status == 'Abgelehnt'){
                    $Abgelehnt = 'selected';
                }
            }

            $table = '';
            $table .= '<option value=""> Select Status </option>'
            .'<option value="Angenommen-JA"  '.$AngenommenJA.'> Angenommen-JA </option>'
            .'<option value="Angenommen-NEIN" '.$AngenommenNEIN.'> Angenommen-NEIN </option>'
            .'<option value="Abgelehnt" '.$Abgelehnt.'> Abgelehnt </option>';
        }
        echo $table;
    }

    public function storeStatusLeads(Request $request , Lead $lead){
        $countStatuses = DB::table('leads_status')->where('lead_id', $lead->id)->count();
        $statuses = DB::table('leads_status')->where('lead_id', $lead->id)->first();
            if(Auth::user()->hasRole('Administrator|Call Center Admin|Berater Admin|Call Center Direktor|Broker Direktor|Agent Team Leader|Berater Team Leader|Agent|Berater')){
                if($countStatuses == 0){
                    $leadStatus = DB::table('leads_status')->insert([
                        'call_status' => $request['data'],
                        'lead_id' => $lead->id,
                        'agent_id' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    $name = 'Created Successfully';
                }
                else{
                    $leadStatus = DB::table('leads_status')->where('lead_id', $lead->id)->update([
                        'call_status' => $request['data'],
                        'agent_id' => Auth::user()->id,
                        'updated_at' => Carbon::now()
                    ]);
                    $name = 'Updated Successfully';

                }
            }
            else{
                if($statuses->qc_status == null){
                    $name = 'Created Successfully';
                }
                else{
                    $name = 'Updated Successfully';
                }
                $leadStatus = DB::table('leads_status')->where('lead_id', $lead->id)->update([
                    'qc_status' => $request['data'],
                    'qc_id' => Auth::user()->id,
                    'updated_at' => Carbon::now()
                ]);
            }
        echo $name;

    }

    public function single_export($id){
        $leads = preg_split("/\,/", $id);
        $files = [];
        foreach($leads as $lead_id){
            $lead = Lead::where('id',  $lead_id)->first();
            $query = LeadLanguage::where('lead_id',$lead->id)->get();

            $leadlanguage = [];
            foreach ($query as $key => $language) {
                $leadlanguage[] = $language->language;
            }
            $lang = implode(",",$leadlanguage);

            $callAgent = User::where('id', $lead->user_id)->first();

            (array)$export_row = null;
            $idexcel = $lead->id;
            $export_row[] = array('ID:', $lead->id, 'LEADFORMULAR', '', '', '');
            $export_row[] = array('Call datum:', Carbon::parse($lead->created_at_filter)->format('d/m/Y'), 'Callagent:', $callAgent->email, '');
            $export_row[] = array('Anrede', $lead->salutation, '', '', '');
            $export_row[] = array('Name, Vorname', $lead->first_name . " " .$lead->last_name, '', '', '');
            $export_row[] = array('Strasse', $lead->street, '', 'Mobile Nummer', $lead->mobile_number);
            $export_row[] = array('PLZ/Ort', (int)$lead->post_code, '', 'Haus Nummer', $lead->house_number);
            $export_row[] = array('Kanton', $lead->canton, '', 'Sprache', $lang);
            $export_row[] = array('Jahrgang', '', '', $lead->year, '');
            $export_row[] = array('Autoversicherung', '', '', $lead->autoversicherung, '');
            $export_row[] = array('Hausrat&Privathaftpflicht', '', '', $lead->hausrat_privathaftpflicht, '');
            $export_row[] = array('Lebensversicherung', '', '', $lead->lebensversicherung, '');
            $export_row[] = array('Rechtsschutzversicherung', '', '', $lead->rechtsschutzversicherung, '');
            $export_row[] = array('Krankenversicherung', '', '', $lead->krankenversicherung, '');
            $export_row[] = array('Vertrag Seit wann?', '', '', $lead->vertrag_seit_wann, '');
            $export_row[] = array('Letzte Optimierung ?', '', '', $lead->letzte_optimierung, '');
            $export_row[] = array('Anzahl Personen ?', '', '', $lead->anzahl_personen, '');
            $export_row[] = array('Bewertung  1-10', '', '', '', '');
            $export_row[] = array('Anruf erwünscht?', '', '', '', '');
            $export_row[] = array('Ereichbar ?', '', '', '', '');
            Excel::create('ID-'.$idexcel, function($excel) use ($export_row,$idexcel,$lead){
            $excel->setTitle('ID');
            $excel->sheet('ID-'.$idexcel, function($sheet) use ($export_row,$lead){
                $sheet->mergeCells('C1:D1');
                $sheet->mergeCells('D2:E2');
                $sheet->mergeCells('B4:C4');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');
                $sheet->mergeCells('E5:F5');
                $sheet->mergeCells('E6:F6');
                $sheet->mergeCells('E7:F7');
                $sheet->mergeCells('A20:B20');
                $sheet->mergeCells('A21:F24');

                $sheet->mergeCells('A8:C8');
                $sheet->mergeCells('D8:F8');
                $sheet->mergeCells('A9:C9');
                $sheet->mergeCells('D9:F9');
                $sheet->mergeCells('A10:C10');
                $sheet->mergeCells('D10:F10');
                $sheet->mergeCells('A11:C11');
                $sheet->mergeCells('D11:F11');
                $sheet->mergeCells('A12:C12');
                $sheet->mergeCells('D12:F12');
                $sheet->mergeCells('A13:C13');
                $sheet->mergeCells('D13:F13');
                $sheet->mergeCells('A14:C14');
                $sheet->mergeCells('D14:F14');
                $sheet->mergeCells('A15:C15');
                $sheet->mergeCells('D15:F15');
                $sheet->mergeCells('A16:C16');
                $sheet->mergeCells('D16:F16');
                $sheet->mergeCells('A17:C17');
                $sheet->mergeCells('D17:F17');
                $sheet->mergeCells('A18:C18');
                $sheet->mergeCells('D18:F18');
                $sheet->mergeCells('A19:C19');
                $sheet->mergeCells('D19:F19');

                $sheet->setCellValue('A20', 'Kommentare');
                $sheet->setCellValue('A21', $lead->comment);
                $sheet->cell('A1', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(12);
                    $cells->setalignment('right');
                });
                $sheet->cell('A21', function ($cells) {
                    $cells->setValignment('top');
                });
                $sheet->cell('B1', function ($cells) {
                    $cells->setalignment('left');
                });
                $sheet->cell('C1', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(13);
                    $cells->setalignment('center');
                });
                $sheet->cell('C2', function ($cells) {
                    $cells->setalignment('right');
                });
                $sheet->cell('C3', function ($cells) {
                    $cells->setalignment('right');
                });
                $sheet->cell('A3', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cell('A20', function ($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->cell('A8', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A9', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A10', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A11', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A12', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A13', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A14', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A15', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A16', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A17', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A18', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });
                $sheet->cell('A19', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                    $cells->setFontColor('#28627F');
                });



                $sheet->setWidth(array(
                    'A'     =>  17,
                    'B'     =>  20,
                    'C'     =>  20,
                    'D'     =>  22,
                    'E'     =>  17,
                    'F'     =>  23,
                ));
                $range="A1:F1";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('double','double','double','double');
                });
                $range="A7:F7";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('none','double','double','double');
                });
                $range="A20:F20";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('dotted','dotted','dotted','dotted');
                });
                $range="A8";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B8";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C8";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D8";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E8";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F8";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A9";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B9";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C9";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D9";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E9";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F9";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A10";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B10";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C10";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D10";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E10";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F10";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A11";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B11";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C11";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D11";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E11";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F11";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A12";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B12";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C12";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D12";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E12";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F12";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A13";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B13";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C13";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D13";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E13";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F13";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A14";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B14";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C14";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D14";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E14";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F14";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A15";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B15";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C15";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D15";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E15";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F15";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A16";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B16";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C16";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D16";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E16";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F16";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A17";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="B17";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C17";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D17";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="E17";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F17";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A18";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thick','thin','thin','thin');
                });
                $range="B18";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C18";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D18";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thick','thin','thin','thin');
                });
                $range="E18";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F18";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="A19";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thick','thin','thick','thin');
                });
                $range="B19";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="C19";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="D19";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thick','thin','thick','thin');
                });
                $range="E19";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $range="F19";
                $sheet->cells($range, function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });

                $range="A2:F2";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('none','none','thin','thin');
                });
                $range="A1:F24";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('thick','thick','thick','thick');
                });
                $range="G5:H24";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('none','none','none','thick');
                });
                $range="A25:F25";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('thick','none','none','none');
                });
            $sheet->fromArray($export_row, null, 'A1', false, false);
            });
            })->store('xlsx');
            $files[] = glob('../storage/exports/ID-'.$idexcel.'.xlsx');
        }
        $namefile = Carbon::now()->format('d-m-Y');
        if (count($files) == 1) {
            return response()->download(storage_path($files[0][0]))->deleteFileAfterSend(true);
        } else {
            Zipper::make('../storage/app/public/Export-'. $namefile .'.zip')->add($files)->close();
            foreach($files as $file){
                File::delete($file[0]);
            }
            return Response::download('../storage/app/public/Export-'. $namefile .'.zip')->deleteFileAfterSend(true);
        }
    }

    public function exportall_lead() {
        (array)$row_all = null;
        $row_all[] = array('ID','Call Datum','Vorname','Nachname','Strasse','PLZ/Ort','Kanton','Mobile Nummer','Haus Nummer','Sprache','Autoversicherung','Hausrat&Privathaftpflicht','Lebensversicherung','Rechtsschutzversicherung','Krankenversicherung','Vertrag Seit wann','Letzte Optimierung','Anzahl Personen','Anruf erwünscht','Ereichbar','CC','Call Agent','QC Status','Call Status','Zugewiesen an');

        $getAdminByCreated = DB::table('users')
        ->where('created_by', Auth::user()->id)
        ->get()->pluck('id');

        $getDirektorByCreated = DB::table('users')
        ->whereIn('created_by', $getAdminByCreated)
        ->get()->pluck('id');

        $getAdminByDirektor = DB::table('users')
        ->where('direktor', Auth::user()->id)
        ->get()->pluck('id');

        $getDirektorByDirektor = DB::table('users')
        ->whereIn('direktor', $getAdminByDirektor)
        ->get()->pluck('id');

        if (Auth::user()->hasRole('Administrator')) {
            $leads = Lead::all();
        } else {
            $leads = Lead::where('leads.user_id', Auth::user()->id)
            ->orWhere('leads.assigned_to', Auth::user()->id)
            ->orWhere('leads.leads_direktor', Auth::user()->id)
            ->orWhereIn('leads.assigned_to', $getAdminByCreated)
            ->orWhereIn('leads.leads_direktor', $getAdminByCreated)
            ->orWhereIn('leads.user_id', $getAdminByCreated)
            ->orWhereIn('leads.assigned_to', $getAdminByDirektor)
            ->orWhereIn('leads.leads_direktor', $getAdminByDirektor)
            ->orWhereIn('leads.user_id', $getAdminByDirektor)
            ->orWhereIn('leads.assigned_to', $getDirektorByCreated)
            ->orWhereIn('leads.leads_direktor', $getDirektorByCreated)
            ->orWhereIn('leads.user_id', $getDirektorByCreated)
            ->orWhereIn('leads.assigned_to', $getDirektorByDirektor)
            ->orWhereIn('leads.leads_direktor', $getDirektorByDirektor)
            ->orWhereIn('leads.user_id', $getDirektorByDirektor)->get();
        }
        foreach($leads as $lead){
            $assigned = null;
            if($lead->assigned_to != null) {
                 $assigned_to = User::where('id', $lead->assigned_to)->first();
                 $assigned = $assigned_to->email;
            }
            $query = LeadLanguage::where('lead_id',$lead->id)->get();
            $leadlanguage = [];
            foreach ($query as $key => $language) {
                $leadlanguage[] = $language->language;
            }

            // $company = User::where('id', $lead->leads_direktor)->first();
            $createdBy = User::where('id', $lead->user_id)->first();

            $leads_status_qc = DB::table('leads_status')->where('lead_id', $lead->id)->first();
            $qc_status = '';
            if ($leads_status_qc) {
                $qc_status = $leads_status_qc->qc_status;
            }
            $leads_status_call = DB::table('leads_status')->where('lead_id', $lead->id)->first();
            $call_status = '';
            if ($leads_status_call) {
                $call_status = $leads_status_call->call_status;
            }

            $lang = implode(",",$leadlanguage);
            $row_all[] = array(
                $lead->id,
                Carbon::parse($lead->created_at_filter)->format('d/m/Y'),
                $lead->first_name,
                $lead->last_name,
                $lead->street,
                $lead->post_code . " " . $lead->place,
                $lead->canton,
                $lead->mobile_number,
                $lead->house_number,
                $lang,
                $lead->autoversicherung,
                $lead->hausrat_privathaftpflicht,
                $lead->lebensversicherung,
                $lead->rechtsschutzversicherung,
                $lead->krankenversicherung,
                $lead->vertrag_seit_wann,
                $lead->letzte_optimierung,
                $lead->anzahl_personen,
                $lead->anruf_erwünscht,
                $lead->ereichbar,
                $createdBy->company_name,
                $createdBy->email,
                $qc_status,
                $call_status,
                $assigned
            );
        }
        Excel::create('Export All', function($excel) use ($row_all){
            $excel->setTitle('Export All');

            $excel->sheet('Export All', function($sheet) use ($row_all){
                $sheet->cell('A1:Y1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cell('S1:S1000', function ($cells) {
                    $cells->setBackground('#e2efda');
                });
                $sheet->cell('T1:T1000', function ($cells) {
                    $cells->setBackground('#e2efda');
                });
                $styleArray = array(
                    'borders' => array(
                      'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                    )
                  );
                $sheet->getStyle('A1:Y1000')->applyFromArray($styleArray);
                $sheet->fromArray($row_all, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    public function searchLeadAgents(Request $request){
        $value = $request['value'];
        $direktors = DB::table('users')->where('direktor', $value)->get()->pluck('id');
        $data = DB::table('users')
            ->where('created_by', $value)
            ->orWhere('direktor', $value)
            ->orWhereIn('created_by', $direktors)
            ->orWhereIn('direktor', $direktors)
            ->get();
        $output = '<option value=""></option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->first_name. ' ' . $row->last_name.'</option>';
        }
        echo $output;
    }

    public function assignTo(Request $request){
        foreach ($request['selectBoxArray'] as $leads) {
            DB::table('leads')->where('id', $leads)->update([
                'assigned_to' => ($request['agent'] == null)? $request['direktor'] : $request['agent'],
                'assigned_from' =>  Auth::user()->id,
                'leads_direktor' => $request['direktor']
            ]);
        }
        echo 'success';
    }

    public function destroy(Lead $lead){
        $lead->delete();
    }

    public function commentUpdate(Request $request, $id){
        $commentDelete = DB::table('multiple_comment_leads')->where('id', $id)->update([
            'comment' => $request['newValue'],
            'updated_at' => Carbon::now()
        ]);
        if($commentDelete){
            $getDate = DB::table('multiple_comment_leads')->where('id', $id)->pluck('updated_at')->first();
            echo $getDate;
        }
    }

    public function commentDelete($id){
        $commentDelete = DB::table('multiple_comment_leads')->where('id', $id)->delete();
    }
}

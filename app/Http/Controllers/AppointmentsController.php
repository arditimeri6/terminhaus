<?php

namespace App\Http\Controllers;

use File;
use Excel;
use App\User;
use Response;
use Carbon\Carbon;
use App\Appointment;
use App\AppointmentMember;
use Illuminate\Http\Request;
use App\AppointmentTimeFilter;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Chumper\Zipper\Facades\Zipper;
use Yajra\DataTables\QueryDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TimeFilterRequest;
use App\Http\Requests\AppointmentRequest;
use App\Http\Requests\AppointmentFeedbackRequest;
use PHPExcel_Style_Border;

class AppointmentsController extends Controller
{
    public function createAppointment(){
        // dd(Auth::user()->direktor);
        $companies = DB::table('companies')->where('types_of_contract_id', 1)->get();
        // dd($companies);
        return view('appointments.create', ['companies' => $companies]);
    }

    public function storeAppointment(AppointmentRequest $request){
        $files = $request->file('file');
        $data = [];
        if (!empty($files)) {
            foreach ($files as $file) {
                $name = date('dmY_His_').$file->getClientOriginalName();
                Storage::disk('public_uploads')->put($name, file_get_contents($file));
                $data[] = $name;
            }
        }
        $members_count = '';
        if ($request->has('member-salutation')) {
            $members_count = count($request['member-salutation']);
        } else {
            $members_count = 0;
        }
        $date_request = $request['date'];
        $replace_date = str_replace("/",".",$date_request);
        $date = Carbon::parse($replace_date)->format('Y-m-d');
        $appointment = Appointment::create([
            'salutation' => $request['salutation'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'street' => $request['street'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'post_code' => $request['post_code'],
            'canton' => $request['canton'],
            'language' => $request['language'],
            'mobile_number' => $request['mobile_number'],
            'phone_number' => $request['phone_number'],
            'house_number' => $request['house_number'],
            'date' => $date,
            'date_for_search' => $replace_date,
            'time' => $request['time'],
            'photos' => json_encode($data),
            'krankenkassen' => $request['company'],
            'members_count' => $members_count,
            'comment' => $request['comment'],
            'user_id' => Auth::user()->id,
            'appointment_direktor' => Auth::user()->direktor,
            'assigned_to' => null,
            'created_at_filter' => Carbon::now()->format('Y-m-d'),
        ]);
        if ($appointment) {
            if ($request['member-salutation']) {
                $count = count($request['member-salutation']);
                for ($i=0; $i < $count; $i++) {
                    AppointmentMember::create([
                        'salutation' => $request['member-salutation'][$i],
                        'first_name' => $request['member-first-name'][$i],
                        'krankenkassen' => $request['member-krankenkassen'][$i],
                        'birth_year' => $request['member-birth-year'][$i],
                        'contract_duration' => $request['member-contract-duration'][$i],
                        'behandlung' => $request['member-behandlung'][$i],
                        'appointment_id' => $appointment->id,
                    ]);
                };
            }
            return redirect('/appointments')->with('successAppointment', 'Termin wurde erfolgreich eingetragen');
        }
        return redirect('/createAppointment')->with('errorAppointment', 'There was an error while creating the appointment');
    }

    public function showAppointments(){
        // $offenfeedbacks = DB::table('appointment_feedback')->whereNotNull('offen')->get()->pluck('appointment_id');
        // dd($offenfeedbacks);
        $this->automatedFeedback();
        // dd($appoitnments);
        // $use = User::where('id', 2)->pluck('id')->first();
        $users = DB::table('users')->get()->groupBy('created_by');
        $directors = User::role('Berater Admin')->get();
        $appointments = Appointment::all();

        return view('appointments.index', ['users' => $users, 'directors' => $directors, 'appointments'=> $appointments]);
    }

    public function AppointmentsTimeFilter(TimeFilterRequest $request){
        $filter_by = $request['filter_by'];
        $from = $request['from'];
        $to = $request['to'];
        $appointmentTime = AppointmentTimeFilter::first()->update([
            'from' => $from,
            'to' => $to,
            'filter_by' => $filter_by,
        ]);
    }

    public function getAppointments(Request $request){
        $appointmentTime = AppointmentTimeFilter::first();
        $from = $appointmentTime->from;
        $to = $appointmentTime->to;
        $filter = $appointmentTime->filter_by;
        $filter_by = '';
        $query = '';
        $callCenter = '';
        if($filter==1){
            $filter_by = 'date';
        }elseif ($filter==2) {
            $filter_by = 'created_at_filter';
        }elseif ($filter == 3){
            $filter_by = 'assigned_to';
            if ($from == 'Call Center') {
                $callCenter = 'Call Center';
            } else {
                $callCenter = 'Broker';
            }
        }

        if (Auth::user()->hasRole('Administrator')) {


            $query = DB::table('appointments')
                ->leftJoin('users', 'appointments.assigned_to', '=', 'users.id')
                ->leftJoin('users as userAssigned', 'appointments.assigned_from', '=', 'userAssigned.id')
                ->leftJoin('users as direktors', 'appointments.appointment_direktor', '=', 'direktors.id')
                ->leftJoin('users as createdBy', 'appointments.user_id', '=', 'createdBy.id')
                ->select('appointments.*','users.email as user', 'direktors.email as direktorEmail', 'users.company_name as usercompany', 'userAssigned.email as userfrom', 'createdBy.email as createdByUser', 'createdBy.company_name as createdByCompany');

            if($appointmentTime->from && $appointmentTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                    ->whereDate($filter_by, '<=', $to);
                $appointmentTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            } elseif($appointmentTime->from != null && $appointmentTime->to == null){
                $query->where('users.country', $callCenter);
                $appointmentTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }

        } elseif(Auth::user()->hasRole('Quality Controll')){
            $qualityControll = DB::table('users')->where('id', '=', Auth::user()->id)->first();

            $getCreatedBy = DB::table('users')
            ->where('created_by', Auth::user()->id)
            ->get()->pluck('id');

            $query = DB::table('appointments')
            ->leftJoin('users', 'appointments.assigned_to', '=', 'users.id')
            ->leftJoin('users as direktors', 'appointments.appointment_direktor', '=', 'direktors.id')
            ->leftJoin('users as createdBy', 'appointments.user_id', '=', 'createdBy.id')
            ->select('appointments.*','users.email as user', 'direktors.email as direktorEmail', 'users.company_name as usercompany', 'createdBy.email as createdByUser', 'createdBy.company_name as createdByCompany')
            ->where(function($query) use($qualityControll) {
                $query->where('user_id', Auth::user()->id)
                ->orWhere('assigned_to', Auth::user()->id)
                ->orWhere('appointment_direktor', Auth::user()->id);

                if($qualityControll->quality_responsibility == 'all'){
                    $result = DB::table('users')->where('direktor', '=', $qualityControll->direktor)->pluck('id');
                    $query->orWhere('appointment_direktor', $qualityControll->direktor);
                    $query->orWhereIn('appointment_direktor', $result);
                } else {
                    if ($qualityControll->quality_responsibility != null) {
                        $getCreatedBy = DB::table('users')
                            ->where('created_by', $qualityControll->quality_responsibility)
                            ->get()->pluck('id');
                        $query->orWhereIn('user_id', $getCreatedBy);
                    }
                }
            });

            if($appointmentTime->from && $appointmentTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                ->whereDate($filter_by, '<=', $to);
                $appointmentTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }
        } elseif(Auth::user()->hasRole('Call Center Admin|Berater Admin')){

            $getUserCountry = DB::table('users')
                ->where('id', Auth::user()->id)
                ->get()->pluck('country');

            $getAllCallCenter = DB::table('users')
            ->where('country', $getUserCountry)
            ->get()->pluck('id');

            $query = DB::table('appointments')
            ->leftJoin('users', 'appointments.assigned_to', '=', 'users.id')
            ->leftJoin('users as userAssigned', 'appointments.assigned_from', '=', 'userAssigned.id')
            ->leftJoin('users as direktors', 'appointments.appointment_direktor', '=', 'direktors.id')
            ->leftJoin('users as createdBy', 'appointments.user_id', '=', 'createdBy.id')
            ->select('appointments.*','direktors.email as direktorEmail', 'users.company_name as usercompany', 'users.email as user', 'userAssigned.email as userfrom', 'users.country as usertype', 'createdBy.email as createdByUser', 'createdBy.company_name as createdByCompany')
            ->where(function ($query) use ($getAllCallCenter){
                $query->orWhereIn('appointments.assigned_to', $getAllCallCenter)
                ->orWhereIn('appointments.appointment_direktor', $getAllCallCenter)
                ->orWhereIn('appointments.user_id', $getAllCallCenter);
            });

            if($appointmentTime->from && $appointmentTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                ->whereDate($filter_by, '<=', $to);
                $appointmentTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }elseif($appointmentTime->from != null && $appointmentTime->to == null){
                $query->where('users.country', $callCenter);
                $appointmentTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }
        }
        elseif(Auth::user()->hasRole('Call Center Direktor|Broker Direktor')){
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

            $query = DB::table('appointments')
                ->leftJoin('users', 'appointments.assigned_to', '=', 'users.id')
                ->leftJoin('users as direktors', 'appointments.appointment_direktor', '=', 'direktors.id')
                ->leftJoin('users as createdBy', 'appointments.user_id', '=', 'createdBy.id')
                ->select('appointments.*','users.email as user', 'direktors.email as direktorEmail', 'users.company_name as usercompany', 'createdBy.email as createdByUser', 'createdBy.company_name as createdByCompany')
                ->where(function ($query) use ($getDirektorsByCreated, $getDirektorsByDirektor,$secondPartner, $secondPartnerUsers) {
                    $query->where('appointments.user_id', Auth::user()->id)
                    ->orWhere('assigned_to', Auth::user()->id)
                    ->orWhere('appointment_direktor', Auth::user()->id)
                    ->orWhereIn('appointments.assigned_to', $getDirektorsByCreated)
                    ->orWhereIn('appointments.appointment_direktor', $getDirektorsByCreated)
                    ->orWhereIn('appointments.user_id', $getDirektorsByCreated)
                    ->orWhereIn('appointments.assigned_to', $getDirektorsByDirektor)
                    ->orWhereIn('appointments.appointment_direktor', $getDirektorsByDirektor)
                    ->orWhereIn('appointments.user_id', $getDirektorsByDirektor);
                    if ($secondPartner->count() != 0) {
                        $query->orWhere('appointments.appointment_direktor', $secondPartner)
                        ->orWhere('appointments.assigned_to', $secondPartner)
                        ->orWhere('appointments.user_id', $secondPartner)
                        ->orWhereIn('appointments.assigned_to', $secondPartnerUsers)
                        ->orWhereIn('appointments.appointment_direktor', $secondPartnerUsers)
                        ->orWhereIn('appointments.user_id', $secondPartnerUsers);
                    }
                });

            if($appointmentTime->from && $appointmentTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                ->whereDate($filter_by, '<=', $to);
                $appointmentTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }
        }
        else{
            $getCreatedBy = DB::table('users')
                ->where('created_by', Auth::user()->id)
                ->get()->pluck('id');

            $query = DB::table('appointments')
            ->leftJoin('users', 'appointments.assigned_to', '=', 'users.id')
            ->leftJoin('users as direktors', 'appointments.appointment_direktor', '=', 'direktors.id')
            ->leftJoin('users as createdBy', 'appointments.user_id', '=', 'createdBy.id')
            ->select('appointments.*','users.email as user','direktors.email as direktorEmail', 'users.company_name as usercompany', 'createdBy.email as createdByUser', 'createdBy.company_name as createdByCompany')
            ->where(function($query) use ($getCreatedBy){
                $query->where('appointments.user_id', Auth::user()->id)
                ->orWhereIn('appointments.user_id', $getCreatedBy)
                ->orWhere('assigned_to', Auth::user()->id)
                ->orWhere('appointment_direktor', Auth::user()->id);
            });

            if($appointmentTime->from && $appointmentTime->to != null){
                $query->whereDate($filter_by, '>=', $from)
                ->whereDate($filter_by, '<=', $to);
                $appointmentTime = AppointmentTimeFilter::first()->update([
                    'from' => null,
                    'to' => null,
                    'filter_by' => null
                ]);
            }
        }

        if (Auth::user()->hasRole('Administrator')) {
            $offenfeedbacks = DB::table('appointment_feedback')->whereNotNull('offen')->get()->pluck('appointment_id');
            $positivfeedbacks = DB::table('appointment_feedback')->whereNotNull('positiv')->get()->pluck('appointment_id');

            return (new QueryDataTable($query))
            ->editColumn('first_name', '{{ $first_name . " " . $last_name. " " . $street . " " . $post_code}}')
            ->editColumn('mobile_number', '{{$mobile_number}}')
            ->editColumn('phone_number', '{{$phone_number}}')
            ->editColumn('members_count', '{{$members_count ." ". $krankenkassen}}')
            ->editColumn('date', '@if($second_date == null) {{$date}} @else {{$second_date}} @endif')
            ->editColumn('time', '@if($second_time == null) {{$time}} @else {{$second_time}} @endif')
            ->editColumn('user', '{{$usercompany ." ". $user}}')
            ->addColumn('feedback', '<button id="feedback" title="Feedback" class="btn btn-sm btn-outline-secondary"><i class="far fa-comment-alt fa-lg feedbackicon"></i></button>')
            ->addColumn('actions', '<div class="row"><a title="Edit" target="_blank" class="btn btn-sm btn-outline-secondary mr-2" href="{{ route("edit.appointment",$id) }}">
                    <i class="fa fa-edit fa-lg" ></i>
                </a>
                <button title="Delete" class="btn btn-sm btn-outline-secondary deleteAppointment">
                    <i class="fa fa-trash fa-lg"></i>
                </button></div>')
            ->addColumn('check', '<div class="custom-control custom-checkbox under-checkbox"><input type="checkbox" class="check custom-control-input" value="{{ $id }}" id="checkboxlead{{ $id }}" name="checkAppointment"><label class="custom-control-label checkbox-inline costumcheckbox1" for="checkboxlead{{ $id }}"></label></div>')
            ->setRowId('{{$id}}')
            ->setRowClass('{{ $status == "Abgesagt" ? "abgesagt" : "" }} {{ $status == "Storno" ? "storno" : "" }}')
            ->setRowClass(function ($query) use($offenfeedbacks, $positivfeedbacks){
                $class = "";
                if ($offenfeedbacks->contains($query->id)) {
                    $class="offen";
                } elseif($positivfeedbacks->contains($query->id)){
                    $class="abshluss";
                }
                return $class;
            })
            ->rawColumns(['actions', 'check', 'feedback'])
            ->toJson();
        } else {
            return (new QueryDataTable($query))
            ->editColumn('first_name', '{{ $first_name . " " . $last_name. " " . $street . " " . $post_code}}')
            ->editColumn('date', '@if($second_date == null) {{$date}} @else {{$second_date}} @endif')
            ->editColumn('time', '@if($second_time == null) {{$time}} @else {{$second_time}} @endif')
            ->editColumn('user', '{{$usercompany ." ". $user}}')
            ->editColumn('mobile_number', '@if(Auth::user()->hasRole("Call Center Admin|Berater Admin")) {{"$mobile_number"}} @else {{$mobile_grant_access ? "$mobile_number" : ""}} @endif')
            ->editColumn('phone_number', '@if(Auth::user()->hasRole("Call Center Admin|Berater Admin")) {{"$phone_number"}} @else {{$mobile_grant_access ? "$phone_number" : ""}} @endif')
            ->editColumn('members_count', '{{$members_count ." ". $krankenkassen}}')
            ->addColumn('feedback', '@if(Auth::user()->id == $assigned_to) <button id="feedback" title="Feedback" class="btn btn-sm btn-outline-secondary"><i class="far fa-comment-alt fa-lg feedbackicon"></i></button> @else <button id="feedbackHistory" title="Feedback History" class="btn btn-sm btn-outline-secondary"><i class="fas fa-copy fa-lg feedbackhistoryicon"></i></button>  @endif')
            ->addColumn('actions', '<div class="row"><a title="Edit" target="_blank" class="btn btn-sm btn-outline-secondary mr-2" href="{{ route("edit.appointment",$id) }}">
                    <i class="fa fa-edit fa-lg" ></i>
                </a></div>')
                ->addColumn('check', '<div class="custom-control custom-checkbox under-checkbox"><input type="checkbox" class="check custom-control-input" value="{{ $id }}" id="checkboxlead{{ $id }}" name="checkAppointment"><label class="custom-control-label checkbox-inline costumcheckbox1" for="checkboxlead{{ $id }}"></label></div>')
            ->setRowId('{{$id}}')
            ->setRowClass('{{ $status == "Abgesagt" ? "abgesagt" : "" }} {{ $status == "Storno" ? "storno" : "" }}')
            ->rawColumns(['actions', 'check', 'feedback'])
            ->toJson();
        }
    }
    public function automatedFeedback(){
        $currentDateTime = Carbon::now()->subMinutes(30);
        $currentTime = $currentDateTime->format('H:i');
        $currentDate = $currentDateTime->format('Y-m-d');
        $appointments = Appointment::where([['date', '=' , $currentDate],['time', '<=' , $currentTime]])->get();

        // dd($currentDateTime);
        foreach ($appointments as $appointment) {
            $feedback = DB::table('appointment_feedback')->where('appointment_id', $appointment->id)->first();
            if (!$feedback) {
                DB::table('appointment_feedback')->insert([
                    'stattgefunden' => 'stattgefunden',
                    'comment' => 'No feedback in the first 30 minutes',
                    'appointment_id' => $appointment->id,
                    'user_id' => 1,
                    'created_at' => Carbon::now()
                ]);
            }
        }

        $currentDateTimeSecond = Carbon::now()->subMinutes(240);
        $currentTimeSecond = $currentDateTimeSecond->format('H:i');
        $currentDateSecond = $currentDateTimeSecond->format('Y-m-d');
        $appointmentsSecond = Appointment::where([['date', '=' , $currentDateSecond],['time', '<=' , $currentTimeSecond]])->get();
        // dd($currentDateTimeSecond);
        foreach ($appointmentsSecond as $appointment) {
            // $asd = $appointment->id;
            $feedback = DB::table('appointment_feedback')->where('appointment_id', $appointment->id)->first();
            $feedbacklatest = DB::table('appointment_feedback')->where('appointment_id', $appointment->id)->latest()->first();
            if ($feedback->comment == 'No feedback in the first 30 minutes' && $feedbacklatest->comment == 'No feedback in the first 30 minutes') {
                DB::table('appointment_feedback')->insert([
                    'positiv' => 'positiv',
                    'kvg_vvg' => $appointment->members_count,
                    'comment' => 'Kein Feedback innerhalb der  Zeitspanne von Berater angegeben automatisch Abschluss angegeben vom System',
                    'appointment_id' => $appointment->id,
                    'user_id' => 1,
                    'created_at' => Carbon::now()
                ]);
            }
        }
        // dd($asd);
        // return $appointments;
    }
    public function edit(Appointment $appointment){
        $data = [];
        $members = AppointmentMember::where('appointment_id', $appointment->id)->get();
        $uploads = json_decode($appointment->photos);
        if (!empty($uploads)) {
            foreach($uploads as $key => $upload)
            {
                $data[] = $upload;
            }
        }
        $images = $data;
        $username = User::where('id', $appointment->user_id)->select('first_name','last_name')->first();
        // dd($username->first_name);
        $multipeComments = DB::table('multiple_comment')
            ->where('appointment_id', $appointment->id)
            ->leftJoin('users', 'users.id', '=', 'multiple_comment.user_id')
            ->select('multiple_comment.*','users.first_name as name', 'users.last_name as lastname')
            ->get();

        $companies = DB::table('companies')->where('types_of_contract_id', 1)->get();

        return view('appointments.edit', ['appointment' => $appointment, 'uploads' => $uploads, 'members' => $members, 'images' => $images, 'companies' => $companies, 'multipeComments' => $multipeComments, 'username' => $username]);
    }

    public function update(AppointmentRequest $request, Appointment $appointment){
      if($appointment->photo_access_br == 0){
            if(Auth::user()->hasRole('Berater Admin|Broker Direktor|Berater Team Leader|Berater')){
                return "You don't have access for upload";
            }
        }
        $photos = json_decode($appointment->photos);
        $data = [];
        if (!empty($photos)) {
            foreach ($photos as $photo) {
                $data[] = $photo;
            }
        }
        $files = $request->file('file');
        if (!empty($files)) {
            foreach ($files as $file) {
                $name = date('dmY_His_').$file->getClientOriginalName();
                Storage::disk('public_uploads')->put($name, file_get_contents($file));
                $data[] = $name;
            }
        }
        $date_request = $request['date'];
        $replace_date = str_replace("/",".",$date_request);
        $date = Carbon::parse($replace_date)->format('Y-m-d');

        $members_count = '';
        if ($request->has('member-salutation')) {
            $members_count = count($request['member-salutation']);
        } else {
            $members_count = 0;
        }

        if(Auth::user()->hasRole('Quality Controll')){
            $appointment->update([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'date' => $date,
                'date_for_search' => $replace_date,
                'time' => $request['time'],
                // 'qc_comment' => $request['qcComment'],
                'status' => $request['status'],
                'street' => $request['street'],
                'photos' => json_encode($data),
                'photo_access_br' =>$request->has('photoAccessBr') ? 1 : 0,
                'qccomment_access_cc' =>$request->has('commentAccessCC') ? 1 : 0,
                'qccomment_access_br' =>$request->has('commentAccessBr') ? 1 : 0,
            ]);
        }
        elseif(Auth::user()->hasRole('Call Center Direktor|Broker Direktor')){
            $appointment->update([
                'salutation' => $request['salutation'],
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'street' => $request['street'],
                    'lat' => $request['lat'],
                    'lng' => $request['lng'],
                    'post_code' => $request['post_code'],
                    'canton' => $request['canton'],
                    'language' => $request['language'],
                    'mobile_number' => $request['mobile_number'],
                    'phone_number' => $request['phone_number'],
                    'house_number' => $request['house_number'],
                    'date' => $date,
                    'date_for_search' => $replace_date,
                    'time' => $request['time'],
                    'photos' => json_encode($data),
                    'krankenkassen' => $request['company'],
                    'members_count' => $members_count,
                    'comment' => $request['comment'],
                    'status' => $request['status'],
                    'created_at_filter' => Carbon::now()->format('Y-m-d'),
            ]);
        }
        if(Auth::user()->hasRole('Administrator|Call Center Admin|Berater Admin')){

                $appointment->update([
                    'salutation' => $request['salutation'],
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'street' => $request['street'],
                    'lat' => $request['lat'],
                    'lng' => $request['lng'],
                    'post_code' => $request['post_code'],
                    'canton' => $request['canton'],
                    'language' => $request['language'],
                    'mobile_number' => $request['mobile_number'],
                    'phone_number' => $request['phone_number'],
                    'house_number' => $request['house_number'],
                    'date' => $date,
                    'date_for_search' => $replace_date,
                    'time' => $request['time'],
                    'photos' => json_encode($data),
                    'krankenkassen' => $request['company'],
                    'members_count' => $members_count,
                    'comment' => $request['comment'],
                    'status' => $request['status'],
                    'created_at_filter' => Carbon::now()->format('Y.m.d'),
                    'mobile_grant_access' => $request->has('mobileGrantAccess') ? 1 : 0,
                    'phone_grant_access' =>$request->has('phoneGrantAccess') ? 1 : 0,
                    'photo_access_br' =>$request->has('photoAccessBr') ? 1 : 0,
                    'qccomment_access_cc' =>$request->has('commentAccessCC') ? 1 : 0,
                    'qccomment_access_br' =>$request->has('commentAccessBr') ? 1 : 0,
                ]);
        }
        if($request['qcComment'] != null){
            $multipleComment = DB::table('multiple_comment')->insert([
                'comment' => $request['qcComment'],
                'user_id' => Auth::user()->id,
                'appointment_id' => $appointment->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        if ($appointment) {
            if ($request['member-salutation']) {
                AppointmentMember::where('appointment_id',$appointment->id)->delete();

                $count = count($request['member-salutation']);

                for ($i=0; $i < $count; $i++) {
                    AppointmentMember::create([
                        'salutation' => $request['member-salutation'][$i],
                        'first_name' => $request['member-first-name'][$i],
                        'krankenkassen' => $request['member-krankenkassen'][$i],
                        'birth_year' => $request['member-birth-year'][$i],
                        'contract_duration' => $request['member-contract-duration'][$i],
                        'behandlung' => $request['member-behandlung'][$i],
                        'appointment_id' => $appointment->id,
                    ]);
                };
            }
            return redirect('/appointments')->with('successAppointmentUpdating', 'Der Termin wurde erfolgreich aktualisiert');
        }
        return redirect('/appointments')->with('errorAppointmentUpdating', 'There was an error while updating the appointment');
    }

    public function deleteImage(Appointment $appointment, $image){
        if($appointment->photo_access_cc == 0){
            if(Auth::user()->hasRole('Call Center Direktor|Agent Team Leader|Agent')){
                return "You don't have access for upload";

            }
        }elseif($appointment->photo_access_br == 0){
            if(Auth::user()->hasRole('Berater Admin|Broker Direktor|Berater Team Leader|Berater')){
                return "You don't have access for upload";
            }
        }
        $file_path = public_path('uploads/'.$image);//storage
        unlink($file_path);
        Storage::delete($file_path);
        $data = [];
        $photos = json_decode($appointment->photos);
        if (!empty($photos)) {
            foreach ($photos as $photo) {
                if ($photo == $image) {
                    $appointment->update(['photos' => json_encode($data)]);
                }
                else {
                    $data[] = $photo;
                }
            }
        }
        $appointment->update(['photos' => json_encode($data)]);
        if ($appointment) {
            return '{}';
        }
    }

    public function uploadImage(Request $request, Appointment $appointment){
      if($appointment->photo_access_br == 0){
            if(Auth::user()->hasRole('Berater Admin|Broker Direktor|Berater Team Leader|Berater')){
                return "You don't have access for upload";
            }
        }
        $files = $request->file('file');
        $data = [];
        $photos = json_decode($appointment->photos);
        if (!empty($photos)) {
            foreach ($photos as $photo) {
                $data[] = $photo;
            }
        }
        if (!empty($files)) {
            foreach ($files as $file) {
                $name = date('dmY_His_').$file->getClientOriginalName();
                Storage::disk('public_uploads')->put($name, file_get_contents($file));
                $data[] = $name;
            }
        }
        $appointment->update(['photos' => json_encode($data)]);
        return '{}';
    }

    public function searchAgents(Request $request){
        $value = $request['value'];
        $direktors = DB::table('users')->where('direktor', $value)->get()->pluck('id');
        $data = DB::table('users')
            ->where('created_by', $value)
            ->orWhere('direktor', $value)
            ->orWhereIn('created_by', $direktors)
            ->orWhereIn('direktor', $direktors)
            ->get();
            $output = '<option value=""></ option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->first_name. ' ' . $row->last_name.'</option>';
        }
        echo $output;
    }

    public function assignTo(Request $request){

        foreach ($request['selectBoxArray'] as $appointment) {
            DB::table('appointments')->where([
                ['id', $appointment],
                ['status','!=', 'Storno'],
                ['status','!=', 'Abgesagt']
            ])
            ->orWhere([
                ['id', $appointment],
                ['status','=', null],
            ])
            ->update([
                'assigned_to' => ($request['agent'] == null)? $request['direktor'] : $request['agent'],
                'assigned_from' =>  Auth::user()->id,
                'appointment_direktor' => $request['direktor']
            ]);
        }
        echo 'success';
    }

    public function import_excel(Request $request){
        $this->validate($request, [
            'excel_import' => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('excel_import')->getRealPath();
        $data = Excel::load($path)->get();
        if($data->count() > 0)
        {
            $data->toArray();
            foreach($data as $row)
            {
                // dd($row);
                $replace_date = str_replace("/","-",$row['termin_datum']);
                $date = Carbon::parse($replace_date)->format('Y-m-d');
                // $indent = explode(' ', $row['voller_name']);
                $street_postcode = explode(' ', $row['strasse']);

                $excel_email = $row['zugewiesen_an'];
                $user_email = User::where('email', $excel_email)->get()->pluck('id');
                // dd($user_email[0]);
                $assigned_to = '';
                if ($user_email) {
                    $assigned_to = $user_email[0];
                }
                // $excel_company = $row['krankenkassen'];
                // $companies = DB::table('companies')->where('types_of_contract_id', 1)->where('name', $excel_company)->get()->pluck('id');

                $appointment = Appointment::create([
                    'salutation' => '',
                    'first_name' => $row['vorname'],
                    'last_name' => $row['nachname'],
                    'street' => $row['strasse'],
                    'lat' => 1,
                    'lng' => 1,
                    'post_code' => $row['plzort'],
                    'canton' => $row['kanton'],
                    'language' => $row['sprache'],
                    'mobile_number' => $row['mobile_nummer'],
                    'mobile_grant_access' => 1,
                    'phone_number' => $row['haus_nummer'],
                    'phone_grant_access' => 1,
                    'date' => $date,
                    'date_for_search' => $row['termin_datum'],
                    'time' => $row['termin_zeit'],
                    'house_number' => '',
                    'comment' => $row['kommentar'],
                    'photos' => null,
                    'photo_access_br'=>1,
                    'qccomment_access_cc' =>1,
                    'qccomment_access_br' =>1,
                    'krankenkassen' => $row['aktuelle_kasse'],
                    'members_count' => 0,
                    'user_id' => Auth::user()->id,
                    'assigned_to' => $assigned_to,
                    'appointment_direktor' => Auth::user()->direktor,
                    'created_at_filter' => Carbon::now()->format('Y-m-d'),
                ]);
            }
        }
        return back()->with('successAppointment','Excel Data Imported successfully');
    }


    public function single_excel($id){
        $appointments = preg_split("/\,/", $id);
        $files = [];
        foreach($appointments as $appointment_id){
            $appointment = Appointment::where('id',  $appointment_id)->first();
            $callAgent = User::where('id', $appointment->user_id)->first();

            (array)$export_row = null;
            $idexcel = $appointment->id;
            $export_row[] = array('ID:', $appointment->id, 'TERMIN FORMULAR', '', '', '');
            $export_row[] = array('Call datum:', Carbon::parse($appointment->created_at_filter)->format('d.m.Y'), 'Callagent:', $callAgent->email, '');
            $export_row[] = array('Termin datum:', $appointment->date_for_search, 'Zeit:', $appointment->time, '');
            $export_row[] = array('Anrede', $appointment->salutation, '', '', '');
            $export_row[] = array('Name', $appointment->first_name . " " .$appointment->last_name, '', 'Zust. Berater:', '');
            $export_row[] = array('Strasse', $appointment->street, '', 'Mobile Nummer', $appointment->mobile_number);
            $export_row[] = array('PLZ/Ort', (int)$appointment->post_code, '', 'Haus Nummer', $appointment->house_number);
            $export_row[] = array('Kanton', $appointment->canton, '', 'Sprache', $appointment->language);
            $export_row[] = array('Anrede', 'Name', 'Geburtsdatum', 'Krankenversicherung', 'Vertrag bis', 'Zurzeit in Behandlung');

            $query = AppointmentMember::where('appointment_id',$appointment->id)->get();
            foreach ($query as $key => $family_member) {
                if($key==6){
                    break;
                }
                $export_row[] = array($family_member->salutation, $family_member->first_name, (int)$family_member->birth_year, $family_member->krankenkassen, $family_member->contract_duration, $family_member->behandlung);
            }

            Excel::create('ID-'.$idexcel, function($excel) use ($export_row,$idexcel,$appointment){
            $excel->setTitle('ID');
            $excel->sheet('ID-'.$idexcel, function($sheet) use ($export_row,$appointment){
                $sheet->mergeCells('C1:D1');
                $sheet->mergeCells('D2:E2');
                $sheet->mergeCells('B5:C5');
                $sheet->mergeCells('B6:C6');
                $sheet->mergeCells('B7:C7');
                $sheet->mergeCells('E6:F6');
                $sheet->mergeCells('E7:F7');
                $sheet->mergeCells('A16:B16');
                $sheet->mergeCells('A17:F20');
                $sheet->setCellValue('A16', 'Kommentare');
                $sheet->setCellValue('A17', $appointment->comment);
                $sheet->cell('A1', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(12);
                    $cells->setalignment('right');
                });
                $sheet->cell('A17', function ($cells) {
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
                $sheet->cell('A4', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cell('A16', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cell('A9', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                });
                $sheet->cell('B9', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                });
                $sheet->cell('C9', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                });
                $sheet->cell('D9', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                });
                $sheet->cell('E9', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
                });
                $sheet->cell('F9', function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setalignment('center');
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
                $range="A16:F16";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('dotted','dotted','dotted','dotted');
                });
                $range="A9";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('double','double','double','double');
                });
                $range="B9";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('double','double','double','double');
                });
                $range="C9";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('double','double','double','double');
                });
                $range="D9";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('double','double','double','double');
                });
                $range="E9";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('double','double','double','double');
                });
                $range="F9";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('double','double','double','double');
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
                $range="A3:F3";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('none','none','thin','thin');
                });
                $range="A1:F15";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('thick','thick','thick','thick');
                });
                $range="A16:F20";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('thick','thick','thick','thick');
                });
                $range="G6:H7";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('none','none','none','thick');
                });
                $range="G16:H20";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('none','none','none','thick');
                });
                $range="A21:F21";
                $sheet->cell($range, function($cell){
                    $cell->setBorder('thick','none','none','none');
                });
            $sheet->fromArray($export_row, null, 'A1', false, false);
            });
            })->store('xlsx');
            $files[] = glob('../storage/exports/ID-'.$idexcel.'.xlsx');
        }
        $namefile = Carbon::now()->format('d-m-Y');
        // dd($files[0][0]);
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

    public function export_all() {
        (array)$row_all = null;
        $row_all[] = array(
            'ID',
            'Call Datum',
            'Vorname',
            'Nachname',
            'Strasse',
            'PLZ/Ort',
            'Kanton',
            'Mobile Nummer',
            'Haus Nummer',
            'Aktuelle Kasse',
            'Termin Datum',
            'Termin Zeit',
            'Sprache',
            'Geb.Datum',
            'Kommentar',
            'CC',
            'Call Agent',
            'Agentur',
            'Vermittler',
            'Brutto',
            'Neto',
            'Bestätigt',
            'Storno',
            'Agesagt',
            'Unzuteilbar',
            'Zeitlich nicht geschafft',
            'Berater nicht besucht',
            'Kunde nicht auffindbar',
            'Falsche Adresse',
            'Kunde nicht err.',
            'Nicht zu Hause',
            'Wollte kein Termin',
            'SG',
            'Brauchbar',
            'Konnte nicht beraten',
            'MJV',
            'Behandlung',
            'Zu alt',
            'Socialfall',
            'Schulden/Betreibung',
            'Negativ',
            'Offen',
            'Positiv',
            'Abschlüsse KVG & VVG',
            'Abschlüsse nur VVG',
            'Andere',
            'Abschluss Quote',
            'Zugewiesen an'
        );

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
            $appointments = Appointment::all();
        } else {
            $appointments = Appointment::where('appointments.user_id', Auth::user()->id)
            ->orWhere('appointments.assigned_to', Auth::user()->id)
            ->orWhere('appointments.appointment_direktor', Auth::user()->id)
            ->orWhereIn('appointments.assigned_to', $getAdminByCreated)
            ->orWhereIn('appointments.appointment_direktor', $getAdminByCreated)
            ->orWhereIn('appointments.user_id', $getAdminByCreated)
            ->orWhereIn('appointments.assigned_to', $getAdminByDirektor)
            ->orWhereIn('appointments.appointment_direktor', $getAdminByDirektor)
            ->orWhereIn('appointments.user_id', $getAdminByDirektor)
            ->orWhereIn('appointments.assigned_to', $getDirektorByCreated)
            ->orWhereIn('appointments.appointment_direktor', $getDirektorByCreated)
            ->orWhereIn('appointments.user_id', $getDirektorByCreated)
            ->orWhereIn('appointments.assigned_to', $getDirektorByDirektor)
            ->orWhereIn('appointments.appointment_direktor', $getDirektorByDirektor)
            ->orWhereIn('appointments.user_id', $getDirektorByDirektor)->get();
        }


        $missing = '';
        foreach($appointments as $appointment){
            $assigned = null;
            if($appointment->assigned_to != null) {
                 $assigned_to = User::where('id', $appointment->assigned_to)->first();
                 $assigned = $assigned_to->email;
            }

            $createdBy = User::where('id', $appointment->user_id)->first();

            $feedbacks = DB::table('appointment_feedback')->where('appointment_id', $appointment->id)->get();
            $unzuteilbar= '';
            $zeitlich_nicht_geschafft= '';
            $berater_nicht_besucht= '';
            $kunde_nicht_auffindbar= '';
            $falsche_adresse= '';
            $kunde_nicht_err= '';
            $nicht_zu_hause= '';
            $wollte_kein_termin= '';
            $stattgefunden= '';
            $konnte_nicht_beraten= '';
            $mjv= '';
            $behandlung= '';
            $zu_alt= '';
            $socialfall= '';
            $schulden_betreibung= '';
            $negativ= '';
            $offen= '';
            $positiv= '';
            $kvg_vvg= '';
            $nur_vvg= '';
            $andere= '';
            $comment = '';
            foreach ($feedbacks as $feedback) {
                if ($feedback->unzuteilbar != null) {
                    $unzuteilbar = 1;
                }
                if ($feedback->zeitlich_nicht_geschafft != null) {
                    $zeitlich_nicht_geschafft = 1;
                }
                if ($feedback->berater_nicht_besucht != null) {
                    $berater_nicht_besucht = 1;
                }
                if ($feedback->kunde_nicht_auffindbar != null) {
                    $kunde_nicht_auffindbar = 1;
                }
                if ($feedback->falsche_adresse != null) {
                    $falsche_adresse = 1;
                }
                if ($feedback->kunde_nicht_err != null) {
                    $kunde_nicht_err = 1;
                }
                if ($feedback->nicht_zu_hause != null) {
                    $nicht_zu_hause = 1;
                }
                if ($feedback->wollte_kein_termin != null) {
                    $wollte_kein_termin = 1;
                }
                if ($feedback->stattgefunden != null) {
                    $stattgefunden = 1;
                }
                if ($feedback->konnte_nicht_beraten != null) {
                    $konnte_nicht_beraten = 1;
                }
                if ($feedback->mjv != null) {
                    $mjv = 1;
                }
                if ($feedback->behandlung != null) {
                    $behandlung = 1;
                }
                if ($feedback->zu_alt != null) {
                    $zu_alt = 1;
                }
                if ($feedback->socialfall != null) {
                    $socialfall = 1;
                }
                if ($feedback->schulden_betreibung != null) {
                    $schulden_betreibung = 1;
                }
                if ($feedback->negativ != null) {
                    $negativ = 1;
                }
                if ($feedback->offen != null) {
                    $offen = 1;
                }
                if ($feedback->positiv != null) {
                    $positiv = 1;
                }
                if ($feedback->kvg_vvg != null) {
                    $kvg_vvg = $feedback->kvg_vvg;
                }
                if ($feedback->nur_vvg != null) {
                    $nur_vvg = $feedback->nur_vvg;
                }
                if ($feedback->andere != null) {
                    $andere = $feedback->andere;
                }
                $comment = $feedback->comment;
            }

            $row_all[] = array(
                $appointment->id,
                Carbon::parse($appointment->created_at)->format('d/m/Y'),
                $appointment->first_name,
                $appointment->last_name,
                $appointment->street,
                $appointment->post_code,
                $appointment->canton,
                $appointment->mobile_number,
                $appointment->phone_number,
                $missing,
                $appointment->date_for_search,
                $appointment->time,
                $appointment->language,
                $missing,
                $appointment->comment,
                $createdBy->company_name,
                $createdBy->email,
                $missing,
                $missing,
                $missing,
                $missing,
                $missing,
                $missing,
                $missing,
                $unzuteilbar,
                $zeitlich_nicht_geschafft,
                $berater_nicht_besucht,
                $kunde_nicht_auffindbar,
                $falsche_adresse,
                $kunde_nicht_err,
                $nicht_zu_hause,
                $wollte_kein_termin,
                $stattgefunden,
                $konnte_nicht_beraten,
                $mjv,
                $behandlung,
                $missing,
                $zu_alt,
                $socialfall,
                $schulden_betreibung,
                $negativ,
                $offen,
                $positiv,
                $kvg_vvg,
                $nur_vvg,
                $andere,
                $comment,
                $assigned
            );
        }
        Excel::create('Export All', function($excel) use ($row_all){
            $excel->setTitle('Export All');

            $excel->sheet('Export All', function($sheet) use ($row_all){
                $sheet->cell('A1:AV1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cell('V1:V1000', function ($cells) {
                    $cells->setBackground('#c6e0b4');
                });
                $sheet->cell('W1:AF1000', function ($cells) {
                    $cells->setBackground('#ffb3b3');
                });
                $sheet->cell('AG1:AH1000', function ($cells) {
                    $cells->setBackground('#f8cbad');
                });
                $sheet->cell('AI1:AN1000', function ($cells) {
                    $cells->setBackground('#fff2cc');
                });
                $sheet->cell('AO1:AO1000', function ($cells) {
                    $cells->setBackground('#fce4d6');
                });
                $sheet->cell('AP1:AP1000', function ($cells) {
                    $cells->setBackground('#f8cbad');
                });
                $sheet->cell('AQ1:AT1000', function ($cells) {
                    $cells->setBackground('#c6e0b4');
                });
                $styleArray = array(
                    'borders' => array(
                      'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                      )
                    )
                  );
                $sheet->getStyle('A1:AV1000')->applyFromArray($styleArray);
                $sheet->fromArray($row_all, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    public function storeFeedback(AppointmentFeedbackRequest $request, Appointment $appointment){

        $filterRequest = array_filter($request->all());
        $countRequest = count($filterRequest);

        if ($request->has('seconddate') && $request->has('secondtime')) {
            if($request['seconddate'] != null && $request['secondtime'] != null){
                $replace_date = str_replace("/",".",$request['seconddate']);
                $date = Carbon::parse($replace_date)->format('Y-m-d');
                $appointment->update([
                    'second_date' => $date,
                    'date_for_search' => $replace_date,
                    'second_time' => $request['secondtime'],
                ]);
            }
        }

        if($countRequest <= 2){
            $message = 'error';
            echo $message;
            die();

        }

        else{
            $files = $request->file('file');
            $data = [];
            if (!empty($files)) {
                foreach ($files as $file) {
                    $name = date('dmY_His_').$file->getClientOriginalName();
                    Storage::disk('public_uploads')->put($name, file_get_contents($file));
                    $data[] = $name;
                }
            }

            $appointmentfeedback = DB::table('appointment_feedback')
            ->insert([
                'unzuteilbar' => $request['unzuteilbar'],
                'zeitlich_nicht_geschafft' => $request['zeitlich_nicht_geschafft'],
                'berater_nicht_besucht' => $request['berater_nicht_besucht'],
                'kunde_nicht_auffindbar' => $request['kunde_nicht_auffindbar'],
                'falsche_adresse' => $request['falsche_adresse'],
                'kunde_nicht_err' => $request['kunde_nicht_err'],
                'nicht_zu_hause' => $request['nicht_zu_hause'],
                'wollte_kein_termin' => $request['wollte_kein_termin'],
                'verspatet_angemeldet' => $request['verspatet_angemeldet'],
                'stattgefunden' => $request['stattgefunden'],
                'konnte_nicht_beraten' => $request['konnte_nicht_beraten'],
                'mjv' => $request['mjv'],
                'behandlung' => $request['behandlung'],
                'zu_alt' => $request['zu_alt'],
                'socialfall' => $request['socialfall'],
                'schulden_betreibung' => $request['schulden_betreibung'],
                'negativ' => $request['negativ'],
                'offen' => $request['offen'],
                'positiv' => $request['positiv'],
                'kvg_vvg' => $request['kvg_vvg'],
                'nur_vvg' => $request['nur_vvg'],
                'andere' => $request['andere'],
                'comment' => $request['comment'],
                'appointment_id' => $appointment->id,
                'created_at' => Carbon::now(),
                'user_id' => Auth::user()->id,
                'photos' => json_encode($data),
            ]);

            $message = 'created';
            echo $message;

        }
        $message = 'created';
        echo $message;
    }

    public function getDataFeedbacks(Appointment $appointment){
        $feedbacks = null;
        return response()->json($feedbacks);
    }

    public function getDataFeedbackHistory(Appointment $appointment){
        $histories = DB::table('appointment_feedback')
        ->where('appointment_id', $appointment->id)
        ->leftJoin('users', 'appointment_feedback.user_id', '=', 'users.id')
        ->select('appointment_feedback.*', 'users.first_name as name', 'users.last_name as lastname', 'users.country as country')
        ->get();

        $table = '';
        foreach($histories as $key => $history){
            if($history->unzuteilbar != null){
                $nr = 1;
                $feedback = $history->unzuteilbar;

            }elseif($history->zeitlich_nicht_geschafft != null){
                $nr = 2;
                $feedback = $history->zeitlich_nicht_geschafft;

            }elseif($history->kunde_nicht_auffindbar != null){
                $nr = 3;
                $feedback = $history->kunde_nicht_auffindbar;

            }elseif($history->berater_nicht_besucht != null){
                $nr = 4;
                $feedback = $history->berater_nicht_besucht;

            }elseif($history->falsche_adresse != null){
                $nr = 5;
                $feedback = $history->falsche_adresse;

            }elseif($history->kunde_nicht_err != null){
                $nr = 6;
                $feedback = $history->kunde_nicht_err;

            }elseif($history->nicht_zu_hause != null){
                $nr = 7;
                $feedback = $history->nicht_zu_hause;

            }elseif($history->wollte_kein_termin != null){
                $nr = 8;
                $feedback = $history->wollte_kein_termin;

            }elseif($history->verspatet_angemeldet != null){
                $nr = 9;
                $feedback = $history->verspatet_angemeldet;

            }elseif($history->stattgefunden != null){
                $nr = 10;
                $feedback = $history->stattgefunden;

            }elseif($history->konnte_nicht_beraten != null){
                $nr = 11;
                $feedback = $history->konnte_nicht_beraten;

            }elseif($history->mjv != null){
                $nr = 12;
                $feedback = $history->mjv;

            }elseif($history->behandlung != null){
                $nr = 13;
                $feedback = $history->behandlung;

            }elseif($history->zu_alt != null){
                $nr = 14;
                $feedback = $history->zu_alt;

            }elseif($history->socialfall != null){
                $nr = 15;
                $feedback = $history->socialfall;

            }elseif($history->schulden_betreibung != null){
                $nr = 16;
                $feedback = $history->schulden_betreibung;

            }elseif($history->negativ != null){
                $nr = 17;
                $feedback = $history->negativ;

            }elseif($history->offen != null){
                $nr = 18;
                $feedback = $history->offen;

            }elseif($history->positiv != null){
                $nr = 19;
                $feedback = $history->positiv;

            }else{
                $feedback = '';
            }

            ///////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////


            if($history->unzuteilbar != null && $nr != 1){
                $secondFeedBack = $history->unzuteilbar;

            }elseif($history->zeitlich_nicht_geschafft != null && $nr != 2){
                $secondFeedBack = $history->zeitlich_nicht_geschafft;

            }elseif($history->kunde_nicht_auffindbar != null && $nr != 3){
                $secondFeedBack = $history->kunde_nicht_auffindbar;

            }elseif($history->berater_nicht_besucht != null && $nr != 4){
                $secondFeedBack = $history->berater_nicht_besucht;

            }elseif($history->falsche_adresse != null && $nr != 5){
                $secondFeedBack = $history->falsche_adresse;

            }elseif($history->kunde_nicht_err != null && $nr != 6){
                $secondFeedBack = $history->kunde_nicht_err;

            }elseif($history->nicht_zu_hause != null && $nr != 7){
                $secondFeedBack = $history->nicht_zu_hause;

            }elseif($history->wollte_kein_termin != null && $nr != 8){
                $secondFeedBack = $history->wollte_kein_termin;

            }elseif($history->verspatet_angemeldet != null && $nr != 9){
                $secondFeedBack = $history->verspatet_angemeldet;

            }elseif($history->stattgefunden != null && $nr != 10){
                $secondFeedBack = $history->stattgefunden;

            }elseif($history->konnte_nicht_beraten != null && $nr != 11){
                $secondFeedBack = $history->konnte_nicht_beraten;

            }elseif($history->mjv != null && $nr != 12){
                $secondFeedBack = $history->mjv;

            }elseif($history->behandlung != null && $nr != 13){
                $secondFeedBack = $history->behandlung;

            }elseif($history->zu_alt != null && $nr != 14){
                $secondFeedBack = $history->zu_alt;

            }elseif($history->socialfall != null && $nr != 15){
                $secondFeedBack = $history->socialfall;

            }elseif($history->schulden_betreibung != null && $nr != 16){
                $secondFeedBack = $history->schulden_betreibung;

            }elseif($history->negativ != null && $nr != 17){
                $secondFeedBack = $history->negativ;

            }elseif($history->offen != null && $nr != 18){
                $secondFeedBack = $history->offen;

            }elseif($history->positiv != null && $nr != 19){
                $secondFeedBack = $history->positiv;

            }else{
                $secondFeedBack = '';
            }
            if(Auth::user()->hasRole('Administrator|Call Center Admin')){
                $name = '<td>'.$history->name.' '.$history->lastname.'</td>';

            }elseif(Auth::user()->hasRole('Call Center Direktor')){
                if($history->country == 'Call Center'){
                    $name = '<td>'.$history->name.' '.$history->lastname.'</td>';
                }else{
                    $name = '<td>'.'Broker Agency'.'</td>';
                }
            }else{
                $name = '<td></td>';
            }
            $date = Carbon::parse($history->created_at)->format('H:i:s d/m/Y');
            $table .= '<tr><td>'.$history->id.'</td>'.$name.'<td>'.$feedback.' | '.$secondFeedBack.'</td>'.'<td><p style="width:30vw; min-width:20rem; word-wrap: break-word;">' . $history->comment .'</p></td>'.'<td>'.$history->kvg_vvg.'</td>'.'<td>'.$history->nur_vvg.'</td>'.'<td>'.$history->andere.'</td>'.'<td>'.$date.'</td>'.'<td style="border-left:1px solid #dee2e6;">'.'<div class="d-flex ml-1"><button title="Files" class="btn btn-sm btn-outline-secondary image-button mr-2" id="'.$history->id.'"><i class="far fa-images"></i></button><button title="Delete" class="btn btn-sm btn-outline-secondary deleteFeedback" id="'.$history->id.'"><i class="far fa-trash-alt"></i></button></div>'.'</td></tr>';
        }
        return response()->json($table);
    }

    public function getDataFeedbackCount(Appointment $appointment){
        $histories = DB::table('appointment_feedback')
        ->where('appointment_id', $appointment->id)
        ->leftJoin('users', 'appointment_feedback.user_id', '=', 'users.id')
        ->select('appointment_feedback.*', 'users.first_name as name')
        ->count();

        return response()->json($histories);
    }

    public function getFeedbackFiles($feedback){
        $feedbackFiles =  DB::table('appointment_feedback')->where('id', $feedback)->first();

        $data = [];
            $uploads = json_decode($feedbackFiles->photos);
            if (!empty($uploads)) {
                foreach($uploads as $key => $upload)
                {
                    $data[] = $upload;
                }
            }

        $images = $data;

        $url = url("/uploads\/");//storage
        $img = '';
        if($images == null){
            $img = '<div style="text-align: center !important;"><h2>No files available</h2></div>';
        } else {
            foreach($images as $key => $image){

                if($key == 0){
                    $key = 'active';
                }else{
                    $key = '';
                }
                if(substr($image, -3) == 'mp4')
                {
                    $img .= '<div class="carousel-item '.$key.'"><video style="margin-left: 6rem;" width="600" controls><source src="'.$url . $image .'"> type="video/mp4"></video></div>';
                } else {
                    $img .='<div class="carousel-item '.$key.'"><img class="d-block w-100" src="'.$url . $image .'"></img></div>';

                }

            }
        }
        echo $img;
    }

    public function commentUpdate(Request $request, $id){
        $commentDelete = DB::table('multiple_comment')->where('id', $id)->update([
            'comment' => $request['newValue'],
            'updated_at' => Carbon::now()
        ]);
        if($commentDelete){
            $getDate = DB::table('multiple_comment')->where('id', $id)->pluck('updated_at')->first();
            echo $getDate;
        }
    }

    public function commentDelete($id){
        $commentDelete = DB::table('multiple_comment')->where('id', $id)->delete();
    }

    public function destroy(Appointment $appointment){
        $appointment->delete();
    }

    public function destroyFeedback($id){
        $deleteFeedback =  DB::table('appointment_feedback')->where('id', $id)->delete();
        $result = 'Feedback is deleted successfully';
        echo $result;
    }
}

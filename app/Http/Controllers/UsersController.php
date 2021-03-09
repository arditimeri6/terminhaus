<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\User;
use Carbon\Carbon;
use App\DirectorPartner;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use Yajra\DataTables\QueryDataTable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showChangePasswordForm(){
        return view('users.changePassword');
    }
    public function changePassword(ChangePasswordRequest $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("error-password","Ihr aktuelles Kennwort  stimmt nicht mit dem von Ihnen angegebenen Passwort überein. Bitte versuche es erneut.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            return redirect()->back()->with("error-password","New Password cannot be same as your current password. Please choose a different password.");
        }
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("password-changed","Kennwort wurde erfolgreich geändert !");
    }
    public function showUsers(){



        return view('users.index');
    }

    public function getUsers()
    {

        if (Auth::user()->hasRole('Administrator')) {
            $query = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*','roles.name as role');


            return (new QueryDataTable($query))

            ->addColumn(
                'reset_password','<form method="POST" action="{{ route("password.email") }}">
                    @csrf
                    <input type="hidden" class="form-control" name="email" value="{{ $email }}">
                    <button type="submit" class="btn btn-outline-danger">
                        {{ __("Link zum Zurücksetzen des Passworts senden") }}
                    </button>
                </form>')
            ->addColumn('confirm', '<div class="d-flex">@if( $id != auth::user()->id ) @if( $status == null) <button title="Aktivieren" class="mr-2 btn btn-sm btn-outline-danger confirmUser"><i class="fas fa-user-check"></i></button>
                                    @else <button title="Deaktivieren" class="mr-2 btn btn-sm btn-outline-success unconfirmUser"><i class="fas fa-user-times"></i></button>  @endif @endif
                                    <a title="Bearbeiten" href="{{ route("edit.user", $id) }}" class="mr-2 btn btn-sm btn-outline-primary"><i class="fas fa-user-edit"></i></a>
                                    @if( $id != auth::user()->id )<a href="#" title="delete" class="btn btn-sm btn-outline-danger deleteUser"><i class="fas fa-user-slash"></i></a> @endif</div')
            ->editColumn('first_name', '{{ $first_name }} {{ $last_name }}')
            ->editColumn('virtual', '{{ ($virtual == 1) ? "Yes" : "No" }}')
            ->rawColumns(['reset_password', 'confirm'])
            ->setRowId('{{ $id }}')
            ->toJson();
        }
        elseif(Auth::user()->hasRole('Call Center Admin|Berater Admin')) {

            $getUserCountry = DB::table('users')
            ->where('id', Auth::user()->id)
            ->get()->pluck('country');

            $getAllCallCenter = DB::table('users')
            ->where('country', $getUserCountry)
            ->get()->pluck('id');

                $query = DB::table('users')
                ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.*','roles.name as role', DB::raw('(SELECT COUNT(*) FROM appointments WHERE appointments.user_id = users.id) as appointment')
                    ,DB::raw('(SELECT COUNT(*) FROM appointments WHERE appointments.appointment_direktor = users.id) as appointmentDirector'))
                ->where(function ($query) use ($getAllCallCenter){
                    $query->orWhereIn('users.created_by', $getAllCallCenter)
                    ->orWhereIn('users.direktor', $getAllCallCenter)
                    ->orWhereIn('users.id', $getAllCallCenter);
                });

                return (new QueryDataTable($query))

                ->addColumn(
                    'reset_password','<form method="POST" action="{{ route("password.email") }}">
                        @csrf
                        <input type="hidden" class="form-control" name="email" value="{{ $email }}">
                        <button type="submit" class="btn btn-outline-danger">
                            {{ __("Link zum Zurücksetzen des Passworts senden") }}
                        </button>
                    </form>')
                ->addColumn('confirm', '@if($id != Auth::user()->id)@if( $status == null) <button title="Aktivieren" class="btn btn-sm btn-outline-danger confirmUser"><i class="fas fa-user-check"></i></button>
                                        @else <button title="Deaktivieren" class="btn btn-sm btn-outline-success unconfirmUser"><i class="fas fa-user-times"></i></button> @endif @endif
                                        <a title="Bearbeiten" href="{{ route("edit.user", $id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-edit"></i></a>
                                       @if($id != Auth::user()->id)@if($appointment == 0 && $appointmentDirector == 0) <a href="#" title="delete" class="btn btn-sm btn-outline-danger deleteUser"><i class="fas fa-user-slash"></i></a>@endif @endif ')
                ->editColumn('first_name', '{{ $first_name }} {{ $last_name }}')
                ->editColumn('virtual', '{{ ($virtual == 1) ? "Yes" : "No" }}')
                ->rawColumns(['reset_password', 'confirm'])
                ->setRowId('{{ $id }}')
                ->toJson();
        } elseif(Auth::user()->hasRole('Call Center Direktor|Broker Direktor')) {
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

            $query = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*','roles.name as role')
            ->where(function ($query) use ($secondPartner, $secondPartnerUsers) {
                $query->where('created_by', Auth::user()->id)
                ->orWhere('direktor', Auth::user()->id)
                ->orWhere('users.id', Auth::user()->id);
                if ($secondPartner->count() != 0) {
                    $query->orWhere('created_by', $secondPartner)
                    ->orWhere('direktor', $secondPartner)
                    ->orWhere('users.id', $secondPartner)
                    ->orWhereIn('created_by', $secondPartnerUsers)
                    ->orWhereIn('direktor', $secondPartnerUsers)
                    ->orWhereIn('users.id', $secondPartnerUsers);
                }
            });

            return (new QueryDataTable($query))
            ->addColumn(
                'reset_password','<form method="POST" action="{{ route("password.email") }}">
                    @csrf
                    <input type="hidden" class="form-control" name="email" value="{{ $email }}">
                    <button type="submit" class="btn btn-outline-danger">
                        {{ __("Link zum Zurücksetzen des Passworts senden") }}
                    </button>
                </form>')
            ->addColumn('confirm', '@if( $status == null) <button title="Aktivieren" class="btn btn-sm btn-outline-danger confirmUser"><i class="fas fa-user-check"></i></button>
                                    @else <button title="Deaktivieren" class="btn btn-sm btn-outline-success unconfirmUser"><i class="fas fa-user-times"></i></button>  @endif
                                    <a title="Bearbeiten" href="{{ route("edit.user", $id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-edit"></i></a>')
            ->editColumn('first_name', '{{ $first_name }} {{ $last_name }}')
            ->editColumn('virtual', '{{ ($virtual == 1) ? "Yes" : "No" }}')
            ->rawColumns(['reset_password', 'confirm'])
            ->setRowId('{{ $id }}')
            ->toJson();
        }
        else {
            $query = DB::table('users')
            ->where('created_by', Auth::user()->id)
            ->orWhere('direktor', Auth::user()->id)
            ->orWhere('users.id', Auth::user()->id)
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*','roles.name as role');

            return (new QueryDataTable($query))
            ->addColumn(
                'reset_password','<form method="POST" action="{{ route("password.email") }}">
                    @csrf
                    <input type="hidden" class="form-control" name="email" value="{{ $email }}">
                    <button type="submit" class="btn btn-outline-danger">
                        {{ __("Link zum Zurücksetzen des Passworts senden") }}
                    </button>
                </form>')
            ->addColumn('confirm', '@if( $status == null) <button title="Aktivieren" class="btn btn-sm btn-outline-danger confirmUser"><i class="fas fa-user-check"></i></button>
                                    @else <button title="Deaktivieren" class="btn btn-sm btn-outline-success unconfirmUser"><i class="fas fa-user-times"></i></button>  @endif
                                    <a title="Bearbeiten" href="{{ route("edit.user", $id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-user-edit"></i></a>')
            ->editColumn('first_name', '{{ $first_name }} {{ $last_name }}')
            ->editColumn('virtual', '{{ ($virtual == 1) ? "Yes" : "No" }}')
            ->rawColumns(['reset_password', 'confirm'])
            ->setRowId('{{ $id }}')
            ->toJson();
        }
    }

    public function confirm(User $user)
    {
        if ($user->status == null) {
            $user->status = Carbon::now();
            $user->save();
        } else {
            return redirect()->route('showUsers')->with('UserIsConfirmed', 'User is already confirmed.');
        }
    }
    public function unconfirm(User $user)
    {
        if ($user->status != null) {
            $user->status = null;
            $user->save();
        } else {
            return redirect()->route('showUsers')->with('UserIsUnconfirmed', 'User is already deactivated.');
        }
    }

    public function edit(User $user)
    {
        $callCenterDirektors = User::role('Call Center Direktor')->get();
        $brokerDirektors = User::role('Broker Direktor')->get();
        $callCenterAdmins = User::role('Call Center Admin')->get();
        $beraterAdmins = User::role('Berater Admin')->get();

        return view('users.edit', ['user' => $user, 'callCenterDirektors' => $callCenterDirektors, 'brokerDirektors' => $brokerDirektors
                                    ,'callCenterAdmins'=>$callCenterAdmins, 'beraterAdmins' => $beraterAdmins]);

    }
    public function update(UserRequest $request, User $user)
    {
        $save_password = $user->password;
        if($request['password']==null){
            $password = $save_password;
        }else {
            $password = Hash::make($request['password']);
        }


        /////////Call Center Direktor assign view access
        if($request['role_id'] == 2){
            $assignViewAccess = $request->has('assignAccess') ? 1 : 0;
        }
        else{
            $assignViewAccess = 1;
        }///////////////////////////////////////////

        $user->removeRole($user->role_id);
        if($request['agentLeader'] != null){
            $parent = $request['agentLeader'];
        } elseif($request['beraterLeader'] != null) {
            $parent = $request['beraterLeader'];
        } elseif($request['callCenterDirektor'] != null){
            $parent = $request['callCenterDirektor'];
        } elseif($request['brokerDirektor'] != null){
            $parent = $request['brokerDirektor'];
        }elseif($request['qualityDirektor'] != null){
            $parent = $request['qualityDirektor'];
        } else {
            $parent = Auth::user()->id;
        }

        if($request['selectedCallCenterDirektor'] != null){
            $direktor = $request['selectedCallCenterDirektor'];
        } elseif($request['selectedBrokerDirektor'] != null) {
            $direktor = $request['selectedBrokerDirektor'];
        } elseif($request['callCenterDirektor'] != null){
            $direktor = $request['callCenterDirektor'];
        } elseif($request['brokerDirektor'] != null){
            $direktor = $request['brokerDirektor'];
        }elseif($request['callCenterAdmin'] != null){
            $direktor = $request['callCenterAdmin'];
        }elseif($request['beraterAdmin'] != null){
            $direktor = $request['beraterAdmin'];
        }elseif($request['qualityDirektor'] != null){
            $direktor = $request['qualityDirektor'];
        }else {
            $direktor = Auth::user()->id;
        }

        if($request['username'] != null){
            $email = $request['username'];
        }
        else{
            $email = $request['email'];
        }


  // Role Validation

        if(Auth::user()->hasRole('Administrator')){
            $role = $request['role_id'];
        }
        elseif(Auth::user()->hasRole('Call Center Admin')){
            if($request['role_id'] == 2 || $request['role_id'] == 4 || $request['role_id'] == 5 || $request['role_id'] == 7 || $request['role_id'] == 9){
                $role = $request['role_id'];
            }
            else{
                Redirect::route('edit.user', $user->id)->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Berater Admin')){
            if($request['role_id'] == 3 || $request['role_id'] == 6 || $request['role_id'] == 8 || $request['role_id'] == 10){
                $role = $request['role_id'];
            }
            else{
                Redirect::route('edit.user', $user->id)->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Broker Direktor')){
            if($request['role_id'] == 6 || $request['role_id'] == 8 || $request['role_id'] == 3){
                $role = $request['role_id'];
            }
            else{
                Redirect::route('edit.user', $user->id)->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Call Center Direktor')){
            if($request['role_id'] == 4 || $request['role_id'] == 5 || $request['role_id'] == 7 || $request['role_id'] == 2){
                $role = $request['role_id'];
            }
            else{
                Redirect::route('edit.user', $user->id)->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Agent Team Leader')){
            if($request['role_id'] == 7 || $request['role_id'] == 4){
                $role = $request['role_id'];
            }
            else{
                Redirect::route('edit.user', $user->id)->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Berater Team Leader')){
            if($request['role_id'] == 8 || $request['role_id'] == 6){
                $role = $request['role_id'];
            }
            else{
                Redirect::route('edit.user', $user->id)->send()->with('errorRegister', 'Something went wrong');
            }
        }
    ///// User cannot change role id himself
        if($user->id == Auth::user()->id){
            $role = $user->role_id;
        }///////////////////////////////////

        $qualityLeader = '';
        if (request()->has('qualityLeader')) {
            $qualityLeader = $request['qualityLeader'];
        }

        $user->update([
            'role_id' => $role,
            'created_by' => $parent,
            'direktor' => $direktor,
            'quality_responsibility' => $qualityLeader,
            'ip_address' => $request['ip_address'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone_number' => $request['phone_number'],
            'email' => $email,
            'password' => $password,
            'company_name' => $request['company_name'],
            'assign_view_access' => $assignViewAccess,
        ]);
        $user->assignRole($role);

        if ($user) {
            return redirect()->route('showUsers')->with('updateSuccessfully', 'Benutzer wurde erfolgreich aktualisiert');
        }
        return redirect()->route('edit.user', $user->id)->with('updateError', 'User has not been updated! Please try again');
    }

    public function storePartners(Request $request){
        if($request['first_partner'] && $request['second_partner'] != null){
           $firstPartnerNameFind = User::where('id', $request['first_partner'])
            ->select('first_name', 'last_name')->first();

            $secondPartnerNameFind = User::where('id', $request['second_partner'])
            ->select('first_name', 'last_name')->first();

            $firstPartnerName = $firstPartnerNameFind->first_name . ' ' . $firstPartnerNameFind->last_name;
            $secondPartnerName = $secondPartnerNameFind->first_name . ' ' . $secondPartnerNameFind->last_name;

        }else{
            Redirect::back()->send()->with('errorPartner', 'Something Went wrong');
        }


        $directorExist = DirectorPartner::where('first_partner', $request['first_partner'])
        ->where('second_partner', $request['second_partner'])->count();

        if($directorExist == 0){
            DirectorPartner::create([
                'first_partner_name' => $firstPartnerName,
                'second_partner_name' => $secondPartnerName,
                'first_partner' => $request['first_partner'],
                'second_partner' => $request['second_partner']
            ]);
            return back()->with('successPartner', 'Partner Registred Successfully');
        }else{
            Redirect::back()->send()->with('errorPartner', 'This partner already exists');
        }
    }

    public function indexPartners(){

        $users = User::where('role_id', 2)->orWhere('role_id', 3)->get();
        $ccdirektors = User::role('Call Center Direktor')->get();
        $brdirektors = User::role('Broker Direktor')->get();
        return view('users.partnerIndex', ['users' => $users, 'ccdirektors' => $ccdirektors, 'brdirektors' => $brdirektors,]);
    }

    public function dataTablePartners(){
        if (Auth::user()->hasRole('Administrator')) {
            $query = DB::table('director_partners')
            ->select('director_partners.*');
        } elseif (Auth::user()->hasRole('Call Center Admin')) {
            $query = DB::table('director_partners')
            ->leftJoin('users as partner', 'director_partners.first_partner', '=', 'partner.id')
            ->select('director_partners.*', 'partner.country as country')
            ->where('country', 'Call Center');
        } elseif (Auth::user()->hasRole('Berater Admin')) {
            $query = DB::table('director_partners')
            ->leftJoin('users as partner', 'director_partners.first_partner', '=', 'partner.id')
            ->select('director_partners.*', 'partner.country as country')
            ->where('country', 'Broker');
        }

        if (Auth::user()->hasRole('Administrator')) {
            return (new QueryDataTable($query))
            ->addColumn('buttons', '<a href="#" class="btn btn-outline-danger deletePartner"> {{ __("Delete") }} </a>')
            ->rawColumns(['buttons',])
            ->setRowId('{{ $id }}')
            ->toJson();
        } else {
            return (new QueryDataTable($query))
            ->setRowId('{{ $id }}')
            ->toJson();
        }
    }

    public function deleteCompanyLogo(User $user, $company_logo){
        $file_path = public_path('uploads/'.$company_logo);//storage
        unlink($file_path);
        Storage::delete($file_path);
        $user->update(['company_logo' => null]);
        if ($user) {
            return '{}';
        }
    }

    public function uploadCompanyLogo( User $user, Request $request){
        $files = $request->file('company_logo');
        $photo = '';
        if (!empty($files)) {
            $name = date('dmY_His_').$files->getClientOriginalName();
            Storage::disk('public_uploads')->put($name, file_get_contents($files));
            $photo = $name;
        }
        $user->update(['company_logo' => $photo]);
        return '{}';
    }

    public function destroy(User $user){
        $user->delete();
        if($user){
            $message = 'User Deleted Successfully';
        }
        echo $message;
    }

    public function destroyPartners(DirectorPartner $DirectorPartner){
        $DirectorPartner->delete();
    }

}

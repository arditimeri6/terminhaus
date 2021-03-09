<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'role_id' => ['required'],
            'first_name' => ['required', 'string', 'max:25', 'regex:/[a-z]/', 'regex:/[A-Z]/'],
            'last_name' => ['required', 'string', 'max:25', 'regex:/[a-z]/', 'regex:/[A-Z]/'],
            'phone_number' => ['nullable', 'string', 'max:25'],
            'username' => ['nullable', 'string', 'max:20', 'unique:users,email'],
            'email' => ['nullable', 'string', 'email', 'max:30', 'unique:users'],
            'country' => ['required','in:1,2,3'],
            'ip_address' => ['max:20'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            'password_confirmation' => ['sometimes', 'nullable', 'string', 'min:8']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /////////Call Center Direktor assign view access
        if($data['role_id'] == 2){
            $assignViewAccess = request()->has('assignAccess') ? 1 : 0;
        }
        else{
            $assignViewAccess = 1;
        }/////////////////////////////////////////////

        $photo = '';
        if (array_get($data, 'company_logo', false)) {
            $files = $data['company_logo'];
            if (!empty($files)) {
                $name = date('dmY_His_').$files->getClientOriginalName();
                Storage::disk('public_uploads')->put($name, file_get_contents($files));
                $photo = $name;
            }
        }

        // dd($data);
        if(request()->has('agentLeader')){
            $parent = $data['agentLeader'];
        } elseif(request()->has('beraterLeader')) {
            if ($data['beraterLeader'] == null) {
                $parent = $data['selectedBrokerDirektor'];
            } else {
                $parent = $data['beraterLeader'];
            }
        } elseif($data['callCenterDirektor'] != null){
            $parent = $data['callCenterDirektor'];
        } elseif($data['brokerDirektor'] != null){
            $parent = $data['brokerDirektor'];
        } elseif($data['qualityDirektor'] != null){
            $parent = $data['qualityDirektor'];
        } else {
            $parent = Auth::user()->id;
        }

        if($data['selectedCallCenterDirektor'] != null){
            $direktor = $data['selectedCallCenterDirektor'];
        } elseif($data['selectedBrokerDirektor'] != null) {
            $direktor = $data['selectedBrokerDirektor'];
        } elseif($data['callCenterDirektor'] != null){
            $direktor = $data['callCenterDirektor'];
        } elseif($data['brokerDirektor'] != null){
            $direktor = $data['brokerDirektor'];
        } elseif($data['callCenterAdmin'] != null){
            $direktor = $data['callCenterAdmin'];
        } elseif($data['beraterAdmin'] != null){
            $direktor = $data['beraterAdmin'];
        } elseif($data['qualityDirektor'] != null){
            $direktor = $data['qualityDirektor'];
        }else {
            $direktor = Auth::user()->id;
        }

        if ($data['password']) {
            $password = Hash::make($data['password']);
            $status = Carbon::now();
        } else {
            $password = null;
            $status = null;
        }
        if($data['username'] != null){
            $email = $data['username'];
        }
        else{
            $email = $data['email'];
        }

        $country = $data['country'];
        if($country == 1) {
            $country = 'Call Center';
        }elseif($country == 2) {
            $country = 'Broker';
        }else{
            $country = null;
        }
        if($data['virtual_user'] == 1){
            $virtual = 0;
        }
        else{
            $virtual = 1;
        }

        // Role Validation

        if(Auth::user()->hasRole('Administrator')){
            $role = $data['role_id'];
        }
        elseif(Auth::user()->hasRole('Call Center Admin')){
            if($data['role_id'] == 2 || $data['role_id'] == 4 || $data['role_id'] == 5 || $data['role_id'] == 7 || $data['role_id'] == 11){
                $role = $data['role_id'];
            }
            else{
                Redirect::to('/register')->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Berater Admin')){
            if($data['role_id'] == 3 || $data['role_id'] == 6 || $data['role_id'] == 8){
                $role = $data['role_id'];
            }
            else{
                Redirect::to('/register')->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Broker Direktor')){
            if($data['role_id'] == 6 || $data['role_id'] == 8){
                $role = $data['role_id'];
            }
            else{
                Redirect::to('/register')->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Call Center Direktor')){
            if($data['role_id'] == 4 || $data['role_id'] == 5 || $data['role_id'] == 7 || $data['role_id'] == 11){
                $role = $data['role_id'];
            }
            else{
                Redirect::to('/register')->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Agent Team Leader')){
            if($data['role_id'] == 7 || $data['role_id'] == 11){
                $role = $data['role_id'];
            }
            else{
                Redirect::to('/register')->send()->with('errorRegister', 'Something went wrong');
            }
        }
        elseif(Auth::user()->hasRole('Berater Team Leader')){
            if($data['role_id'] == 8){
                $role = $data['role_id'];
            }
            else{
                Redirect::to('/register')->send()->with('errorRegister', 'Something went wrong');
            }
        }
        $qualityLeader = '';
        if (request()->has('qualityLeader')) {
            $qualityLeader = $data['qualityLeader'];
        }

        $companyName = User::where('id', $direktor)->get()->first();
        // dd($companyName);
        $finalCompanyName = '';
        if ($data['company_name'] != null) {
            $finalCompanyName = $data['company_name'];
        } else {
            if ($companyName->company_name != null) {
                $finalCompanyName = $companyName->company_name;
            }
        }

        $user = User::create([
                'role_id' => $role,
                'created_by' => $parent,
                'direktor' => $direktor,
                'quality_responsibility' => $qualityLeader,
                'ip_address' => $data['ip_address'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone_number' => $data['phone_number'],
                'email' => $email,
                'password' => $password,
                'company_name' => $finalCompanyName,
                'company_logo' => $photo,
                'status' => $status,
                'virtual' => $virtual,
                'country' => $country,
                'assign_view_access' => $assignViewAccess,
            ]);

        $user->assignRole($data['role_id']);

        if (!$data['password']) {
            $credentials = ['email' => $data['email']];
            $response = Password::sendResetLink($credentials, function (Message $message) {
                $message->subject($this->getEmailSubject());
            });

            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return redirect()->back()->with('status', trans($response));
                case Password::INVALID_USER:
                    return redirect()->back()->withErrors(['email' => trans($response)]);
            }
        }

        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = event(new Registered($user = $this->create($request->all())));

        if ($user) {
            return redirect('/users')->with('successRegister', 'User added successfully');
        }
        return redirect('/register')->with('errorRegister', 'User was not added');
    }

    public function showRegistrationForm()
    {
        $callCenterDirektors = User::role('Call Center Direktor')->get();
        $brokerDirektors = User::role('Broker Direktor')->get();
        $callCenterAdmins = User::role('Call Center Admin')->get();
        $beraterAdmins = User::role('Berater Admin')->get();

        // dd($beraterAdmin);
        return view('auth.register', ['callCenterDirektors' => $callCenterDirektors, 'brokerDirektors' => $brokerDirektors,
                                      'callCenterAdmins' => $callCenterAdmins, 'beraterAdmins' => $beraterAdmins]);
    }

    public function searchLeaders(Request $request)
    {
        $value = $request['value'];
        $data = User::where('created_by', $value)->role('Agent Team Leader')->get();
        $output = '<option value="">Agent wählen</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->first_name. ' ' . $row->last_name.'</option>';
        }
        echo $output;
    }
    public function searchBeraters(Request $request)
    {
        $value = $request['value'];
        $data = User::where('created_by', $value)->role('Berater Team Leader')->get();
        $output = '<option value="">Berater wählen</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->first_name. ' ' . $row->last_name.'</option>';
        }
        echo $output;
    }
    public function searchQuality(Request $request)
    {
        $value = $request['value'];
        $data = User::where('created_by', $value)->role('Agent Team Leader')->get();
        // $output = '<option value="">Agent wählen</option>';
        $output = '<option value="all">All of CC</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->first_name. ' ' . $row->last_name.'</option>';
        }
        echo $output;
    }
}

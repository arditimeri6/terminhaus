@extends('layouts.app')

@section('content')
<script src="{{ asset('js/location/de.js') }}"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-white border-danger">{{ __('Register') }}</div>

                @if (session('errorRegister'))
                    <script>
                        toastr.error('{{ session('errorRegister') }}', {timeOut:5000})
                    </script>
                @endif
                @if ($errors->any())
                    @foreach($errors->all() as $error)
                        <script>
                            toastr.error('{{$error}}', {timeOut:50000})
                        </script>
                    @endforeach
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                            <div  @hasrole('Administrator|Call Center Admin|Berater Admin|Broker Direktor|Call Center Direktor') class="form-group row" @else class="hidden-field" @endhasrole>
                            <label for="virtual_user" class="col-md-4 col-form-label text-md-right">Virtual User</label>
                                <div class="col-md-6">
                                    <select name="virtual_user" id="virtual_user" class="form-control">
                                        <option value="1" {{ old('virtual_user') == 1 ? 'selected' : '' }}>No</option>
                                        <option value="2" {{ old('virtual_user') == 2 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right">Benutzertyp</label>

                                <div class="col-md-6">
                                    <select name="country" id="country" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}">
                                        <option value="0" {{ old('country') == 0 ? 'selected' : '' }}>Land auswählen</option>
                                    @hasrole('Administrator|Call Center Direktor|Agent Team Leader|Call Center Admin')
                                        <option value="1" {{ old('country') == 1 ? 'selected' : '' }}>Call Center</option>
                                    @endhasrole
                                    @hasrole('Administrator|Broker Direktor|Berater Team Leader|Berater Admin')
                                        <option value="2" {{ old('country') == 2 ? 'selected' : '' }}>Broker</option>
                                    @endhasrole
                                    @hasrole('Administrator') <option value="3" {{ old('country') == 3 ? 'selected' : '' }} >Administrator</option> @endhasrole
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="roles_section">
                                <label for="role_id" class="col-md-4 col-form-label text-md-right">Arbeitsposition</label>

                                <div class="col-md-6">
                                    <select name="role_id" id="role_id" class="form-control">
                                        <option value="" id="default_role">Select Role</option>
                                        @hasrole('Administrator') <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }} >Administrator</option> @endhasrole
                                        @hasrole('Administrator') <option value="9" id="cc_admin" {{ old('role_id') == 9 ? 'selected' : '' }} >Call Center Admin</option> @endhasrole
                                        @hasrole('Administrator') <option value="10" id="berater_admin" {{ old('role_id') == 10 ? 'selected' : '' }} >Berater Admin</option> @endhasrole
                                        @hasrole('Administrator|Call Center Admin') <option id="cc_direktor" value="2" {{ old('role_id') == 2 ? 'selected' : '' }} >Call Center Direktor</option> @endhasrole
                                        @hasrole('Administrator|Berater Admin') <option id="broker_direktor" value="3" {{ old('role_id') == 3 ? 'selected' : '' }} >Broker Direktor</option> @endhasrole
                                        @hasrole('Administrator|Call Center Direktor|Call Center Admin') <option id="agent_teamleader" value="4" {{ old('role_id') == 4 ? 'selected' : '' }} >Agent Team Leader</option> @endhasrole
                                        @hasrole('Administrator|Call Center Direktor|Call Center Admin') <option id="quality_controll" value="5" {{ old('role_id') == 5 ? 'selected' : '' }} >Quality Controll</option> @endhasrole
                                        @hasrole('Administrator|Broker Direktor|Berater Admin') <option id="berater_teamleader" value="6" {{ old('role_id') == 6 ? 'selected' : '' }} >Berater Team Leader</option> @endhasrole
                                        @hasrole('Administrator|Call Center Direktor|Call Center Admin|Agent Team Leader') <option id="agents" value="7" {{ old('role_id') == 7 ? 'selected' : '' }} >Agent</option> @endhasrole
                                        @hasrole('Administrator|Broker Direktor|Berater Admin|Berater Team Leader') <option id="berater" value="8" {{ old('role_id') == 8 ? 'selected' : '' }} >Berater</option> @endhasrole
                                    </select>

                                    @if ($errors->has('role_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role_id') }}</strong>
                                        </span>
                                    @else
                                        <div class="invalid-feedback">
                                            <strong> Dieses Feld ist erforderlich </strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="ip_address" class="col-md-4 col-form-label text-md-right">IP Adresse</label>

                            <div class="col-md-6">
                                <input id="ip_address" type="text" class="form-control{{ $errors->has('ip_address') ? ' is-invalid' : '' }}" name="ip_address" value="{{ old('ip_address') }}" autofocus>

                                @if ($errors->has('ip_address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ip_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">Vorname</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">Nachname</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row phone_number">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-right">Mobile Nummer</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" required autofocus>

                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="email_input">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail-Adresse') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" >

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="username_input">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" >

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row hidden-password hidden-field">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  name="password" data-toggle="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row hidden-confirm-password hidden-field">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm password</label>

                            <div class="col-md-6">
                                <input type="password" id="password-confirm" class="form-control" name="password_confirmation" data-toggle="password">
                            </div>
                        </div>

                        <div class="form-group row hidden-company hidden-field">
                            <label for="company_name" class="col-md-4 col-form-label text-md-right label-company">Company Name </label>

                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" value="{{ old('company_name') }}">

                                @if ($errors->has('company_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row hidden-company-logo hidden-field">
                            <label for="company_logo" class="col-md-4 col-form-label text-md-right">Company Logo </label>

                            <div class="col-md-6">
                                <input type="file" name="company_logo" id="fileUpload" accept="image/*"  class="form-control{{ $errors->has('company_logo') ? ' is-invalid' : '' }}"  value="{{ old('company_logo') }}">

                                @if ($errors->has('company_logo.*'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_logo.*') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row hidden-callCenterDirektor hidden-field">
                            <label for="callCenterDirektor" class="col-md-4 col-form-label text-md-right">Direktor</label>

                            <div class="col-md-6">
                                <select name="callCenterDirektor" id="callCenterDirektor" class="form-control">
                                    <option value="">Select Direktor</option>
                                    @foreach($callCenterDirektors as $callCenterDirektor)
                                        <option value="{{ $callCenterDirektor->id }}" {{ old('callCenterDirektor') == $callCenterDirektor->id ? 'selected' : '' }} >{{ $callCenterDirektor->first_name }} {{ $callCenterDirektor->last_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('callCenterDirektor'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('callCenterDirektor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row hidden-brokerDirektor hidden-field">
                            <label for="brokerDirektor" class="col-md-4 col-form-label text-md-right">Direktor</label>

                            <div class="col-md-6">
                                <select name="brokerDirektor" id="brokerDirektor" class="form-control">
                                    <option value="">Select Direktor</option>
                                    @foreach($brokerDirektors as $brokerDirektor)
                                        <option value="{{ $brokerDirektor->id }}" {{ old('brokerDirektor') == $brokerDirektor->id ? 'selected' : '' }} >{{ $brokerDirektor->first_name }} {{ $brokerDirektor->last_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('brokerDirektor'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('brokerDirektor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row hidden-agentDirektor hidden-field">
                            <label for="callCenterDirektor" class="col-md-4 col-form-label text-md-right">Direktor</label>
                            <div class="col-md-6">
                                <select name="selectedCallCenterDirektor" class="form-control dynamic" id="agentDirektor" data-dependent="leaders">
                                    <option value="">Select Direktor</option>
                                    @foreach($callCenterDirektors as $callCenterDirektor)
                                        <option value="{{ $callCenterDirektor->id }}" >{{ $callCenterDirektor->first_name }} {{ $callCenterDirektor->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row hidden-agentLeader hidden-field">
                            <label for="agentLeader" class="col-md-4 col-form-label text-md-right">Agent Team Leader</label>
                            <div class="col-md-6">
                                <select class="form-control" name="agentLeader" id="leaders">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row hidden-qualityDirektor hidden-field">
                            <label for="callCenterDirektor" class="col-md-4 col-form-label text-md-right">Direktor</label>
                            <div class="col-md-6">
                                <select name="qualityDirektor" class="form-control dynamicQuality" id="qualityDirektor" data-dependent="qualityLeaders">
                                    <option value="">Select Direktor</option>
                                    @foreach($callCenterDirektors as $callCenterDirektor)
                                        <option value="{{ $callCenterDirektor->id }}" >{{ $callCenterDirektor->first_name }} {{ $callCenterDirektor->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row hidden-qualityLeader hidden-field">
                            <label for="qualityLeader" class="col-md-4 col-form-label text-md-right">Agent Team Leader</label>
                            <div class="col-md-6">
                                <select class="form-control" name="qualityLeader" id="qualityLeaders">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row hidden-Broker hidden-field">
                            <label for="broker" class="col-md-4 col-form-label text-md-right">Direktor</label>
                            <div class="col-md-6">
                                <select name="selectedBrokerDirektor" class="form-control dynamicBerater" id="broker" data-dependent="beraters">
                                    <option value="">Select Direktor</option>
                                    @foreach($brokerDirektors as $brokerDirektor)
                                        <option value="{{ $brokerDirektor->id }}">{{ $brokerDirektor->first_name }} {{ $brokerDirektor->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row hidden-callCenterAdmin hidden-field">
                            <label for="broker" class="col-md-4 col-form-label text-md-right">Call Center Admin</label>
                            <div class="col-md-6">
                                <select name="callCenterAdmin" class="form-control" id="callCenterAdmin">
                                    <option value="">Select Call Center Admin</option>
                                    @foreach($callCenterAdmins as $callCenterAdmin)
                                        <option value="{{ $callCenterAdmin->id }}">{{ $callCenterAdmin->first_name }} {{ $callCenterAdmin->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row hidden-beraterAdmin hidden-field">
                            <label for="broker" class="col-md-4 col-form-label text-md-right">Berater Admin</label>
                            <div class="col-md-6">
                                <select name="beraterAdmin" class="form-control" id="beraterAdmin">
                                    <option value="">Select Berater Admin</option>
                                    @foreach($beraterAdmins as $beraterAdmin)
                                        <option value="{{ $beraterAdmin->id }}">{{ $beraterAdmin->first_name }} {{ $beraterAdmin->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row hidden-beraterLeader hidden-field">
                            <label for="beraterLeader" class="col-md-4 col-form-label text-md-right">Berater Team Leader</label>
                            <div class="col-md-6">
                                <select class="form-control" name="beraterLeader" id="beraters">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row hidden-field assignAccess">
                            <div class="col-md-5 offset-md-5 custom-control custom-checkbox">
                                <input id="assignAccess" checked type="checkbox" class="custom-control-input {{ $errors->has('assignAccess') ? ' is-invalid' : '' }}" name="assignAccess" {{ old('assignAccess') == 1 ? 'checked' : '' }} autofocus>
                                <label for="assignAccess" class="col-form-label custom-control-label custom-label">Permission to see assigned column</label>

                                @if ($errors->has('assignAccess'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('assignAccess') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-4 pl-5">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="submit" class="btn btn-outline-danger register-buttons mb-2">
                                            {{ __('Register') }}
                                </button>
                                <a href="{{ route('showUsers') }}"  class="btn btn-danger register-buttons mb-2 mr-2 float-left">
                                            {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
                }, false);
            });
            }, false);
        })();
        $('#roles_section').addClass('hidden-field')
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "2" || $("#role_id").val() === "3" || $("#role_id").val() === "9" || $("#role_id").val() === "10") {
                $('.hidden-company').removeClass('hidden-field')
                $('.hidden-company-logo').removeClass('hidden-field')
            } else {
                $('.hidden-company').addClass('hidden-field')
                $('.hidden-company-logo').addClass('hidden-field')
                $('input[name=company_name]').val('')
                $('input[name=company_logo]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "4") {
                $('.hidden-callCenterDirektor').removeClass('hidden-field')
            } else {
                $('.hidden-callCenterDirektor').addClass('hidden-field')
                $('select[name=callCenterDirektor]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "5") {
                $('.hidden-qualityDirektor').removeClass('hidden-field')
                $('.hidden-qualityLeader').removeClass('hidden-field')
            } else {
                $('.hidden-qualityDirektor').addClass('hidden-field')
                $('select[name=qualityDirektor]').val('')
                $('.hidden-qualityLeader').addClass('hidden-field')
                $('select[name=qualityLeader]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "6") {
                $('.hidden-brokerDirektor').removeClass('hidden-field')
            } else {
                $('.hidden-brokerDirektor').addClass('hidden-field')
                $('select[name=callCenterDirektor]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "7") {
                $('.hidden-agentDirektor').removeClass('hidden-field')
                $('.hidden-agentLeader').removeClass('hidden-field')
            } else {
                $('.hidden-agentDirektor').addClass('hidden-field')
                $('select[id=agentDirektor]').val('')
                $('.hidden-agentLeader').addClass('hidden-field')
                $('select[name=agentLeader]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "8") {
                $('.hidden-Broker').removeClass('hidden-field')
                $('.hidden-beraterLeader').removeClass('hidden-field')
            } else {
                $('.hidden-Broker').addClass('hidden-field')
                $('select[id=Broker]').val('')
                $('.hidden-beraterLeader').addClass('hidden-field')
                $('select[name=beraterLeader]').val('')
            }
        });

        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "2") {
                $('.hidden-callCenterAdmin').removeClass('hidden-field')
                $('.assignAccess').removeClass('hidden-field')
            }else{
                $('.hidden-callCenterAdmin').addClass('hidden-field')
                $('select[name=callCenterAdmin]').val('')
                $('.assignAccess').addClass('hidden-field')
            }
        });

        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "3") {
                $('.hidden-beraterAdmin').removeClass('hidden-field')
            }else{
                $('.hidden-beraterAdmin').addClass('hidden-field')
                $('select[name=beraterAdmin]').val('')
            }
        });

        $('#submit').click(function(){
            if($('#role_id').val() == "2"){
                $('#callCenterAdmin').prop('required', true)
            }else if($('#role_id').val() == "3"){
                $('#beraterAdmin').prop('required', true)
            }else if($('#role_id').val() == "2" || $('#role_id').val() == "3"){
                $('.label-company').text('Company Name')
                $('#company_name').prop('required', true)
            }else{
                $('#callCenterAdmin').prop('required', false)
                $('#beraterAdmin').prop('required', false)
                $('.label-company').text('Company Name (OPT)')
                $('#company_name').prop('required', false)
            }
        });

        $('#submit').click(function(){
            if(($("#country").val() === "1")&&($("#virtual_user").val() === "1")){
                $('#password').prop('required', true)
                $('#password-confirm').prop('required', true)
            }else if(($("#country").val() === "1")&&($("#virtual_user").val() === "2")){
                $('#password').prop('required', true)
                $('#password-confirm').prop('required', true)
            }else if(($("#country").val() === "1")&&($("#virtual_user").val() === "1")){
                $('#password').prop('required', true)
                $('#password-confirm').prop('required', true)
            }else if(($("#country").val() === "2")&&($("#virtual_user").val() === "2")){
                $('#password').prop('required', true)
                $('#password-confirm').prop('required', true)
            }else{
                $('#password').prop('required', false)
                $('#password-confirm').prop('required', false)
            }

            if($('#role_id').val() == 7) {
                $('#leaders').prop('required', true)
            } else {
                $('#leaders').prop('required', false)
            }
            if($('#role_id').val() == 5) {
                $('#qualityLeaders').prop('required', true)
            } else {
                $('#qualityLeaders').prop('required', false)
            }
            if($('#role_id').val() == 8) {
                // $('#beraters').prop('required', true)
            } else {
                // $('#beraters').prop('required', false)
            }
        });





//Virtual User Inputs
        $('#virtual_user').on('change', function() {

            if ($("#virtual_user").val() === "2") {
                //phone
                $('#phone_number').addClass('hidden-field')
                $('.phone_number').addClass('hidden-field')
                $('#phone_number').val(null)
                $('#username').val(null)
                //password
                $('.hidden-password').removeClass('hidden-field')
                $('.hidden-confirm-password').removeClass('hidden-field')
                //email
                $('#email_input').addClass('hidden-field')
                $('#email').val(null)
                $('#username_input').removeClass('hidden-field')
            }else if(($("#country").val() === "1")&&($("#virtual_user").val() === "1")){
                //password
                $('.hidden-password').removeClass('hidden-field')
                $('.hidden-confirm-password').removeClass('hidden-field')
                //email
                $('#email_input').removeClass('hidden-field')
                $('#username').val(null)
                $('#username_input').addClass('hidden-field')
                //phone
                $('#phone_number').removeClass('hidden-field')
                $('.phone_number').removeClass('hidden-field')
                $('#phone_number').val(null)
            }else {
                //phone
                $('#phone_number').removeClass('hidden-field')
                $('.phone_number').removeClass('hidden-field')
                $('#phone_number').val(null)
                //email
                $('#email_input').removeClass('hidden-field')
                $('#email').val(null)
                $('#username').val(null)
                $('#username_input').addClass('hidden-field')
                //password
                $('.hidden-password').addClass('hidden-field')
                $('#password').val('')
                $('.hidden-confirm-password').addClass('hidden-field')
                $('#password-confirm').val('')
            }
        });

// Country Users inputs
        $('#country').on('change', function() {
            if(($("#country").val() === "1")&&($("#virtual_user").val() === "1")){
                $('.hidden-password').removeClass('hidden-field')
                $('.hidden-confirm-password').removeClass('hidden-field')
                $('#broker_direktor').addClass('hidden-field')
                $('#berater_teamleader').addClass('hidden-field')
                $('#berater').addClass('hidden-field')
                $('#cc_direktor').removeClass('hidden-field')
                $('#agent_teamleader').removeClass('hidden-field')
                $('#quality_controll').removeClass('hidden-field')
                $('#agents').removeClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
                $('#berater_admin').addClass('hidden-field')
                $('#cc_admin').removeClass('hidden-field')
                // $('#leads_agent').removeClass('hidden-field')


            }
            else if (($("#country").val() === "1")&&($("#virtual_user").val() === "2")) {
                $('#broker_direktor').addClass('hidden-field')
                $('#berater_teamleader').addClass('hidden-field')
                $('#berater').addClass('hidden-field')
                $('#cc_direktor').removeClass('hidden-field')
                $('#agent_teamleader').removeClass('hidden-field')
                $('#quality_controll').removeClass('hidden-field')
                $('#agents').removeClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
                $('#berater_admin').addClass('hidden-field')
                $('#cc_admin').removeClass('hidden-field')
                // $('#leads_agent').removeClass('hidden-field')

            } else if($("#country").val() === "0") {
                $('#roles_section').addClass('hidden-field')
            }

            else if (($("#country").val() === "2")&&($("#virtual_user").val() === "1")) {
                $('.hidden-password').addClass('hidden-field')
                $('#password').val('')
                $('.hidden-confirm-password').addClass('hidden-field')
                $('#password-confirm').val('')
                $('#cc_direktor').addClass('hidden-field')
                $('#agent_teamleader').addClass('hidden-field')
                $('#quality_controll').addClass('hidden-field')
                $('#agents').addClass('hidden-field')
                $('#broker_direktor').removeClass('hidden-field')
                $('#berater_teamleader').removeClass('hidden-field')
                $('#berater').removeClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
                $('#berater_admin').removeClass('hidden-field')
                $('#cc_admin').addClass('hidden-field')
                // $('#leads_agent').addClass('hidden-field')

            }
            else if (($("#country").val() === "2")&&($("#virtual_user").val() === "2")) {
                $('#password').val('')
                $('#password-confirm').val('')
                $('#cc_direktor').addClass('hidden-field')
                $('#agent_teamleader').addClass('hidden-field')
                $('#quality_controll').addClass('hidden-field')
                $('#agents').addClass('hidden-field')
                $('#broker_direktor').removeClass('hidden-field')
                $('#berater_teamleader').removeClass('hidden-field')
                $('#berater').removeClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
                $('#berater_admin').removeClass('hidden-field')
                $('#cc_admin').addClass('hidden-field')
                // $('#leads_agent').addClass('hidden-field')
            }
            else {
                $('.hidden-password').addClass('hidden-field')
                $('#password').val('')
                $('.hidden-confirm-password').addClass('hidden-field')
                $('#password-confirm').val('')
                $('#cc_direktor').addClass('hidden-field')
                $('#agent_teamleader').addClass('hidden-field')
                $('#quality_controll').addClass('hidden-field')
                $('#agents').addClass('hidden-field')
                $('#broker_direktor').removeClass('hidden-field')
                $('#berater_teamleader').removeClass('hidden-field')
                $('#berater').removeClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
                $('#berater_admin').removeClass('hidden-field')
                $('#cc_admin').addClass('hidden-field')

            }
        });
        if ($("#role_id").val() === "2" || $("#role_id").val() === "3" || $("#role_id").val() === "9" || $("#role_id").val() === "10") {
            $('.hidden-company').removeClass('hidden-field')
            $('.hidden-company-logo').removeClass('hidden-field')
        } else {
            $('.hidden-company').addClass('hidden-field')
            $('.hidden-company-logo').addClass('hidden-field')
            $('input[name=company_name]').val('')
            $('input[name=company_logo]').val('')
        }
        if ($("#role_id").val() === "4") {
            $('.hidden-callCenterDirektor').removeClass('hidden-field')
        } else {
            $('.hidden-callCenterDirektor').addClass('hidden-field')
            $('select[name=direktor]').val('')
        }
        if ($("#role_id").val() === "5") {
            $('.hidden-qualityDirektor').removeClass('hidden-field')
            $('.hidden-qualityLeader').removeClass('hidden-field')
        } else {
            $('.hidden-qualityDirektor').addClass('hidden-field')
            $('select[name=qualityDirektor]').val('')
            $('.hidden-qualityLeader').addClass('hidden-field')
            $('select[name=qualityLeader]').val('')
        }
        if ($("#role_id").val() === "6") {
            $('.hidden-brokerDirektor').removeClass('hidden-field')
        } else {
            $('.hidden-brokerDirektor').addClass('hidden-field')
            $('select[name=direktor]').val('')
        }
        if ($("#role_id").val() === "7") {
            $('.hidden-agentDirektor').removeClass('hidden-field')
            $('.hidden-agentLeader').removeClass('hidden-field')
        } else {
            $('.hidden-agentDirektor').addClass('hidden-field')
            $('select[id=agentDirektor]').val('')
            $('.hidden-agentLeader').addClass('hidden-field')
            $('select[name=agentLeader]').val('')
        }
        if ($("#role_id").val() === "8") {
            $('.hidden-Broker').removeClass('hidden-field')
            $('.hidden-beraterLeader').removeClass('hidden-field')
        } else {
            $('.hidden-Broker').addClass('hidden-field')
            $('select[id=broker]').val('')
            $('.hidden-beraterLeader').addClass('hidden-field')
            $('select[name=beraterLeader]').val('')
        }
        if ($("#role_id").val() === "2") {
            $('.assignAccess').removeClass('hidden-field')
            $('.hidden-callCenterAdmin').removeClass('hidden-field')
        } else{
            $('.hidden-callCenterAdmin').addClass('hidden-field')
            $('select[name=callCenterAdmin]').val('')
            $('.assignAccess').addClass('hidden-field')
        }
        if ($("#role_id").val() === "3") {
            $('.hidden-beraterAdmin').removeClass('hidden-field')
        } else{
            $('.hidden-beraterAdmin').addClass('hidden-field')
            $('select[name=beraterAdmin]').val('')
        }
        if ($("#virtual_user").val() === "2") {
            $('.hidden-password').removeClass('hidden-field')
            $('.hidden-confirm-password').removeClass('hidden-field')
        } else {
            $('.hidden-password').addClass('hidden-field')
            $('.hidden-confirm-password').addClass('hidden-field')
        }
        $('.dynamic').change( function() {
            if($(this).val() != ''){
                var select = $(this).attr('id');
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('select.leader') }}",
                    method: "POST",
                    data: {
                        select:select,
                        value:value,
                        _token:_token,
                        dependent:dependent,
                    },
                    success: function(result) {
                        $('#'+dependent).html(result);
                    },

                })
            }
        });

        $('.dynamicBerater').change( function() {
            if($(this).val() != ''){
                var select = $(this).attr('id');
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('select.berater') }}",
                    method: "POST",
                    data: {
                        select:select,
                        value:value,
                        _token:_token,
                        dependent:dependent,
                    },
                    success: function(result) {
                        $('#'+dependent).html(result);
                    },

                })
            }
        });
        $('.dynamicQuality').change( function() {
            if($(this).val() != ''){
                var select = $(this).attr('id');
                var value = $(this).val();
                // console.log(value)
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('select.quality') }}",
                    method: "POST",
                    data: {
                        select:select,
                        value:value,
                        _token:_token,
                        dependent:dependent,
                    },
                    success: function(result) {
                        $('#'+dependent).html(result);
                    },

                })
            }
        });

        // Required email and username
        $('#submit').click(function(){
            if($('#virtual_user').val() == "2"){
                $('#email').prop('required', false);
                $('#username').prop('required', true);
                $('#phone_number').prop('required', false);
            }
            if($('#virtual_user').val() != "2"){
                $('#email').prop('required', true);
                $('#username').prop('required', false);
                $('#phone_number').prop('required', true);
            }
        });

// Company Input Optional for Call Center Admin
        $('#role_id').on('change', function() {
            if($('#role_id').val() == "2" || $('#role_id').val() == "3"){
                $('.label-company').text('Company Name')
                $('#company_name').prop('required', true)
            }
            else{
                $('.label-company').text('Company Name (OPT)')
                $('#company_name').prop('required', false)
            }
        });


    if(($("#country").val() === "1")&&($("#virtual_user").val() === "1")){
                $('.hidden-password').removeClass('hidden-field')
                $('.hidden-confirm-password').removeClass('hidden-field')
                $('#broker_direktor').addClass('hidden-field')
                $('#berater_teamleader').addClass('hidden-field')
                $('#berater').addClass('hidden-field')
                $('#cc_direktor').removeClass('hidden-field')
                $('#agent_teamleader').removeClass('hidden-field')
                $('#quality_controll').removeClass('hidden-field')
                $('#agents').removeClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
                $('#cc_admin').removeClass('hidden-field')
                $('#berater_admin').addClass('hidden-field')

            }
            else if (($("#country").val() === "1")&&($("#virtual_user").val() === "2")) {
                $('#broker_direktor').addClass('hidden-field')
                $('#berater_teamleader').addClass('hidden-field')
                $('#berater').addClass('hidden-field')
                $('#cc_direktor').removeClass('hidden-field')
                $('#agent_teamleader').removeClass('hidden-field')
                $('#quality_controll').removeClass('hidden-field')
                $('#agents').removeClass('hidden-field')
                $('#cc_admin').removeClass('hidden-field')
                $('#berater_admin').addClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
            } else if($("#country").val() === "0") {
                $('#roles_section').addClass('hidden-field')
            }
            else if (($("#country").val() === "2")&&($("#virtual_user").val() === "1")) {
                $('.hidden-password').addClass('hidden-field')
                $('#password').val('')
                $('.hidden-confirm-password').addClass('hidden-field')
                $('#password-confirm').val('')
                $('#cc_direktor').addClass('hidden-field')
                $('#agent_teamleader').addClass('hidden-field')
                $('#quality_controll').addClass('hidden-field')
                $('#agents').addClass('hidden-field')
                $('#broker_direktor').removeClass('hidden-field')
                $('#berater_teamleader').removeClass('hidden-field')
                $('#berater').removeClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
                $('#cc_admin').addClass('hidden-field')
                $('#berater_admin').removeClass('hidden-field')


            }
            else if (($("#country").val() === "2")&&($("#virtual_user").val() === "2")) {
                $('#password').val('')
                $('#password-confirm').val('')
                $('#cc_direktor').addClass('hidden-field')
                $('#agent_teamleader').addClass('hidden-field')
                $('#quality_controll').addClass('hidden-field')
                $('#agents').addClass('hidden-field')
                $('#broker_direktor').removeClass('hidden-field')
                $('#berater_teamleader').removeClass('hidden-field')
                $('#berater').removeClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
                $('#cc_admin').addClass('hidden-field')
                $('#berater_admin').removeClass('hidden-field')


            }
            else {
                $('.hidden-password').addClass('hidden-field')
                $('#password').val('')
                $('.hidden-confirm-password').addClass('hidden-field')
                $('#password-confirm').val('')
                $('#cc_direktor').addClass('hidden-field')
                $('#agent_teamleader').addClass('hidden-field')
                $('#quality_controll').addClass('hidden-field')
                $('#agents').addClass('hidden-field')
                $('#cc_admin').addClass('hidden-field')
                $('#broker_direktor').removeClass('hidden-field')
                $('#berater_teamleader').removeClass('hidden-field')
                $('#berater').removeClass('hidden-field')
                $('#roles_section').removeClass('hidden-field')
                $('#berater_admin').removeClass('hidden-field')

            }

//Administrator Position Select
            $('#country').on('change', function(){

                if($('#country').val() == '3'){
                    $('.hidden-password').removeClass('hidden-field')
                    $('.hidden-confirm-password').removeClass('hidden-field')
                    $("#role_id").prop("selectedIndex", 1);
                    $("#role_id option[value!='1']").addClass('hidden-field');
                    $("#role_id option[value='1']").removeClass('hidden-field');
                    $('#roles_section').removeClass('hidden-field')
                    $('.hidden-callCenterAdmin').addClass('hidden-field');
                    $('.hidden-callCenterDirektor').addClass('hidden-field');
                    $('.hidden-beraterAdmin').addClass('hidden-field');
                    $('.hidden-company').addClass('hidden-field');
                    $('.hidden-company-logo').addClass('hidden-field');
                    $('.hidden-brokerDirektor').addClass('hidden-field');
                    $('.hidden-agentLeader').addClass('hidden-field');
                    $('.hidden-Broker').addClass('hidden-field');
                }
                else{
                    $("#role_id option[value!='1']").remove('hidden-field');
                    $("#role_id option[value='1']").addClass('hidden-field');
                    $("#role_id").prop("selectedIndex", 0);
                }
            });

            $('#default_role').hide();
            if($('#country').val() == '3'){
                $('.hidden-password').removeClass('hidden-field')
                    $('.hidden-confirm-password').removeClass('hidden-field')
                    $("#role_id").prop("selectedIndex", 1);
                    $("#role_id option[value!='1']").addClass('hidden-field');
                    $("#role_id option[value='1']").removeClass('hidden-field');
                    $('#roles_section').removeClass('hidden-field')
                    $('.hidden-callCenterAdmin').addClass('hidden-field');
                    $('.hidden-callCenterDirektor').addClass('hidden-field');
                    $('.hidden-beraterAdmin').addClass('hidden-field');
                    $('.hidden-company').addClass('hidden-field');
                    $('.hidden-company-logo').addClass('hidden-field');
                    $('.hidden-brokerDirektor').addClass('hidden-field');
                    $('.hidden-agentLeader').addClass('hidden-field');
                    $('.hidden-Broker').addClass('hidden-field');
                }
            $('#username_input').addClass('hidden-field')
            $("#role_id option[value='1']").addClass('hidden-field');

            if ($("#virtual_user").val() === "2") {
                //phone
                $('#phone_number').addClass('hidden-field')
                $('.phone_number').addClass('hidden-field')
                $('#phone_number').val(null)
                $('#email_input').addClass('hidden-field')
                $('#email').val(null)
                $('#username_input').removeClass('hidden-field')
            }

        // ================ Image upload =================
        $("#fileUpload").fileinput({
            language: "de",
            theme: 'fa',
            allowedFileExtensions: ['jpg', 'png', 'jpeg'],
            overwriteInitial: false,
            maxFileSize:20000,
            maxFilesNum: 1,
            fileActionSettings: {showUpload: false},
            showUpload: false,
            // dropZoneEnabled: false,

            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        })// ================ Image upload ================

    </script>
@endsection

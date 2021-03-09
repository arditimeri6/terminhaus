@extends('layouts.app')

@section('content')
<script src="{{ asset('js/location/de.js') }}"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-white border-danger">Benutzer bearbeiten</div>

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
                    <div class="form-group row">
                        <label for="virtual_user" class="col-md-4 col-form-label text-md-right">Virtual User</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control" value="{{ $user->virtual ? 'Yes' : 'No'}}" disabled>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('update.user', $user->id) }}" class="needs-validation" novalidate>
                        @csrf

                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right">Benutzertyp</label>

                                <div class="col-md-6">
                                    <select name="country" id="country" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" disabled>
                                    @hasrole('Administrator|Call Center Direktor|Agent Team Leader|Call Center Admin')
                                        <option value="1" {{ $user->country == 'Call Center' ? 'selected' : '' }}>Call Center</option>
                                    @endhasrole
                                    @hasrole('Administrator|Broker Direktor|Berater Team Leader|Berater Admin')
                                        <option value="2" {{ $user->country == 'Broker' ? 'selected' : '' }}>Broker</option>
                                    @endhasrole
                                    @hasrole('Administrator') <option value="3" @if($user->hasrole('Administrator')) selected @endif  >Administrator</option> @endhasrole

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role_id" class="col-md-4 col-form-label text-md-right">Arbeitsposition</label>

                                <div class="col-md-6">
                                    <select name="role_id" id="role_id" class="form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}">
                                        @hasrole('Administrator') <option value="1" @if($user->hasrole('Administrator')) selected @endif >Administrator</option>@endhasrole
                                        @hasrole('Administrator|Call Center Admin') <option value="9" id="cc_admin" @if($user->hasrole('Call Center Admin')) selected @endif >Call Center Admin</option>@endhasrole
                                        @hasrole('Administrator|Berater Admin') <option value="10" id="berater_admin" @if($user->hasrole('Berater Admin')) selected @endif >Berater Admin</option>@endhasrole
                                        @hasrole('Administrator|Call Center Admin|Call Center Direktor') <option value="2" id="cc_direktor" @if($user->hasrole('Call Center Direktor')) selected @endif >Call Center Direktor</option>@endhasrole
                                        @hasrole('Administrator|Berater Admin|Broker Direktor')  <option value="3" id="broker_direktor" @if($user->hasrole('Broker Direktor')) selected @endif >Broker Direktor</option>@endhasrole
                                        @hasrole('Administrator|Call Center Direktor|Call Center Admin|Agent Team Leader') <option value="4" id="agent_teamleader" @if($user->hasrole('Agent Team Leader')) selected @endif >Agent Team Leader</option>@endhasrole
                                        @hasrole('Administrator|Call Center Direktor|Call Center Admin|Quality Controll')  <option value="5" id="quality_controll" @if($user->hasrole('Quality Controll')) selected @endif >Quality Controll</option>@endhasrole
                                        @hasrole('Administrator|Broker Direktor|Berater Admin|Berater Team Leader') <option value="6" id="berater_teamleader" @if($user->hasrole('Berater Team Leader')) selected @endif >Berater Team Leader</option>@endhasrole
                                        @hasrole('Administrator|Call Center Direktor|Call Center Admin|Agent Team Leader') <option value="7" id="agents" @if($user->hasrole('Agent')) selected @endif >Agent</option>@endhasrole
                                        @hasrole('Administrator|Broker Direktor|Berater Admin|Berater Team Leader') <option value="8" id="berater" @if($user->hasrole('Berater')) selected @endif >Berater</option>@endhasrole
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
                                <input id="ip_address" type="text" class="form-control{{ $errors->has('ip_address') ? ' is-invalid' : '' }}" name="ip_address" value="{{ $user->ip_address }}" autofocus>

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
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ $user->first_name }}" required autofocus>

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
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ $user->last_name }}" required autofocus>

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
                    @if($user->virtual != 1)
                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-right">Haus Nummer</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ $user->phone_number }}" required autofocus>

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
                    @endif
                    @if($user->virtual != 1)
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail-Adresse') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}">

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
                        @else
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ $user->email }}" required>

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
                    @endif
                        <div class="form-group row hidden-company hidden-field">
                            <label for="company_name" class="col-md-4 col-form-label text-md-right label-company">Company Name</label>

                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" value="{{ $user->company_name }}">

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
                                <input type="file" name="company_logo" id="fileUpload" accept="image/*"  class="form-control{{ $errors->has('company_logo') ? ' is-invalid' : '' }}" data-overwrite-initial="false">

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
                                        <option value="{{ $callCenterDirektor->id }}" @if($user->created_by == $callCenterDirektor->id) selected @endif >{{ $callCenterDirektor->first_name }} {{ $callCenterDirektor->last_name }}</option>
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
                                        <option value="{{ $brokerDirektor->id }}" @if($user->created_by == $brokerDirektor->id) selected @endif >{{ $brokerDirektor->first_name }} {{ $brokerDirektor->last_name }}</option>
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
                                        <option  value="{{ $callCenterDirektor->id }}" @if($user->direktor == $callCenterDirektor->id) selected @endif >{{ $callCenterDirektor->first_name }} {{ $callCenterDirektor->last_name }}</option>
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
                                        <option value="{{ $callCenterDirektor->id }}" @if($user->direktor == $callCenterDirektor->id) selected @endif >{{ $callCenterDirektor->first_name }} {{ $callCenterDirektor->last_name }}</option>
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
                                        <option value="{{ $brokerDirektor->id }}" @if($user->direktor == $brokerDirektor->id) selected @endif>{{ $brokerDirektor->first_name }} {{ $brokerDirektor->last_name }}</option>
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

                        @if($user->country=='Call Center')
                            <div class="form-group row hidden-password">
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

                            <div class="form-group row hidden-confirm-password">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm password</label>

                                <div class="col-md-6">
                                    <input type="password" id="password-confirm" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" data-toggle="password">
                                </div>
                            </div>
                        @endif

                        <div class="form-group row hidden-callCenterAdmin hidden-field">
                            <label for="broker" class="col-md-4 col-form-label text-md-right">Call Center Admin</label>
                            <div class="col-md-6">
                                <select name="callCenterAdmin" class="form-control dynamicBerater" id="callCenterAdmin" data-dependent="beraters">
                                    <option value="">Select Call Center Admin</option>
                                    @foreach($callCenterAdmins as $callCenterAdmin)
                                        <option value="{{ $callCenterAdmin->id }}" @if($user->direktor == $callCenterAdmin->id) selected @endif>{{ $callCenterAdmin->first_name }} {{ $callCenterAdmin->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row hidden-beraterAdmin hidden-field">
                            <label for="broker" class="col-md-4 col-form-label text-md-right">Berater Admin</label>
                            <div class="col-md-6">
                                <select name="beraterAdmin" class="form-control dynamicBerater" id="beraterAdmin" data-dependent="beraters">
                                    <option value="">Select Berater Admin</option>
                                    @foreach($beraterAdmins as $beraterAdmin)
                                        <option value="{{ $beraterAdmin->id }}" @if($user->direktor == $beraterAdmin->id) selected @endif>{{ $beraterAdmin->first_name }} {{ $beraterAdmin->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row hidden-field assignAccess">
                            <div class="col-md-5 offset-md-5 custom-control custom-checkbox">
                                <input id="assignAccess" type="checkbox" class="custom-control-input" name="assignAccess" {{$user->assign_view_access == 1 ? 'checked': ''}}>
                                <label for="assignAccess" class="col-form-label custom-control-label custom-label">Permission to see assing column</label>

                                @if ($errors->has('assignAccess'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('assignAccess') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-4 pl-5">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-danger register-buttons mb-2">
                                    Aktualisieren
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

        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "2" || $("#role_id").val() === "3") {
                if($("#role_id").val() === "2"){
                    $('.assignAccess').removeClass('hidden-field')
                    $('#callCenterAdmin').attr('required', true)
                } else {
                    $('#beraterAdmin').attr('required', true)
                }
                $('.hidden-company').removeClass('hidden-field')
                $('.hidden-company-logo').removeClass('hidden-field')
            } else {
                $('.assignAccess').addClass('hidden-field')
                $('#callCenterAdmin').attr('required', false)
                $('#beraterAdmin').attr('required', false)
                $('.hidden-company').addClass('hidden-field')
                $('.hidden-company-logo').addClass('hidden-field')
                $('input[name=company_name]').val('')
                $('input[name=company_logo]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "4") {
                $('.hidden-callCenterDirektor').removeClass('hidden-field')
                $('#callCenterDirektor').attr('required', true)
            } else {
                $('#callCenterDirektor').attr('required', false)
                $('.hidden-callCenterDirektor').addClass('hidden-field')
                $('select[name=callCenterDirektor]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "5") {
                $('.hidden-qualityDirektor').removeClass('hidden-field')
                $('#qualityDirektor').attr('required', true)
                $('.hidden-qualityLeader').removeClass('hidden-field')
                $('#qualityLeaders').attr('required', true)
            } else {
                $('#qualityDirektor').attr('required', false)
                $('.hidden-qualityDirektor').addClass('hidden-field')
                $('select[name=qualityDirektor]').val('')
                $('#qualityLeaders').attr('required', false)
                $('.hidden-qualityLeader').addClass('hidden-field')
                $('select[name=qualityLeader]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "6") {
                $('#brokerDirektor').attr('required', true)
                $('.hidden-brokerDirektor').removeClass('hidden-field')
            } else {
                $('#brokerDirektor').attr('required', false)
                $('.hidden-brokerDirektor').addClass('hidden-field')
                $('select[name=brokerDirektor]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "7") {
                $('#agentDirektor').attr('required', true)
                $('#leaders').attr('required', true)
                $('.hidden-agentDirektor').removeClass('hidden-field')
                $('.hidden-agentLeader').removeClass('hidden-field')
            } else {
                $('#agentDirektor').attr('required', false)
                $('#leaders').attr('required', false)
                $('.hidden-agentDirektor').addClass('hidden-field')
                $('select[id=agentDirektor]').val('')
                $('.hidden-agentLeader').addClass('hidden-field')
                $('select[name=agentLeader]').val('')
            }
        });
        $('#role_id').on('change', function() {
            if ($("#role_id").val() === "8") {
                $('#broker').attr('required', true)
                $('#beraters').attr('required', true)
                $('.hidden-Broker').removeClass('hidden-field')
                $('.hidden-beraterLeader').removeClass('hidden-field')
            } else {
                $('#broker').attr('required', false)
                $('#beraters').attr('required', false)
                $('.hidden-Broker').addClass('hidden-field')
                $('select[id=Broker]').val('')
                $('.hidden-beraterLeader').addClass('hidden-field')
                $('select[name=beraterLeader]').val('')
            }
        });
        if ($("#role_id").val() === "2" || $("#role_id").val() === "3") {
            if($("#role_id").val() === "2"){
                $('.assignAccess').removeClass('hidden-field')
                $('#callCenterAdmin').attr('required', true)
            } else {
                $('#beraterAdmin').attr('required', true)
            }
            $('.hidden-company').removeClass('hidden-field')
            $('.hidden-company-logo').removeClass('hidden-field')
        } else {
            $('.assignAccess').addClass('hidden-field')
            $('#callCenterAdmin').attr('required', false)
            $('#beraterAdmin').attr('required', false)
            $('.hidden-company').addClass('hidden-field')
            $('.hidden-company-logo').addClass('hidden-field')
            $('input[name=company_name]').val('')
            $('input[name=company_logo]').val('')
        }
        if ($("#role_id").val() === "4") {
            $('.hidden-callCenterDirektor').removeClass('hidden-field')
            $('#callCenterDirektor').attr('required', true)
        } else {
            $('#callCenterDirektor').attr('required', false)
            $('.hidden-callCenterDirektor').addClass('hidden-field')
            $('select[name=direktor]').val('')
        }
        if ($("#role_id").val() === "5") {
            $('.hidden-qualityDirektor').removeClass('hidden-field')
            $('#qualityDirektor').attr('required', true)
            $('.hidden-qualityLeader').removeClass('hidden-field')
            $('#qualityLeaders').attr('required', true)
        } else {
            $('#qualityDirektor').attr('required', false)
            $('.hidden-qualityDirektor').addClass('hidden-field')
            $('select[name=qualityDirektor]').val('')
            $('#qualityLeaders').attr('required', false)
            $('.hidden-qualityLeader').addClass('hidden-field')
            $('select[name=qualityLeader]').val('')
        }
        if ($("#role_id").val() === "6") {
            $('#brokerDirektor').attr('required', true)
            $('.hidden-brokerDirektor').removeClass('hidden-field')
        } else {
            $('#brokerDirektor').attr('required', false)
            $('.hidden-brokerDirektor').addClass('hidden-field')
            $('select[name=direktor]').val('')
        }
        if ($("#role_id").val() === "7") {
            $('#agentDirektor').attr('required', true)
            $('#leaders').attr('required', true)
            $('.hidden-agentDirektor').removeClass('hidden-field')
            $('.hidden-agentLeader').removeClass('hidden-field')
        } else {
            $('#agentDirektor').attr('required', false)
            $('#leaders').attr('required', false)
            $('.hidden-agentDirektor').addClass('hidden-field')
            $('select[id=agentDirektor]').val('')
            $('.hidden-agentLeader').addClass('hidden-field')
            $('select[name=agentLeader]').val('')
        }
        if ($("#role_id").val() === "8") {
            $('#broker').attr('required', true)
            $('#beraters').attr('required', true)
            $('.hidden-Broker').removeClass('hidden-field')
            $('.hidden-beraterLeader').removeClass('hidden-field')
        } else {
            $('#broker').attr('required', false)
            $('#beraters').attr('required', false)
            $('.hidden-Broker').addClass('hidden-field')
            $('select[id=broker]').val('')
            $('.hidden-beraterLeader').addClass('hidden-field')
            $('select[name=beraterLeader]').val('')
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

        if($('#agentDirektor').val() != ''){
            var select = $('#agentDirektor').attr('id');
            var value = $('#agentDirektor').val();
            var dependent = $('#agentDirektor').data('dependent');
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
                    $("#leaders option[value='"+{{ $user->created_by }}+"']").prop('selected', true)
                },

            })
        }

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

        if($('#broker').val() != ''){
            var select = $('#broker').attr('id');
            var value = $('#broker').val();
            var dependent = $('#broker').data('dependent');
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

                    $("#beraters option[value='"+{{ $user->created_by }}+"']").prop('selected', true)
                },

            })
        }

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

        if($('#qualityDirektor').val() != ''){
            var select = $('#qualityDirektor').attr('id');
            var value = $('#qualityDirektor').val();
            var dependent = $('#qualityDirektor').data('dependent');
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

                    $("#qualityLeaders option[value='{{ $user->quality_responsibility }}']").prop('selected', true)
                },

            })
        }

        $('#default_role').hide();


        $('#country').on('change', function() {
            $('#role_id').val('').prop('checked', true);
            if(($("#country").val() === "1")){
                $('#broker_direktor').addClass('hidden-field')
                $('#berater_teamleader').addClass('hidden-field')
                $('#berater').addClass('hidden-field')
                $('#cc_direktor').removeClass('hidden-field')
                $('#agent_teamleader').removeClass('hidden-field')
                $('#quality_controll').removeClass('hidden-field')
                $('#agents').removeClass('hidden-field')
                $('#berater_admin').addClass('hidden-field')
                $('#cc_admin').removeClass('hidden-field')
                // $('#leads_agent').removeClass('hidden-field')

            }

            else {
                $('#cc_direktor').addClass('hidden-field')
                $('#agent_teamleader').addClass('hidden-field')
                $('#quality_controll').addClass('hidden-field')
                $('#agents').addClass('hidden-field')
                $('#broker_direktor').removeClass('hidden-field')
                $('#berater_teamleader').removeClass('hidden-field')
                $('#berater').removeClass('hidden-field')
                $('#berater_admin').removeClass('hidden-field')
                $('#cc_admin').addClass('hidden-field')
                // $('#leads_agent').addClass('hidden-field')

            }

        });


        if(($("#country").val() === "1")){
                $('#broker_direktor').addClass('hidden-field')
                $('#berater_teamleader').addClass('hidden-field')
                $('#berater').addClass('hidden-field')
                $('#cc_direktor').removeClass('hidden-field')
                $('#agent_teamleader').removeClass('hidden-field')
                $('#quality_controll').removeClass('hidden-field')
                $('#agents').removeClass('hidden-field')
                $('#berater_admin').addClass('hidden-field')
                $('#cc_admin').removeClass('hidden-field')
                // $('#leads_agent').removeClass('hidden-field')

            }

            else {
                $('#cc_direktor').addClass('hidden-field')
                $('#agent_teamleader').addClass('hidden-field')
                $('#quality_controll').addClass('hidden-field')
                $('#agents').addClass('hidden-field')
                $('#broker_direktor').removeClass('hidden-field')
                $('#berater_teamleader').removeClass('hidden-field')
                $('#berater').removeClass('hidden-field')
                $('#berater_admin').removeClass('hidden-field')
                $('#cc_admin').addClass('hidden-field')
                // $('#leads_agent').addClass('hidden-field')

            }


// Call Center Admin  && Berater Admin Select
        if($('#role_id').val() == 2){
            $('.hidden-callCenterAdmin').removeClass('hidden-field')
        }
        else{
            $('.hidden-callCenterAdmin').addClass('hidden-field')
        }

        $('#role_id').on('change', function() {
            if($('#role_id').val() == 2){
                $('.hidden-callCenterAdmin').removeClass('hidden-field')
            }
            else{
                $('.hidden-callCenterAdmin').addClass('hidden-field')
            }
        });

        if($('#role_id').val() == 3){
                $('.hidden-beraterAdmin').removeClass('hidden-field')
            }
            else{
                $('.hidden-beraterAdmin').addClass('hidden-field')
            }

        $('#role_id').on('change', function() {
            if($('#role_id').val() == 3){
                $('.hidden-beraterAdmin').removeClass('hidden-field')
            }
            else{
                $('.hidden-beraterAdmin').addClass('hidden-field')
            }
        });

// End Call Center Admin  && Berater Admin Select


// Company Input Optional for Call Center Admin
        $('#role_id').on('change', function() {
         if($('#role_id').val() == '9' || $('#role_id').val() == '10' ){
            $('.hidden-company').removeClass('hidden-field')
            $('.hidden-company-logo').removeClass('hidden-field')
         }
        });

        if($('#role_id').val() == '9' || $('#role_id').val() == '10' ){
            $('.hidden-company').removeClass('hidden-field')
            $('.hidden-company-logo').removeClass('hidden-field')
            $('.label-company').text('Company Name (OPT)')
            $('#company_name').prop('required', false)
         }

 // Company Input Optional for Call Center Admin
        $('#role_id').on('change', function() {
            if($('#role_id').val() == '2' || $('#role_id').val() == '3'){
                $('.label-company').text('Company Name')
                $('#company_name').prop('required', true)
            }
            else{
                $('.label-company').text('Company Name (OPT)')
                $('#company_name').prop('required', false)
            }
        });


//Administrator Positon

//Administrator Position Select
    $('#country').on('change', function(){

        if($('#country').val() == '3'){
            $('.hidden-password').removeClass('hidden-field')
            $('.hidden-confirm-password').removeClass('hidden-field')
            $("#role_id").prop("selectedIndex", 1);
            $("#role_id option[value!='1']").addClass('hidden-field');
            $("#role_id option[value='1']").removeClass('hidden-field');
            $('#roles_section').removeClass('hidden-field')
        }
        else if($('#country').val() == '2'){
            $('.hidden-password').addClass('hidden-field')
            $('.hidden-confirm-password').addClass('hidden-field')
        }
        else{
            $("#role_id option[value!='1']").remove('hidden-field');
            $("#role_id option[value='1']").addClass('hidden-field');
            $("#role_id").prop("selectedIndex", 0);
            $('.hidden-password').removeClass('hidden-field')
            $('.hidden-confirm-password').removeClass('hidden-field')
        }
        });


        if($('#country').val() == '3'){
            $("#role_id").prop("selectedIndex", 1);
            $("#role_id option[value!='1']").addClass('hidden-field');
            $("#role_id option[value='1']").removeClass('hidden-field');
            $('#roles_section').removeClass('hidden-field')
        }

        else{
            $("#role_id option[value!='1']").remove('hidden-field');
            $("#role_id option[value='1']").addClass('hidden-field');
        }

        $('#default_role').hide();

        @hasrole('Agent Team Leader|Berater Team Leader')
            $('button[type=submit]').remove()
            $('input, option, select').attr('disabled', true)
        @endhasrole

        $('#agentDirektor').on('change', function() {
            if ($('#agentDirektor').val() == '') {
                $('#leaders').html('')
            }
        })
        $('#broker').on('change', function() {
            if ($('#broker').val() == '') {
                $('#beraters').html('')
            }
        })

        @unlessrole('Administtrator')
            /// user cannot change role for himself ///
            var ownUserId = '{{Auth::user()->id}}';
            var thisUserId = '{{$user->id}}';
            if(ownUserId === thisUserId ){
                $('#role_id').attr('readonly', true);
                $('#role_id option').hide()
            }
            else{
                $('#role_id option:first').remove()
            }
        @endunlessrole

        var image = null;
        @if($user->company_logo != null)
            image = '{{ url('uploads/' . $user->company_logo) }}';//storage
        @else
            image = null;
        @endif

    $("#fileUpload").fileinput({
        language: "de",
        initialPreview: [image],
        initialPreviewAsData: true,
        initialPreviewConfig: [
            {type: "image", caption: "{{$user->company_logo}}", filetype: "image/*", filename: "{{$user->company_logo}}", url:"{{ route('delete.company_logo',[$user, $user->company_logo]) }}", downloadUrl:'{{ url('uploads/' . $user->company_logo) }}',"width":"50px", key:0 },//storage
        ],
        deleteExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
            };
        },
        uploadUrl: "{{ route('upload.company_logo', $user) }}",
        uploadExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
            };
        },
        fileActionSettings: {showDrag:false},
        theme: 'fa',
        allowedFileExtensions: ['jpg', 'png', 'jpeg'],
        overwriteInitial: false,
        maxFileSize:20000,
        maxFilesNum: 1,
        // dropZoneEnabled: false,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }


    })// =================Image Upload =========================
    </script>
@endsection

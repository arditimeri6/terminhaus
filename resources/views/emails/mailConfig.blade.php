@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('successMail'))
                <script>
                    toastr.success('{{ session('successMail') }}', {timeOut:5000})
                </script>
            @endif
            @if (session('errorMail'))
                <script>
                    toastr.error('{{ session('errorMail') }}', {timeOut:5000})
                </script>
            @endif
            <div class="card border-danger">
                <div class="card-header bg-white border-danger">E-Mail-Konfiguration</div>

                <div class="card-body">
                    <form method="POST" @if($mail != null) action="{{ route('updateMail', $mail->id) }}" @else action="{{ route('mailConfig') }}"  @endif class="needs-validation" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Benutzername</label>

                            <div class="col-md-6">
                                <input id="username" type="text" placeholder="Benutzername" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" required @if($mail != null) value="{{ $mail->username }}" @endif>

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

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Kennwort</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="host" class="col-md-4 col-form-label text-md-right">Host</label>

                            <div class="col-md-6">
                                <input id="host"  type="text" placeholder="Default: smtp.googlemail.com" class="form-control{{ $errors->has('host') ? ' is-invalid' : '' }}" name="host" required @if($mail != null) value="{{ $mail->host }}" @endif>

                                @if ($errors->has('host'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('host') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="port" class="col-md-4 col-form-label text-md-right">Port</label>

                            <div class="col-md-6">
                                <input id="port" type="text" placeholder="Default: 465" class="form-control{{ $errors->has('port') ? ' is-invalid' : '' }}" name="port" required @if($mail != null) value="{{ $mail->port }}" @endif>

                                @if ($errors->has('port'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('port') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required @if($mail != null) value="{{ $mail->email }}" @endif>

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

                        <div class="form-group row">
                            <label for="subject" class="col-md-4 col-form-label text-md-right">Betreff</label>

                            <div class="col-md-6">
                                <input id="subject" type="text" placeholder="Mail Subject" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" name="subject" required @if($mail != null) value="{{ $mail->subject }}" @endif>

                                @if ($errors->has('subject'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-danger px-5">
                                    Speichern
                                </button>
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
    </script>
@endsection

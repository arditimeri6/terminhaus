@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('password-changed'))
                <script>
                    toastr.success('{{ session('password-changed') }}', {timeOut:5000})
                </script>
            @endif

            @if (session('error-password'))
                <script>
                    toastr.error('{{ session('error-password') }}', {timeOut:5000})
                </script>
            @endif
            <div class="card border-danger">
                <div class="card-header bg-white border-danger">Ändere das Kennwort</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('changePassword') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="new-password" class="col-md-4 col-form-label text-md-right">Derzeitiges Kennwort</label>

                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}" name="current-password" required>

                                @if ($errors->has('current-password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new-password" class="col-md-4 col-form-label text-md-right">Neues Kennwort</label>

                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}" name="new-password" required>

                                @if ($errors->has('new-password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @else
                                    <div class="invalid-feedback">
                                        <strong> Dieses Feld ist erforderlich </strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new-password-confirm" class="col-md-4 col-form-label text-md-right">Bestätige neues Kennwort</label>

                            <div class="col-md-6">
                                <input id="new-password-confirm" type="password" class="form-control{{ $errors->has('new-password_confirmation') ? ' is-invalid' : '' }}" name="new-password_confirmation" required>

                                @if ($errors->has('new-password_confirmation'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new-password_confirmation') }}</strong>
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
                                    Change Password
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

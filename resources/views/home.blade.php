@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                        @if (session('status'))
                            <script>
                                toastr.success('{{ session('status') }}', {timeOut:5000})
                            </script>
                        @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

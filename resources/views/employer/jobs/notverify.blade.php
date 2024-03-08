
@extends('employer.layouts.app')
@section('title')
    {{ __('messages.job.new_job') }}
@endsection
@push('css')
    {{--    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="d-flex flex-column">
        <div class="card">
            <div class="card-body"> 
                <div class="d-flex align-items-center justify-content-center flex-column">
                    <h3 class='text-warning'>Waiting for verification</h3>
                    <p class="text-center">You can not post a job yet. <br> Please wait for account to be verified.</p>
                    <a aria-current="page" href="{{ route('company.edit.form', \Illuminate\Support\Facades\Auth::user()->owner_id) }}" class="btn btn-primary">Complete Profile.</a>
                    <small>While waiting for verification you can complete your profile details.</small>
                </div>
               
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    @include('flash::message')
    <div class="d-flex flex-column ">
        <livewire:services-table />
    </div>

        @include('services.add_modal')
        @include('services.edit_modal')
        @include('services.show_modal')
        {{ Form::hidden('defaultDocumentImageUrl',asset('assets/img/infyom-logo.png') , ['id' => 'defaultDocumentImageUrl']) }}
</div>
@endsection
@push('scripts')
    <script>
        let servicesImageSaveUrl = "{{ route('download.image') }}";
    </script>
{{--    <script src="{{mix('assets/js/testimonial/testimonial.js')}}"></script>--}}
@endpush
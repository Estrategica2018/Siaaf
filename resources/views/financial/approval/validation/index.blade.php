@extends('material.layouts.dashboard')

@push('styles')
    <!-- Date Picker Style -->
    <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Select2 Style -->
    <link href="{{ asset('assets/global/plugins/select2material/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/select2material/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/select2material/css/pmd-select2.css') }}" rel="stylesheet" type="text/css" />
    <!-- Todo2 Styles -->
    <link href="{{ asset('assets/apps/css/todo-2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Loading Styles -->
    <link href="{{ mix('assets/pages/scripts/financial/loading.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', __('financial.approval.title'))

@section('page-title', __('financial.approval.index.title'))

@section('page-description',  __('financial.approval.index.description') )

@section('content')
        <div class="col-md-12" id="app">
            <approval-index-validation></approval-index-validation>
        </div>
@endsection


@push('plugins')
    <!-- Date Picker Scripts -->
    <script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.'.config('app.locale').'.min.js') }}" type="text/javascript"></script>
    <!-- Select2 Scripts -->
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/i18n/'.config('app.locale').'.js') }}"></script>
    <!-- Maxlength Scripts -->
    <script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>
    <!-- Validation Scripts -->
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_'.config('app.locale').'.js') }}" type="text/javascript"></script>
    <!-- Loading Scripts -->
    <script src="{{ mix('assets/pages/scripts/financial/loading.min.js') }}" type="text/javascript"></script>

@endpush


@push('functions')
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
@endpush
@extends('material.layouts.dashboard') 
 
@section('page-title', 'Registro de tipo de usuario') 
@push('styles') 
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" /> 
 
<link href="{{ asset('assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ asset('assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" /> 
@endpush 
 
@section('content') 
    <div class="col-md-12"> 
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-frame', 'title' => 'subida de archivos']) 
 
            @slot('actions', [ 
 
                'link_upload' => [ 
                    'link' => '', 
                    'icon' => 'icon-cloud-upload', 
                ], 
                'link_wrench' => [ 
                    'link' => '', 
                    'icon' => 'icon-wrench', 
                ], 
                'link_trash' => [ 
                    'link' => '', 
                    'icon' => 'icon-trash', 
                ], 
 
            ]) 
            <div class="clearfix"> </div><br><br><br> 
            <div class="row"> 
                <div class="col-md-12"> 
                     
                    {!! Form::open(['id' => 'my-dropzone', 'class' => 'dropzone dropzone-file-area', 'url' => '/forms']) !!} 
                    <h3 class="sbold">Arrastra o da click aquí para cargar archivos</h3> 
                    <p> This is just a demo dropzone. Selected files are not actually uploaded. </p> 
                    {!! Form::close() !!} 
                    {!! Form::submit('Guardar', ['class' => 'btn blue button-submit']) !!} 
                </div> 
            </div> 
        @endcomponent 
    </div> 
@endsection 
 
@push('plugins') 
<script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script> 
<script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script> 
<script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}" type="text/javascript"></script> 
<script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script> 
<script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script> 
<script src="{{ asset('assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script> 
@endpush 
@push('functions') 
<script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script> 
<script src="{{ asset('assets/main/scripts/dropzone.js') }}" type="text/javascript"></script> 
<script type="text/javascript"> 
 
    jQuery(document).ready(function() { 
 
        var x = function () { 
          return { 
              init: function () { 
                    alert('alamacenando archivos'); 
              } 

          }; 
        }; 
        var route = '{{route('unvinteraction.dropzone.store')}}'; 
        var formatfile = 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF'; 
        var numfile = 2; 
        FormDropzone.init(route, formatfile, numfile, x(), name); 
    }); 
 
</script> 
@endpush
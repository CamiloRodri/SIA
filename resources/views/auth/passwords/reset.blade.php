@extends('public.layouts.app')
@extends('public.layouts.seccion')
@section('fondo')"{{ asset('titan/assets/images/fondo_1.jpg') }}" @endsection
@section('descripcion')Restablecer Contraseña @endsection
@section('titulo')Restablecer @endsection
@section('content')

    @component('admin.components.panel')
        {!! Form::open(['id' => 'form-login', 'method' => 'POST', 'route' => 'password.request']) !!}
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">{{ $email }}
        <div class="col-md-9 col-md-offset-2">
            {!! Form::email('email', $email ?? old('email'), ['class' => 'form-control', 'placeholder' => 'Correo', 'required', 'autofocus', 'max'
            => '60']) !!}
        </div> <br></br>
        <div class="col-md-9 col-md-offset-2">
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', 'required']) !!}
        </div><br></br>
        <div class="col-md-9 col-md-offset-2">
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Repite la contraseña', 'required']) !!}
        </div><br></br>
        <div class="col-md-9 col-md-offset-2">
            {!! Form::submit('restablecer', ['class' => 'btn btn-success submit']) !!}
        </div>
        {!! Form::close() !!}
        </div>
        </div>
        </div>
        </section>
    @endcomponent
@endsection

{{-- Estilos necesarios para el formulario --}}
@push('styles')
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
@endpush

{{-- Scripts necesarios para el formulario --}}
@push('scripts')
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>


    @foreach ($errors->all() as $error)
        <script type="text/javascript">
            new PNotify({title: 'Error!', text: '{{ $error }}', type: 'error', styling: 'bootstrap3'});
        </script>
    @endforeach
@endpush
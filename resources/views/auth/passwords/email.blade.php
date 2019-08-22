@extends('public.layouts.app')
@extends('public.layouts.seccion')
@section('fondo')"{{ asset('titan/assets/images/fondo_1.jpg') }}" @endsection
@section('descripcion')Restablecer Contraseña @endsection
@section('titulo')Restablecer @endsection
@section('content')
    @component('admin.components.panel')
        {!! Form::open(['role' => 'form', 'id' => 'form-login', 'method' => 'POST', 'url' => route('password.email')]) !!}
        <div class="col-md-9 col-md-offset-2">
            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Correo', 'required', 'autofocus', 'max'=> '60']) !!}
        </div>
        <br></br><br></br>
        <div class="col-md-6 col-md-offset-2">
            {!! Form::submit('Restablecer', ['class' => 'btn btn-success submit']) !!}
        </div>
        </div>
        {!! Form::close() !!}
        </div>
        </div>
        </div>
        </section>
    @endcomponent
@endsection
@push('functions')
    @foreach ($errors->all() as $error)
        <script type="text/javascript">
            $(document).ready(function () {
                new PNotify({title: 'Error!', text: '{{ $error }}', type: 'error', styling: 'bootstrap3'});
        </script>
    @endforeach
@endpush
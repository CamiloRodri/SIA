@extends('public.layouts.app')
@extends('public.layouts.seccion')
@section('fondo')"{{ asset('titan/assets/images/fondo_1.jpg') }}" @endsection
@section('descripcion')Login-Registro @endsection
@section('titulo')Login @endsection
@section('content')
    @component('admin.components.panel')
        {!! Form::open(['role' => 'form',
        'id' => 'form-login', 'method' => 'POST',
        'class' => 'form-horizontal form-label-lef',
        'url' => route('login.in')]) !!}
        <div class="col-md-9 col-md-offset-2">
            {!! Form::email('email', old('email'),
            ['class' => 'form-control', 'placeholder' => 'Correo', 'required', 'autofocus', 'max'=> '60']) !!}
        </div><br></br>
        <div class="col-md-9 col-md-offset-2">
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', 'required']) !!}
        </div><br></br>
        <div class="col-md-6 col-md-offset-2">
            {!! Form::submit('Ingresar', ['class' => 'btn btn-success submit']) !!}
            {{ link_to('/password/reset', 'Olvidaste tu contraseña?',['class' => 'reset_pass'])}}
        </div>
        </br>
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
            new PNotify({title: 'Error!', text: '{{ $error }}', type: 'error', styling: 'bootstrap3'});
        </script>
    @endforeach
@endpush
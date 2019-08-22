@extends('public.layouts.app')
@extends('public.layouts.seccion')
@section('fondo')"{{ asset('titan/assets/images/fondo_1.jpg') }}" @endsection
@section('descripcion')Restablecer Contraseña @endsection
@section('titulo')Restablecer @endsection
@section('content')
    @component('admin.components.panel')
        {!! Form::open(['id' => 'form-login', 'method' => 'POST', 'route' => 'password.request']) !!}
        @csrf
        <input type="hidden" >{{ Session::get('remember_token')}}
        <ul id="myList">

        </ul>
        <div class="col-md-9 col-md-offset-2">
        {!! Form::email('email', $email ?? old('email'), ['name' => 'email','class' => 'form-control', 'placeholder' => 'Correo', 'required', 'autofocus', 'max'
            => '60']) !!}
        </div> <br></br>
        <div class="col-md-9 col-md-offset-2">
            {!! Form::password('password', ['name' => 'password','class' => 'form-control', 'placeholder' => 'Contraseña', 'required']) !!}
        </div><br></br>
        <div class="col-md-9 col-md-offset-2">
            {!! Form::password('password_confirmation', ['name' => 'password_confirmation','class' => 'form-control', 'placeholder' => 'Repite la contraseña', 'required']) !!}
        </div><br></br>

        <div class="col-md-9 col-md-offset-2">
            {!! Form::submit('restablecer', ['class' => 'btn btn-success crear']) !!}
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
    <script type="text/javascript">
        console.log({!! json_encode((array)auth()->user()->email) !!})
        console.log({!! json_encode((array)auth()->user()->remember_token) !!})
        $(".crear").on('click', function (e) {
            //e.preventDefault();
            email1 = $('input[name="email"]').val();
            console.log( $('input[name="email"]').val())
            clave2 =  $('input[name="password"]').val();
            clave1 =  $('input[name="password_confirmation"]').val();
            comprobarClave(email1,clave1,clave2);
        });
            email = {!! json_encode((array)auth()->user()->email) !!}
            pass = {!! json_encode((array)auth()->user()->password) !!}
            id = {!! json_encode((array)auth()->user()->id) !!}
            let cont = 0 ;
            let cont2 = 0 ;
            let cont3 = 0 ;

            function myFunction() {
                var node = document.createElement("LI");
                var textnode = document.createTextNode("Water");
                node.appendChild(textnode);
                document.getElementById("myList").appendChild(node);
            }

            function comprobarClave(email1,clave1,clave2){

                if(clave1 == '' || clave2== '' || email1 == ''){
                    console.log("ERROR")
                    if(cont2 == 0){
                        new PNotify({
                            title: 'Error',
                            text: 'Campos vacios',
                            type: 'success',
                            styling: 'bootstrap3'

                        });
                        cont2 = 1;
                    }
                }
                else{
                    if(email1 == email){
                        if (clave1 == clave2){
                            $.ajaxSetup({
                                headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  }
                               });
                            $.ajax({
                                type: "get",
                                url: '{{ route('reset.update') }}',
                                data: {
                                    id: {!! json_encode((array)auth()->user()->id) !!},
                                    clave: clave1
                                }, success: function (response, NULL, jqXHR) {

                                    new PNotify({
                                        title: response.title,
                                        text: 'Contraseña modificada con exito',
                                        type: 'success',
                                        styling: 'bootstrap3'
                                    });
                                }
                              });
                        }
                        else{
                            if(cont == 0){

                                new PNotify({
                                    title: 'Error',
                                    text: 'Las contraseñas no coinciden',
                                    type: 'success',
                                    styling: 'bootstrap3'
                                });
                                console.log(clave1.lenght)
                                cont = 1;

                            }

                        }
                    }
                    else{
                        if(cont3 == 0){

                            cont3 = 1;
                            new PNotify({
                                title: 'Error Correo',
                                text: 'No pertenece a la cuenta',
                                type: 'success',
                                styling: 'bootstrap3'
                            });
                        }
                    }

                }
                //if (clave1 == clave2)

                //  else
            }
    </script>

    @foreach ($errors->all() as $error)
        <script type="text/javascript">
            new PNotify({title: 'Error!', text: '{{ $error }}', type: 'error', styling: 'bootstrap3'});
        </script>
    @endforeach
@endpush

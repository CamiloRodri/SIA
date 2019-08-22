@extends('layouts.app')
@section('content')
    <div id="register" class="form registration_form" style="opacity: 1;">
        <section class="login_content">
            <form>
                <h1>Create Account</h1>
                <div>
                    <input type="text" class="form-control" placeholder="Username" required=""/>
                </div>
                <div>
                    <input type="email" class="form-control" placeholder="Email" required=""/>
                </div>
                <div>
                    <input type="password" class="form-control" placeholder="Password" required=""/>
                </div>
                <div>
                    <a class="btn btn-default submit" href="index.html">Submit</a>
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">Already a member ?
                        <a href="#" class="to_register"> Log in </a>
                    </p>

                    @include('shared.footer')
                </div>
            </form>
        </section>
    </div>
@endsection
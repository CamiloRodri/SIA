<div class="profile clearfix">
    <div class="profile_pic">
        <img src="{{ asset('gentella/build/images/user.png') }}" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>Bienvenido(a),</span>
        <h2>{{ Auth::user()->name }}</h2>
    </div>
</div>
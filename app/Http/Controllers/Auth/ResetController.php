<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PerfilUsuarioRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Autoevaluacion\User;

class ResetController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.passwords.resertpassword');
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //$iduser = $request->get('id');
        //$claveuser = $request->get('clave');
        $user = User::find(Auth::id());
        $user->fill($request->except('clave'));
        if ($request->get('clave')) {
            $user->password = $request->get('clave');
        }
        $user->estado_pass = 0;
        $user->update();

        return view('admin.dashboard.index');
    }



}

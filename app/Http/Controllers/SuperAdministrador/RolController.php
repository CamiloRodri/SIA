<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolRequest;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_ROLES');
        $this->middleware(['permission:MODIFICAR_ROLES', 'permission:VER_ROLES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ROLES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ROLES', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Roles.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Esta funcion lista en el datatable los roles que se puedan ver depende si eres administrador
     */
    public function data(Request $request)
    {
        if (Gate::allows('SUPERADMINISTRADOR')) {
            if ($request->ajax() && $request->isMethod('GET')) {
                $roles = Role::all();
                return Datatables::of($roles)
                    ->make(true);
            }
        } else {
            if ($request->ajax() && $request->isMethod('GET')) {
                $roles = Role::all()->where('name', '!=', 'SUPERADMIN')->where('name', '!=', 'ADMIN');
                return Datatables::of($roles)
                    ->make(true);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Cuando se crea un rol tienen que aparecer los permisos existentes
     * para asignarlos, depende si eres administrador o no
     */
    public function create()
    {
        if (Gate::allows('SUPERADMINISTRADOR')) {

            $permisos = Permission::pluck('name', 'name');
            return view('autoevaluacion.SuperAdministrador.Roles.create', compact('permisos'));

        } else {

            $permisos = Permission::where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'SUPERADMINISTRADOR')->where('name', '!=', 'VER_LINEAMIENTOS')->where('name', '!=', 'CREAR_LINEAMIENTOS')->where('name', '!=', 'MODIFICAR_LINEAMIENTOS')->where('name', '!=', 'ELIMINAR_LINEAMIENTOS')
                ->where('name', '!=', 'ACCEDER_ASPECTOS')->where('name', '!=', 'VER_ASPECTOS')->where('name', '!=', 'CREAR_ASPECTOS')->where('name', '!=', 'MODIFICAR_ASPECTOS')->where('name', '!=', 'ELIMINAR_ASPECTOS')
                ->where('name', '!=', 'ACCEDER_SEDES')->where('name', '!=', 'MODIFICAR_FACULTADES')->where('name', '!=', 'VER_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'ACCEDER_FACTORES')->where('name', '!=', 'MODIFICAR_CARACTERISTICAS')
                ->where('name', '!=', 'VER_SEDES')->where('name', '!=', 'ELIMINAR_FACULTADES')->where('name', '!=', 'CREAR_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'VER_FACTORES')->where('name', '!=', 'ELIMINAR_CARACTERISTICAS')
                ->where('name', '!=', 'CREAR_SEDES')->where('name', '!=', 'ACCEDER_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'MODIFICAR_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'CREAR_FACTORES')->where('name', '!=', 'ACCEDER_AMBITOS')
                ->where('name', '!=', 'MODIFICAR_SEDES')->where('name', '!=', 'VER_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ELIMINAR_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'MODIFICAR_FACTORES')->where('name', '!=', 'VER_AMBITOS')
                ->where('name', '!=', 'ELIMINAR_SEDES')->where('name', '!=', 'CREAR_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'ELIMINAR_FACTORES')->where('name', '!=', 'CREAR_AMBITOS')
                ->where('name', '!=', 'ACCEDER_FACULTADES')->where('name', '!=', 'MODIFICAR_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'ACCEDER_CARACTERISTICAS')->where('name', '!=', 'MODIFICAR_AMBITOS')
                ->where('name', '!=', 'VER_FACULTADES')->where('name', '!=', 'ELIMINAR_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'VER_CARACTERISTICAS')->where('name', '!=', 'ELIMINAR_AMBITOS')
                ->where('name', '!=', 'CREAR_FACULTADES')->where('name', '!=', 'ACCEDER_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'CREAR_CARACTERISTICAS')->pluck('name', 'name');
            return view('autoevaluacion.SuperAdministrador.Roles.create', compact('permisos'));

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion crea los roles
     */
    public function store(RolRequest $request)
    {
        $rol = Role::create($request->except('permission'));
        $permisos = $request->input('permission') ? $request->input('permission') : [];
        $rol->givePermissionTo($permisos);

        return response(['msg' => 'Rol registrado correctamente.',
            'title' => '¡Registro exitoso!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Cuando se edita un rol tienen que aparecer los permisos existentes
     * para asignarlos, depende si eres administrador o no
     */
    public function edit($id)
    {
        if (Gate::allows('SUPERADMINISTRADOR')) {

            $permisos = Permission::pluck('name', 'name');

            $rol = Role::findOrFail($id);

            $edit = true;

            return view('autoevaluacion.SuperAdministrador.Roles.edit',
                compact('rol', 'permisos', 'edit'));

        } else {

            $permisos = Permission::where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'SUPERADMINISTRADOR')->where('name', '!=', 'VER_LINEAMIENTOS')->where('name', '!=', 'CREAR_LINEAMIENTOS')->where('name', '!=', 'MODIFICAR_LINEAMIENTOS')->where('name', '!=', 'ELIMINAR_LINEAMIENTOS')
                ->where('name', '!=', 'ACCEDER_ASPECTOS')->where('name', '!=', 'VER_ASPECTOS')->where('name', '!=', 'CREAR_ASPECTOS')->where('name', '!=', 'MODIFICAR_ASPECTOS')->where('name', '!=', 'ELIMINAR_ASPECTOS')
                ->where('name', '!=', 'ACCEDER_SEDES')->where('name', '!=', 'MODIFICAR_FACULTADES')->where('name', '!=', 'VER_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'ACCEDER_FACTORES')->where('name', '!=', 'MODIFICAR_CARACTERISTICAS')
                ->where('name', '!=', 'VER_SEDES')->where('name', '!=', 'ELIMINAR_FACULTADES')->where('name', '!=', 'CREAR_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'VER_FACTORES')->where('name', '!=', 'ELIMINAR_CARACTERISTICAS')
                ->where('name', '!=', 'CREAR_SEDES')->where('name', '!=', 'ACCEDER_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'MODIFICAR_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'CREAR_FACTORES')->where('name', '!=', 'ACCEDER_AMBITOS')
                ->where('name', '!=', 'MODIFICAR_SEDES')->where('name', '!=', 'VER_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ELIMINAR_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'MODIFICAR_FACTORES')->where('name', '!=', 'VER_AMBITOS')
                ->where('name', '!=', 'ELIMINAR_SEDES')->where('name', '!=', 'CREAR_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'ELIMINAR_FACTORES')->where('name', '!=', 'CREAR_AMBITOS')
                ->where('name', '!=', 'ACCEDER_FACULTADES')->where('name', '!=', 'MODIFICAR_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'ACCEDER_CARACTERISTICAS')->where('name', '!=', 'MODIFICAR_AMBITOS')
                ->where('name', '!=', 'VER_FACULTADES')->where('name', '!=', 'ELIMINAR_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'VER_CARACTERISTICAS')->where('name', '!=', 'ELIMINAR_AMBITOS')
                ->where('name', '!=', 'CREAR_FACULTADES')->where('name', '!=', 'ACCEDER_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'CREAR_CARACTERISTICAS')->pluck('name', 'name');

            $rol = Role::findOrFail($id);

            $edit = true;

            return view('autoevaluacion.SuperAdministrador.Roles.edit',
                compact('rol', 'permisos', 'edit'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Est funcion actualiza el rol
     */
    public function update(RolRequest $request, $id)
    {

        $rol = Role::findOrFail($id);
        $rol->update($request->except('permission'));
        $permisos = $request->input('permission') ? $request->input('permission') : [];
        $rol->syncPermissions($permisos);

        return response(['msg' => 'El Rol ha sido modificado exitosamente.',
            'title' => 'Rol Modificado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Esta funcion elimina el rol
     */
    public function destroy($id)
    {
        $rol = Role::findOrFail($id);
        $rol->delete();

        return response(['msg' => 'El Rol ha sido eliminado exitosamente.',
            'title' => '¡Rol Eliminado!',
        ], 200) // 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}

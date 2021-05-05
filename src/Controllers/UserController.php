<?php

namespace Rodsaseg\LaravelSaseg\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\User;
use App\CustomField;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\PermissionKey;
use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use AuthenticatesUsers;
    use AuthenticatesUsers {
        logout as doLogout;
    }
    protected $redirectTo = '/cuentas';
    protected $redirectAfterLogout = '/admin';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        $info = [
            'title' => 'Administradores',
            'breadcrumb' => [
                [
                    'title' => 'Todos',
                    'route' => 'panel.admins.index',
                    'active' => true
                ]
            ],
            'buttons' => [
                [
                    'title' => 'Agregar Nuevo',
                    'route' => 'panel.admins.create'
                ]
            ]
        ];
        $info['data'] = User::all()->sortByDesc('id');
        return $dataTable->render('vendor.panel.admin.index', $info);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $info = [
            'title' => 'Administradores',
            'breadcrumb' => [
                [
                    'title' => 'Todos',
                    'route' => 'panel.admins.index'
                ],
                [
                    'title' => 'Nuevo',
                    'route' => 'panel.admins.create',
                    'active' => true
                ]
            ]
        ];
        if(!$request->user()->can(PermissionKey::Admin['permissions']['index']['name']))
            unset($info['breadcrumb'][0]['route']);
        $info['roles'] = Role::all();
        return view('vendor.panel.admin.create', $info);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'unique:users,email,'.$request->email
        ]);

        $input = $request->input();
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        $user->assignRole($input['role']);
        if($request->avatar){
            $user->addMedia($request->avatar)
                    ->preservingOriginal()
                    ->toMediaCollection('users');
        }
        return redirect()->route('panel.admins.edit', ['id' => $user->id]);
    }

    public function register(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $info = [
            'title' => 'Administradores',
            'breadcrumb' => [
                [
                    'title' => 'Todos',
                    'route' => 'panel.admins.index'
                ],
                [
                    'title' => 'Editar',
                    'route' => 'panel.admins.edit',
                    'params' => ['id' => $id],
                    'active' => true
                ]
            ]
        ];
        if(!$request->user()->can(PermissionKey::Admin['permissions']['index']['name']))
            unset($info['breadcrumb'][0]['route']);
        $info['admin'] = User::find($id);
        $info['roles'] = Role::all();
        return view('vendor.panel.admin.edit', $info);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Verificamos que el nuevo correo esté disponible
        if(User::where('id', '!=', $id)->where('email', $request->email)->get()->count() > 0){
            return redirect()->back()->withInput($request->input())->withErrors(['invalid' => 'Lo sentimos ese correo ya está en uso']);
        }
        $input = $request->input();
        $user = User::find($id);
        $user->update($input);
        //Le asignamos el rol
        if(isset($input['role'])){
            $user->syncRoles([$input['role']]);
        }
        if($request->avatar){
            //Eliminamos todos los media asociados
            $image_name = explode('/', $request->avatar);
            if($user->getFirstMedia('users')){
                if(end($image_name) !== $user->getFirstMedia('users')->file_name){
                    //Reemplazamos la imagen
                    $user->clearMediaCollection('users');
                    $user->addMedia($request->avatar)
                    ->preservingOriginal()
                    ->toMediaCollection('users');
                }
            }else{
                $user->addMedia($request->avatar)
                    ->preservingOriginal()
                    ->toMediaCollection('users');
            }
        }
        return redirect()->route('panel.admins.edit', ['id' => $id])->with('success', 'Información actualizada');
    }

    public function editPassword($id){
        $info = [
            'title' => 'Usuarios',
            'breadcrumb' => [
                [
                    'title' => 'Todos',
                    'route' => 'panel.admins.index',
                ],
                [
                    'title' => 'Editar',
                    'route' => 'panel.admins.edit',
                    'params' => ['id' => $id]
                ],
                [
                    'title' => 'Contraseña',
                    'active' => true
                ]
            ],
        ];
        $info['user'] = User::find($id);
        return view('vendor.panel.admin.editPassword', $info);
    }

    public function updatePassword(Request $request, $id){
        $admin = User::find($id);
        if($admin){
            if($request->new_password == $request->confirm_password){
                $admin->password = Hash::make($request->new_password);
                $admin->save();
                return redirect()->route('panel.admins.edit', ['id' => $id])->with('success', 'Información actualizada');
            }else{
                return redirect()->back()->withInput($request->input())->withErrors(['invalid' => 'La nueva contraseña no coincide, favor de verificar']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        if(User::find($id)){
            User::destroy($id);
            return response(['success' => true], 200);
        }else{
            return response(['success' => false], 404);
        }
    }

    public function unauthenticated(){
        return view('vendor.panel.admin.login');
    }

    public function login(Request $request){
        //Attempt to log in the seller
        if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
            if(auth()->user()->hasRole('admin')){
                return redirect()->route('panel.admins.edit', ['id' => auth()->user()->id]);
            }else{
                abort(403);
            }
            // if()
        }else{
            return redirect()->back()->withInput()->withErrors(['message' => 'Correo o contraseña invalida']);
        }
    }

    public function logout(Request $request){
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/admin');
    }
}

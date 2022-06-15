<?php
/*
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath(){
        if(Auth::user()->tipo_usuario){
            return '/admin/panel';
        }
        return '/home';
    }

}
*/

namespace App\Http\Controllers\Auth;


namespace App\Http\Controllers;

//use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;



class ConnectController extends Controller
{
    use AuthenticatesUsers;


    //Constructor
    public function __construct()
    {
        $this->middleware('guest')->except(['Destroy']);

    }
    //
    //Create funcion
    public function Login(){
        //return una vista
        return view('connect.Login');

    }


    public function store(Request $request)
    {


        $rules = [
            'email' => 'required|email',//Correo que sea de tipo email y unico
            'password' => 'required|min:8', //contraseña minimo 8 digito
        ];

        //Mesajes pra cuanto haya errores
        $message = [
            'email.required' => 'Su correo electronico es requerido',
            'email.email' => 'El formato de su correo electronico es invalido',
            'password.required' => 'Ingrese su contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ];

        //Validacion de datos
        $validated = Validator::make($request->all(), $rules, $message);
        if ($validated->fails()):
            return back()->withErrors($validated)->with('message', 'Se a producido un error')->with('typealert', 'danger');
        else:


            if (Auth::attempt(['email' => $request ->input('email'),'password' => $request->input('password')],true)):
                return redirect('/');
            else:
                return back()->with('message', 'Su correo o la contraseña es incorrecta')->with('typealert', 'danger');
            endif;
        endif;
    }



    //Create funcion
    public function Register(){
        //return una vista
        return view('connect.Register');
    }

    public function create(Request $request)
    {

        //reglas de validacion
        $rules = [
            'name' => 'required', //Nombre
            'lastname' => 'required', //Apellidos
            'email' => 'required|email|unique:Usuarios,email',//Correo que se de tipo email y unico
            'password' => 'required|min:8', //contraseña minimo 8 digitos
            'cpassword' => 'required|min:8|same:password', //confirmacion de pasword igual a password y minimo 8 digitos
        ];

        //Mensaje personalizado alert
        $message = [
            'name.required' => 'Su nombre es requerido',
            'lastname.required' => 'Su apellido es requerido',
            'email.required' => 'Su corrreo electronico es requerido',
            'email.email' => 'El formato de su correo electronico es invalido',
            'email.unique' => 'Ya existe un usuario registrado con este correo electronico',
            'password.required' => 'Ingrese una contraseña',
            'password.min' => 'La contraseña debe de tener al menos 8 caracteres',
            'cpassword.required' => 'Es necesario confirmar la contraseña',
            'cpassword.min' => 'La confirmaion de la contraseña debe de tener al menos 8 caracteres',
            'cpassword.same' => 'Las contraseñas no coinciden',
        ];

        $validated = Validator::make($request->all(), $rules, $message);
        if ($validated->fails()):
            return back()->withErrors($validated)->with('message', 'Se a producido un error')->with('typealert', 'danger');
        else:

            $User = new User();
            $User->name = e($request->name); //e evitar daños
            $User->lastname = e($request->lastname); //e para guardar no dañinos
            $User->email = e($request->email); //e para guardar no dañinos
            $User->password = Hash::make($request->password); //e para guardar no dañinos

            if ($User->save()):
                auth()->Login($User);
                return redirect('/Login')->with('message', 'Su usuario se creo con exito')->with('typealert', 'success');
            endif;

        endif;
    }

    public function Destroy(){
        Auth::logout();
        return redirect('/');
    }

}

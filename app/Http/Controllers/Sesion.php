<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\Models\Encuestas;
use App\Models\Estados;
use App\Models\Inventario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class Sesion extends Controller
{

    public function RInicio()  {
        return redirect('/')->with('failed','Inicia sesion para acceder');
    }

   public function Inicio(Request $request)  {

        return view('Invitado\login');
    }

    public function DarAlta() {
        $estados=Estados::all();
        return view('Invitado\signup',['Estados'=>$estados]);
    }

    public function LogIn(Request $request)
    {  

        $email = $request->query('email');
        $password = $request->query('password');

        $user = Usuarios::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->passuser)) {

            $IDUsuario=$user->id;
            
            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->intended(route('Inicio', ['id' => $IDUsuario]))->with('success','Has iniciado sesion');
        }
        return back()->with('failed','Credenciales incorrectas.')->onlyInput('email');
          
    }
    public function SignUp(Request $request) {

        $usuario = $request->input('usuario');
        $email = $request->input('email');
        $contra = $request->input('password');
        $edad = $request->integer('edad');
        $esta = $request->input('estado');
        $sx = $request->input('radio');
        $cb = $request->input('check');
   
        if($usuario===null||$email===null||$contra===null||$edad===null||$esta===null||$sx===null){
            return redirect()->route('SignUp')->with('failed','Campos faltantes');
        }

        $validador = Validator::make(['usuario' => $request->input('usuario')],[
           'usuario' => ['required','string','max:50'],
        ]);

        if($validador->fails()){
            return redirect()->route('SignUp')->with('failed','Nombre de usuario ya existente')->withInput();
        }

        $validador = Validator::make(['email' => $request->input('email')],[
           'email' => ['required','string','max:50', 'unique:Usuarios,email' ],
        ]);

        if($validador->fails()){
            return redirect()->route('SignUp')->with('failed','Email ya existente')->withInput();
        }

        $validador = Validator::make(['password' => $request->input('password')],[
            'password' => ['required','string','max:50' ]
        ]);

        if($validador->fails()){
            return redirect()->route('SignUp')->with('failed','Contraseña con formato invalido')->withInput();
        }

        if($esta===null||$esta==='null'){
            return redirect()->route('SignUp')->with('failed','No se selecciono estado')->withInput();
        }

        $validador = Validator::make(['edad' => $request->input('edad')],[
            'edad' => ['required','integer','min:17','max:100' ]
        ]);

        if($validador->fails()){
            return redirect()->route('SignUp')->with('failed','Edad no aceptada')->withInput();
        }

        $validador = Validator::make(['radio' => $request->input('radio')],[
            'radio' => ['required','string','max:50' ]
        ]);

        if($validador->fails()){
            return redirect()->route('SignUp')->with('failed','No se selecciono sexo')->withInput();
        }

        $contrahash = Hash::make($contra);

        $newuser=Usuarios::create([
         'usuarios' => $usuario,
         'email' => $email,
         'passuser' => $contrahash,
         'Edad' => $edad,
         'id_estado' => $esta,
         'Sexo' => $sx,
         'nivel' => "normal",
      ]);

        if(!($cb===null||$cb==='null')){
            $newpet = Encuestas::create([
                'Contenido' => $cb,
            ]);
        }

        
      return redirect('/')->with('success','Se creo un usuario, inicia sesion');
      
    }

    public function LogOut(Request $request){
    
        Auth::logout(); 

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success','Has salido de tu sesion');
    }
}

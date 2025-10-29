<?php

namespace App\Http\Controllers;


use App\Models\Usuarios;
use App\Models\Estados;
use App\Models\Inventario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class Control extends Controller
{

    public function Bienvenida(Request $request, $idp) {

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }
        
        $usuario=Usuarios::find($id);

        if($usuario==null){
            return redirect('/');
        }else if($usuario->nivel === 'normal'){
            return view('Usuario\bienvenida',['IDUsuario'=>$id])->with('success','Has iniciado sesion');
        }else if($usuario->nivel === 'super'){
            return view('SuperUsuario\bienvenidasu',['IDUsuario'=>$id])->with('success','Has iniciado sesion');
        }
    }

public function Selfmodif(Request $request, $idp) {

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }

      $usuario=Usuarios::find($id);

      if ($usuario === null) {

        return redirect('/')->with('failed','Error en ID'); 
    }
      
      $Nombre=$usuario->usuarios;
      $Email=$usuario->email;
      $Edad=$usuario->Edad;
      $Estado=$usuario->id_estado;
      $Sx=$usuario->Sexo;
      $Contrasena=$usuario->passuser;

      $estados=Estados::all();

        if($usuario->nivel === 'normal'){
            return view('Usuario\modificaself',[
            'id'=>$id,
        'NameUser'=>$Nombre, 
        'Email'=>$Email,
        'Edad'=>$Edad,
        'Estado'=>$Estado,
        'Sexo'=> $Sx,
        'Password'=>$Contrasena,
        'Estados'=>$estados]);
        }else if($usuario->nivel === 'super'){
            return view('SuperUsuario\modificaself',[
            'id'=>$id,
        'NameUser'=>$Nombre, 
        'Email'=>$Email,
        'Edad'=>$Edad,
        'Estado'=>$Estado,
        'Sexo'=> $Sx,
        'Password'=>$Contrasena,
        'Estados'=>$estados]);
        }
    }

    public function Selfmoddata(Request $request, $idp){

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }
      $nomuser = $request->input('usuario');
        $euser = $request->input('email');
        $conuser = $request->input('password');
        $edad = $request->integer('edad');
        $esta = $request->integer('estado');
        $sx = $request->input('radio');

      if($nomuser===null||$euser===null||$edad===null||$esta===null||$sx===null){
            return redirect()->route('Selfmodif',['id'=>$id])->with('failed','Campos faltantes');
        }

        $usuario=Usuarios::find($id);

        $validador = Validator::make(['usuario' => $request->input('usuario')],[
           'usuario' => ['required','string','max:50'],
        ]);

        if($validador->fails()){
            return redirect()->route('Selfmodif',['id'=>$id])->with('failed','Nombre de usuario ya existente');
        }

        $validador = Validator::make(['edad' => $request->input('edad')],[
            'edad' => ['required','integer','min:18','max:100' ]
        ]);

        if($validador->fails()){
            return redirect()->route('Selfmodif',['id'=>$id])->with('failed','Edad no valida');
        }

        $validador = Validator::make(['radio' => $request->input('radio')],[
            'radio' => ['required','string','max:50' ]
        ]);

        if($validador->fails()){
            return redirect()->route('Selfmodif',['id'=>$id])->with('failed','No se selecciono sexo');
        }

        $validador = Validator::make(['estado' => $request->input('estado')],[
            'estado' => ['required','integer','max:33' ]
        ]);

        if($validador->fails()){
            return redirect()->route('Selfmodif',['id'=>$id])->with('failed','Estado no valido');
        }

        if($euser === $usuario->email){
            if(Hash::check($conuser, $usuario->passuser)){
                $usuario=Usuarios::where('id', $id)->update([
                'usuarios' => $nomuser,
                'email' => $euser,
                'id_estado' => $esta,
                'Edad'=> $edad,
                'Sexo'=>$sx,
                'updated_at' => now(),
            ]);
            return redirect()->route('Selfmodif',['id'=>$id])->with('success','Se modifico el usuario con exito');
            }else{
                return redirect()->route('Selfmodif',['id'=>$id])->with('failed','Credenciales incorrectas');
            }
        }else{
            $validador = Validator::make(['email' => $request->input('email')],[
           'email' => ['required','string','max:255', 'unique:Usuarios,email' ],
        ]);
            if($validador->fails()){
            return redirect()->route('Selfmodif',['id'=>$id])->with('failed','Nombre de usuario ya existente');
            }else{
                if(Hash::check($conuser, $usuario->passuser)){
                    $usuario=Usuarios::where('id', $id)->update([
                    'usuarios' => $nomuser,
                    'email' => $euser,
                    'id_estado' => $esta,
                    'Edad'=> $edad,
                    'Sexo'=>$sx,
                    'updated_at' => now(),
                ]);
                return redirect()->route('Selfmodif',['id'=>$id])->with('success','Se modifico el usuario con exito');
                }else{
                    return redirect()->route('Selfmodif',['id'=>$id])->with('failed','Credenciales incorrectas');
                }
                return redirect()->route('Selfmodif',['id'=>$id])->with('success','Se modifico el usuario con exito');
            }

        }
    }

    
}
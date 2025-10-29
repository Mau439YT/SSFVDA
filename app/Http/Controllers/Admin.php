<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\Models\Estados;
use App\Models\Encuestas;
use App\Models\Inventario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Admin extends Controller
{
    //Desplegar a todos los usuarios
   public function Consultas(Request $request, $idp){

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
    $estados=Estados::all();

        if($usuario==null || $usuario->nivel === 'normal'){
            return redirect('/');
        }

        $IDU=$request->query('id');
      $usuarios = Usuarios::all();
      return view('SuperUsuario\consulta',['IDUsuario'=>$id,'usuarios'=>$usuarios,'estados'=>$estados]);
   }

   public function Encuestas(Request $request, $idp){

    if (!is_numeric($idp) || floor($idp) != $idp) {
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

        if($usuario==null || $usuario->nivel === 'normal'){
            return redirect('/');
        }

        $encuestas=Encuestas::all();

        $img = 0; 
        $vid = 0; 
        $doc = 0; 
        $aud = 0; 

        foreach($encuestas as $encuesta){
            foreach($encuesta->Contenido as $cont){
                if($cont=='Imagenes'){
                    $img++;
                }else if($cont=='Documentos'){
                    $doc++;
                }else if($cont=='Audios'){
                    $aud++;
                }else if($cont=='Videos'){
                    $vid++;
                }
            }
        }

      return view('SuperUsuario\encuestas',['IDUsuario'=>$id,'encuestas'=>$encuestas,
      'img'=>$img,
      'doc'=>$doc,
      'aud'=>$aud,
      'vid'=>$vid
    ]);
   }


    public function RegistroVista($idp){

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

        $estados=Estados::all();
        return view('SuperUsuario\registro',['id'=>$id,'Estados'=>$estados]);
    }

    public function Registro(Request $request, $idp) {

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

        $usuario = $request->input('usuario');
        $email = $request->input('email');
        $contra = $request->input('password');
        $edad = $request->integer('edad');
        $esta = $request->input('estado');
        $sx = $request->input('radio');
        $cb = $request->input('check');
   
        if($usuario===null||$email===null||$contra===null||$edad===null||$esta===null||$sx===null){
            return redirect()->route('SignUp')->with('failed','Campos faltantes')->withInput();
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
            return redirect()->route('SignUp')->with('failed','Edad no valida')->withInput();
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
      return redirect()->route('Consultas',['id'=>$id])->with('success','Se creo un usuario');
      
    }

    public function Modif(Request $request, $idp, $iduserp) {

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

    if (!is_numeric($iduserp) || floor($iduserp) != $iduserp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $iduser = (int) $iduserp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }

      $usuario=Usuarios::find($iduser);

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

       return view('SuperUsuario\modifica',[
        'id'=>$id,
       'iduser'=>$iduser,
       'NameUser'=>$Nombre, 
       'Email'=>$Email,
       'Edad'=>$Edad,
       'Estado'=>$Estado,
       'Sexo'=> $Sx,
       'Password'=>$Contrasena,
       'Estados'=>$estados]);
    }

    public function Moddata(Request $request, $idp, $iduserp){

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

    if (!is_numeric($iduserp) || floor($iduserp) != $iduserp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $iduser = (int) $iduserp;

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
        $esta = $request->input('estado');
        $sx = $request->input('radio');

        $usuario=Usuarios::find($iduser);

        if($nomuser===null||$euser===null||$edad===null||$esta===null||$sx===null){
            return redirect()->route('Modif',['id'=>$id,'iduser'=>$iduser])->with('failed','Campos faltantes');
        }

        $validador = Validator::make(['edad' => $request->input('edad')],[
            'edad' => ['required','integer','min:18','max:100' ]
        ]);

        if($validador->fails()){
            return redirect()->route('Modif',['id'=>$id,'iduser'=>$iduser])->with('failed','Edad invalida');
        }

        $validador = Validator::make(['radio' => $request->input('radio')],[
            'radio' => ['required','string','max:50' ]
        ]);

        if($validador->fails()){
            return redirect()->route('Modif',['id'=>$id,'iduser'=>$iduser])->with('failed','No se selecciono sexo');
        }


        $validador = Validator::make(['usuario' => $request->input('usuario')],[
           'usuario' => ['required','string','max:50'],
        ]);

        if($validador->fails()){
            return redirect()->route('Modif',['id'=>$id,'iduser'=>$iduser])->with('failed','Nombre de usuario no valido');
        }

        if($euser != $usuario->email){
            $validador = Validator::make(['email' => $request->input('email')],[
                'email' => ['required','string','max:50', 'unique:Usuarios,email' ],
            ]);

            if($validador->fails()){
                return redirect()->route('Modif',['id'=>$id,'iduser'=>$iduser])->with('failed','Email ya existente');
            }
        }

      if($conuser===null){
            $usuario=Usuarios::where('id', $iduser)->update([
         
            'usuarios' => $nomuser,
            'email' => $euser,
            'id_estado' => $esta,
            'Edad'=> $edad,
            'Sexo'=>$sx,
            'updated_at' => now(),

         ]);
      }else{
            
             $contrahash=Hash::make($conuser);
            $usuario=Usuarios::where('id', $iduser)->update([
         
            'usuarios' => $nomuser,
            'email' => $euser,
            'passuser' => $contrahash,
            'id_estado' => $esta,
            'Edad'=> $edad,
            'Sexo'=>$sx,
            'updated_at' => now(),

            ]);
      }

         
         return redirect()->route('Consultas',['id'=>$id])->with('success','Se modifico el usuario con exito')->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }

    public function Quitar(Request $request, $idp, $iduserp) {

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $id = (int) $idp;

        if (!is_numeric($iduserp) || floor($iduserp) != $iduserp) {
            Auth::logout();
                return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $iduser = (int) $iduserp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }

      $usuario=Usuarios::find($iduser);

      if ($usuario === null) {
        
        $request->session()->flash('error', 'El ID de usuario no fue encontrado o es inválido.');

        return redirect('Consultas',['id'=>$id])->with('failed','Error, no existe el usuario'); 
    }

      $Nombre=$usuario->usuarios;
      $Email=$usuario->email;
      $Contrasena=$usuario->passuser;

       return view('SuperUsuario\quitar',['id'=>$id,'IDUser'=>$iduser,'NameUser'=>$Nombre, 'Email'=>$Email,'Password'=>$Contrasena]);
    }

    public function Exh(Request $request, $idp, $idep) {
        
        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $id = (int) $idp;

        if (!is_numeric($idep) || floor($idep) != $idep) {
            Auth::logout();
                return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $ide = (int) $idep;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }

       $usuario=Usuarios::find($ide);

        if($usuario==null){
            return redirect()->route('Consultas',['id'=>$id])->with('failed','Usuario no encontrado');
        }else if($usuario->nivel === 'super'){
             return redirect()->route('Consultas',['id'=>$id])->with('failed','No se puede eliminar al superusuarios');
        }


        $imgs = Inventario::where('id_usuarios',$usuario->id)->get();

        foreach($imgs as $img){
            $rutaimg = $img->Url_Img;

            if($rutaimg && Storage::disk('public')->exists($rutaimg)){
                Storage::disk('public')->delete($rutaimg);
            }
            $img->delete();
        }

       $usuario->delete();

       return redirect()->route('Consultas',['id'=>$id])->with('success','Usuario eliminado/Imagenes de usuario borradas');
    }

    public function ObjUsuario(Request $request, $idp, $iduserp){

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

    if (!is_numeric($iduserp) || floor($iduserp) != $iduserp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $iduser = (int) $iduserp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }

        $usuario=Usuarios::find($iduser);

        if($usuario==null){
            return redirect('/');
        }

        $objetos = Inventario::where('id_usuarios',$iduser)->get();

        $objetoselim = Inventario::where('id_usuarios',$iduser)->onlyTrashed()->get();

        return view('SuperUsuario\objsusuario',['id'=>$id,'iduser'=>$iduser,'objetos'=>$objetos,'objetoselim'=>$objetoselim])->with('success','Si funciona xd');

    }

    public function Add(Request $request, $idp, $iduserp){

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

    if (!is_numeric($iduserp) || floor($iduserp) != $iduserp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $iduser = (int) $iduserp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }
        
        $nombre=$request->input('nombre');
             $imagen=$request->file('imagen');

        if($nombre===null ||$imagen===null ){
            return redirect()->route('Agregar',['id'=>$id])->with('failed','Campos vacios');
        }

        if($request->hasFile('imagen')){
             $ruta=$imagen->store('objetos','public');
   
       $validador = Validator::make($request->all(),[
            'nombre' => ['required','string','max:255' ]
        ]);

        if($validador->fails()){
            return redirect()->route('Agregar',['id'=>$id])->with('failed','Nombre no valido');
        }

        $validador = Validator::make($request->all(),[
            'imagen' => ['required','image' ]
        ]);

        if($validador->fails()){
            return redirect()->route('Agregar',['id'=>$id])->with('failed','Imagen no valida');
        }

        $newthing=Inventario::create([
            'id_usuarios' => $iduser,
            'Nombre' => $nombre,
            'Url_Img' => $ruta,
            'Activo' => 1,
      ]);
      return redirect()->route('ObjUsuario',['id' => $id,'iduser'=>$iduser])->with('success','Exito al agregar objeto')->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
        }else
        return redirect()->route('Agregar',['id' => $id])->with('failed','Error al agregar objeto');
        
    }
    public function ModifObj(Request $request, $idp, $iduserp,  $idobjp) {

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

    if (!is_numeric($iduserp) || floor($iduserp) != $iduserp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $iduser = (int) $iduserp;

    if (!is_numeric($idobjp) || floor($idobjp) != $idobjp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $idobj = (int) $idobjp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }

      $objeto=Inventario::find($idobj);

      if ($objeto === null) {
        
        $request->session()->flash('error', 'El ID de usuario no fue encontrado o es inválido.');

       return redirect()->route('ObjUsuario',['id'=>$id,'iduser'=>$iduser])->with('failed','No estás autorizado para ver este perfil.'); 
    }

    $IDUImagen = $objeto->id_usuarios;

        if($IDUImagen === $iduser){
            $Nombre=$objeto->Nombre;
            $Url=$objeto->Url_Img;
            $Tipo=$objeto->Tipo;

            return view('SuperUsuario\modificaobjSU',['id'=>$id,'iduser'=>$iduser,'idobj'=>$idobj,'Nombre'=>$Nombre, 'Url'=>$Url, 'Tipo'=>$Tipo]);
        }
        else{
            return redirect()->route('Agregar',['id'=>$id])->with('failed','Las ID de usuario no corresponden');
        }
    }

    public function ModdataObj(Request $request, $idp, $iduserp, $idobjp){

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

    if (!is_numeric($iduserp) || floor($iduserp) != $iduserp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $iduser = (int) $iduserp;

    if (!is_numeric($idobjp) || floor($idobjp) != $idobjp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $idobj = (int) $idobjp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }

        $idobj=$request->input('ide');
        $nomobj=$request->input('nombre');
        $imagen=$request->file('imagen');

        if($imagen===null){

            $objeto=Inventario::where('id', $idobj)->update([
         
            'Nombre' => $nomobj,
            'updated_at' => now(),

            ]);

        }else{
            $url=$imagen->store('objetos','public');
    
            $objeto=Inventario::find($idobj);

            Storage::disk('public')->delete($objeto->Url_Img);

            $objeto=Inventario::where('id', $idobj)->update([
         
            'Nombre' => $nomobj,
            'Url_Img' => $url,
            'updated_at' => now(),

            ]);
        }

      
         return redirect()->route('ObjUsuario',['id'=>$id,'iduser'=>$iduser])->with('success','Se ha modificado con exito')->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');;
    }

    public function QuitarObj(Request $request, $idp, $iduserp, $idobjp) {

         if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

    if (!is_numeric($iduserp) || floor($iduserp) != $iduserp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $iduser = (int) $iduserp;

    if (!is_numeric($idobjp) || floor($idobjp) != $idobjp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $idobj = (int) $idobjp;

        if(!Auth::check()){
            return redirect('/')->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect('/')->with('failed','No estás autorizado para ver este perfil.'); 
        }

      $objeto=Inventario::find($idobj);

      if ($objeto === null) {

        return redirect()->route('ObjUsuario',['id'=>$id,'iduser'=>$iduser])->with('failed', 'El ID del objeto no fue encontrado o es inválido.');
        }

        //if(Storage::exists($rutaobj)){
        //    Storage::disk('public')->delete($rutaobj);
        //}

        /*
        //Eliminacion logica directa
        $objeto=Inventario::where('id', $idobj)->update([
         
            'Activo' => 0,

         ]);
        
         */
        //
        //Eliminacion logica con softdeletes(no se olvide de importar la libreria al modelo)
        $objeto->delete();

        return redirect()->route('ObjUsuario',['id'=>$id,'iduser'=>$iduser])->with('success','Exito al quitar al objeto')->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');;  
    }


    public function Recuperar(Request $request,$idp, $iduserp, $idobjp){

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $id = (int) $idp;

    if (!is_numeric($iduserp) || floor($iduserp) != $iduserp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $iduser = (int) $iduserp;

    if (!is_numeric($idobjp) || floor($idobjp) != $idobjp) {
        Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
    }

    $idobj = (int) $idobjp;

        $usuario=Inventario::where('id', $idobj)->restore();

        return redirect()->route('ObjUsuario',['id'=>$id,'iduser'=>$iduser])->with('success','Se recupero el objeto con exito');

    }
}

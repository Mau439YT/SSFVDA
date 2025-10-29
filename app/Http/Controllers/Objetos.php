<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use App\Models\Inventario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Objetos extends Controller
{
    //Agregar objetos a usuarios

    public function Agregar($idp){

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
        }
        
        $objetos = Inventario::where('id_usuarios',$id)->get();

        $objetoselim = Inventario::where('id_usuarios',$id)->onlyTrashed()->get();

        if($usuario->nivel === 'normal'){
                return view('Usuario\agregaobj',['id'=>$id,'objetos'=>$objetos,'objetoselim'=>$objetoselim]);
            }else if($usuario->nivel === 'super'){
                return view('SuperUsuario\agregaobj',['id'=>$id,'objetos'=>$objetos,'objetoselim'=>$objetoselim]);
            }
            
    }

    public function Add(Request $request, $idp){

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

         $nombre=$request->input('nombre');
         $imagen=$request->file('objeto');

        if($nombre===null ||$imagen===null ){
            return redirect()->route('Agregar',['id'=>$id])->with('failed','Campos vacios');
        }

       
        if($request->hasFile('objeto')){
             $ruta=$imagen->store('objetos','public');

            $validador = Validator::make($request->all(),[
                'nombre' => ['required','string','max:255' ]
            ]);
            
            if($validador->fails()){
                return redirect()->route('Agregar',['id'=>$id])->with('failed','Nombre no valido');
            }

            //Validar archivo
            $validador = Validator::make($request->all(),[
                'objeto' => ['required','image' ]
            ]);

            if($validador->fails()){
                $validador = Validator::make($request->all(),[
                    'objeto' => ['required','mimes:mp4,mov,ogg,qt','max:20000']
                ]);
                if($validador->fails()){
                    $validador = Validator::make($request->all(),[
                        'objeto' => ['required','mimes:pdf,xlsx,word','max:5120']
                    ]);
                    if($validador->fails()){
                        $validador = Validator::make($request->all(),[
                        'objeto' => ['required','mimes:mp3,wav,ogg','max:5120']
                        ]);
                        if($validador->fails()){
                            return redirect()->route('Agregar',['id' => $id])->with('failed','Error al agregar objeto');
                        }else{
                            $newthing=Inventario::create([
                            'id_usuarios' => $id,
                            'Nombre' => $nombre,
                            'Url_Img' => $ruta,
                            'Tipo' => 'Audio',
                            ]);
                        }
                    }else{
                        $newthing=Inventario::create([
                        'id_usuarios' => $id,
                        'Nombre' => $nombre,
                        'Url_Img' => $ruta,
                        'Tipo' => 'Documento',
                        ]);
                    }
                }else{
                    $newthing=Inventario::create([
                    'id_usuarios' => $id,
                    'Nombre' => $nombre,
                    'Url_Img' => $ruta,
                    'Tipo' => 'Video',
                    ]);
                }
            }else{
                $newthing=Inventario::create([
                    'id_usuarios' => $id,
                    'Nombre' => $nombre,
                    'Url_Img' => $ruta,
                    'Tipo' => 'Imagen',
                    ]);
            }
        

        /*
        if($validador->fails()){
            return redirect()->route('Agregar',['id'=>$id])->with('failed','Imagen no valida');
        }
            */
      return redirect()->route('Agregar',['id' => $id])->with('success','Exito al agregar objeto')->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
        }else
        return redirect()->route('Agregar',['id' => $id])->with('failed','Error al agregar objeto');
       

        
    }

    public function ModifObj(Request $request, $idp, $idobjp) {

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $id = (int) $idp;

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

        return redirect()->route('Agregar',['id'=>$id])->with('failed','Error, no existe la imagen'); 
    }
        $IDUImagen = $objeto->id_usuarios;

        if($IDUImagen === $id){
            $Nombre=$objeto->Nombre;
            $Url=$objeto->Url_Img;
            $Tipo=$objeto->Tipo;

            $usuario=Usuarios::find($id);

            if($usuario->nivel === 'normal'){
                return view('Usuario\modificaobj',['id'=>$id,'idobj'=>$idobj,'Nombre'=>$Nombre, 'Url'=>$Url, 'Tipo'=>$Tipo]);
            }else if($usuario->nivel === 'super'){
                return view('SuperUsuario\modificaobj',['id'=>$id,'idobj'=>$idobj,'Nombre'=>$Nombre, 'Url'=>$Url, 'Tipo'=>$Tipo]);
            }

            
        }
        else{
            return redirect()->route('Agregar',['id'=>$id])->with('failed','Las ID de usuario no corresponden');
        }
      
      
    }

    public function ModdataObj(Request $request, $idp, $idobjp){

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $id = (int) $idp;

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

        $nomobj=$request->input('nombre');
        $objeto=$request->file('objeto');

        if($nomobj === null){
            return redirect()->route('ModifObj',['id'=>$id,'idobj'=>$idobj])->with('failed','Nombre de objeto invalido');
        }

        if($objeto===null){

            $objeto=Inventario::where('id', $idobj)->update([
         
            'Nombre' => $nomobj,
            'updated_at' => now(),

            ]);

        }else{

            //Validar archivo
            $validador = Validator::make($request->all(),[
                'objeto' => ['required','image' ]
            ]);

            if($validador->fails()){
                $validador = Validator::make($request->all(),[
                    'objeto' => ['required','mimes:mp4,mov,ogg,qt','max:20000']
                ]);
                if($validador->fails()){
                    $validador = Validator::make($request->all(),[
                        'objeto' => ['required','file','max:5120']
                    ]);
                    if($validador->fails()){
                        return redirect()->route('Agregar',['id' => $id])->with('failed','Error al agregar objeto');
                    }else{
                        $url=$objeto->store('objetos','public');
    
                        $objeto=Inventario::find($idobj);

                        Storage::disk('public')->delete($objeto->Url_Img);

                        $objeto=Inventario::where('id', $idobj)->update([
                    
                        'Nombre' => $nomobj,
                        'Url_Img' => $url,
                        'Tipo' => 'Documento',
                        'updated_at' => now(),

                        ]);
                    }
                }else{
                    $url=$objeto->store('objetos','public');
    
                    $objeto=Inventario::find($idobj);

                    Storage::disk('public')->delete($objeto->Url_Img);

                    $objeto=Inventario::where('id', $idobj)->update([
                
                    'Nombre' => $nomobj,
                    'Url_Img' => $url,
                    'Tipo' => 'Video',
                    'updated_at' => now(),

                    ]);
                }
            }else{
                $url=$objeto->store('objetos','public');
    
                $objeto=Inventario::find($idobj);

                Storage::disk('public')->delete($objeto->Url_Img);

                $objeto=Inventario::where('id', $idobj)->update([
            
                'Nombre' => $nomobj,
                'Url_Img' => $url,
                'Tipo' => 'Imagen',
                'updated_at' => now(),

                ]);
            }

            
        }
         return redirect()->route('Agregar',['id'=>$id])->with('success','Se ha modificado con exito')->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');;
    }

    public function QuitarObj(Request $request, $idp, $idobjp) {

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $id = (int) $idp;

        if (!is_numeric($idobjp) || floor($idobjp) != $idobjp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $idobj = (int) $idobjp;

        if(!Auth::check()){
            return redirect()->route('Agregar',['id'=>$id])->with('failed','Inicia sesion nuevamente'); 
        }

        if (Auth::id() != $id) {
            Auth::logout(); 
            return redirect()->route('Agregar',['id'=>$id])->with('failed','No estás autorizado para ver este perfil.'); 
        }

      $objeto=Inventario::find($idobj);

      if ($objeto === null) {
        
        $request->session()->flash('error', 'El ID del objeto no fue encontrado o es inválido.');

        return redirect()->route('Agregar',['id'=>$id]);
        }

        $rutaobj = $objeto->Url_Img;

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
        return redirect()->route('Agregar',['id'=>$id])->with('success','Exito al quitar al objeto')->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');;  
    }


    public function Recuperar(Request $request,$idp, $idobjp){

        if (!is_numeric($idp) || floor($idp) != $idp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $id = (int) $idp;

        if (!is_numeric($idobjp) || floor($idobjp) != $idobjp) {
            Auth::logout();
            return redirect()->route('Login')->with('failed', 'ID no valida.');
        }

        $idobj = (int) $idobjp;

        $usuario=Inventario::where('id', $idobj)->restore();

        return redirect()->route('Agregar',['id'=>$id])->with('success','Se recupero el objeto con exito');

    }
}

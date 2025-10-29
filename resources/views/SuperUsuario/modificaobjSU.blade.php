<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('mi-icono.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica objetos</title>
    @vite(['resources/css/vista.css', 'resources/js/vista.js'])
</head>
<body>
    @if (session('failed'))

            <script>

        Swal.fire({

                background: '#ff7878ff',
                icon: 'error',
                iconColor: '#464646ff',
                text: '{{session('failed')}}',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                customClass:{
                    container: 'sa_c',
                    popup: 'sa_pu',
                }

            });
    </script>
    @endif 
            @if (session('success'))

            <script>

        Swal.fire({

                background: '#83ff78ff',
                icon: 'success',
                iconColor: '#464646ff',
                text: '{{session('success')}}',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                customClass:{
                    container: 'sa_c',
                    popup: 'sa_pu',
                }

            });
    </script>
    @endif 

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
        const divTemporal = document.getElementById('avisos');
        const tiempoEspera = 5000; 
        setTimeout(() => {
            if (divTemporal) {
                divTemporal.style.display = 'none';
            }
            }, tiempoEspera);
        });
        document.addEventListener('DOMContentLoaded', (event) => {
        const divTemporal = document.getElementById('avisosex');
        const tiempoEspera = 5000; 
        setTimeout(() => {
            if (divTemporal) {
                divTemporal.style.display = 'none';
            }
            }, tiempoEspera);
        });
    </script>

    <nav class="nav divportada ">
        <div class="navbar-header ">
            <a class="navbar-brand portada">SSFVD</a>
        </div>
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item">
                <a class="nav-link active" disabled>Editando objetos de usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" value="Salir" id="salir" href="{{ route('ObjUsuario',['id'=>$id,'iduser'=>$iduser]) }}">Volver</a>
            </li>
        </ul>
    </nav>

    <div class="formulario">
        <div class="fondoid">
            <p class="idtexto">ID de usuario: </p><p class="idtexto" name="idusuario">{{$id??'Sin ID'}}</p>
        </div>
        <label class="textform">Ingrese los datos a cambiar: </label>
        <br><br>
        <form action="{{ route('ModdataObjSU',['id'=>$id,'iduser'=>$iduser,'idobj'=>$idobj]) }}" method="POST" enctype="multipart/form-data">
            @csrf
        <label class="textform">Nombre: </label>
        <input type="text" id="nombre" name="nombre" placeholder="John Doe" value="{{$Nombre}}">
        <br><br>
        <label class="textform">Imagen previa: </label>
        <br><br>
       @if ($Tipo === 'Imagen')
                    <img class="imgtabla" src="{{ asset('storage/' . $Url) }}"><br>
                    <a class="imgtabla" href="{{ asset('storage/' . $Url) }}" rel="noopener noreferrer"target="_blank" style="color:blue;">->Abrir en pestaña<-</a><br>
                @endif
                @if ($Tipo === 'Video')
                    <video class="imgtabla" src="{{ asset('storage/' . $Url) }}" controls autoplay></video><br>
                        <a class="imgtabla" href="{{ asset('storage/' . $Url) }}" rel="noopener noreferrer"target="_blank" style="color:blue;">->Abrir en pestaña<-</a><br> 
                @endif
                @if ($Tipo === 'Documento')
                    <iframe src="{{ asset('storage/' . $Url) }}" width="90%" allowfullscreen></iframe><br>
                    <a class="imgtabla" href="{{ asset('storage/' . $Url) }}" rel="noopener noreferrer"target="_blank" style="color:blue;">->Abrir en pestaña<-</a><br>
                @endif
                @if ($Tipo === 'Audio')
                    <audio controls class="imgtabla" type="audio/mpeg">
                        <source src="{{ asset('storage/' . $Url) }}" >
                    </audio><br>
                    <a class="imgtabla" href="{{ asset('storage/' . $Url) }}" rel="noopener noreferrer"target="_blank" style="color:blue;">->Abrir en pestaña<-</a><br>
                @endif
        <br><br>
        <label class="textform">Nuevo objeto: </label>
        <br><br>
        <input type="file" id="imagen" name="imagen" onchange="mostrarPrevia(event)" style="display: inline;">
        <br><br>
        {{--  
        <img class="imgprevio" id="imagenPrevisualizacion" src="#" alt="Aqui debe de haber algo...">
        <br><br>
        --}}
        <input class="confbutton" type="submit" value="Confirmar">
        </form>
        <script>

        document.addEventListener('DOMContentLoaded', (event) => {
            const nombre = document.getElementById('nombre');
            const limite = 40; 

            nombre.addEventListener('input', function() {
                if (this.value.length > limite) {

                    this.value = this.value.substring(0, limite);
                    
                }
            });

        });
        </script>
    </div>
    vi va enjambre beibi
     <script>
        function mostrarPrevia(event) {
        const $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");

        const archivos = event.target.files;
        if (archivos.length === 0) {
            $imagenPrevisualizacion.src = "";
            $imagenPrevisualizacion.style.display = 'none'; 
            return;
        }

        const archivo = archivos[0];

        const reader = new FileReader();+
        reader.onload = function(e) {+
            $imagenPrevisualizacion.src = e.target.result;
            $imagenPrevisualizacion.style.display = 'inline'; 
        };

        reader.readAsDataURL(archivo);
    }
}
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  
</body>
</html>
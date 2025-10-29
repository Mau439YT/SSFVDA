<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('mi-icono.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar objeto</title>
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
                <a class="nav-link active"disabled>Agregando objetos al usuario {{$iduser}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Consultas',['id'=>$id]) }}">Volver</a>
            </li>
        </ul>
    </nav>

    <div class="cuerpo">
        <div class="tabla">
            <div id="disponibles">
        <p class="texto">Objetos</p>
           @foreach ($objetos as $objeto)
                <div class="fondoimg">
                    <button class="nbcheck" style="position: absolute; right: 85%; top:4%; background-color: rgb(218, 203, 0);"><a href="{{ route('ModifObjSU',['id'=>$id, 'iduser'=>$iduser,'idobj'=>$objeto->id,'Tipo'=>$objeto->Tipo]) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-pencil">
  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/></svg>
                        
                    </a></button>
                    <button id ="quitar_{{$objeto->id}}" class="nbcheck" style="position: absolute; right: 4%; top:4%; background-color: rgb(218, 203, 0);">X</button>
                   <script>
                    document.addEventListener('DOMContentLoaded', function () {
                    const salir = document.getElementById("quitar_{{ $objeto->id }}");
                    if(salir){
                        salir.addEventListener('click', function() {
                            Swal.fire({
                                background: '#fdff78ff',
                                icon: 'question',
                                iconColor: '#464646ff',
                                title: '¿Seguro que quieres quitar a tu {{ $objeto->Nombre }}?',
                                confirmButtonText: 'Si quiero',
                                showCancelButton: true,
                                cancelButtonText: 'No quiero',
                                toast: true,
                                confirmButtonColor: '#7bff00ff',
                                cancelButtonColor: '#ff3c00ff', 
                                customClass:{
                                    title: 'alerta_texto',
                                    confirmButton: 'confboton',
                                    cancelButton: 'cancboton',
                                    popup: 'sa_pu',
                                },

                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '{{ route('ElimObjSU',['id'=>$id, 'iduser'=>$iduser, 'idobj'=>$objeto->id]) }}';
                                }
                        });;
                        })
                    }
                });
                </script>
                    <p>{{ $objeto->Nombre }}</p>
                {{-- Aqui van los archivos --}}

                @if ($objeto->esImagen())
                    <img class="imgtabla" src="{{ asset('storage/' . $objeto->Url_Img) }}"><br>
                    <a class="imgtabla" href="{{ asset('storage/' . $objeto->Url_Img) }}" rel="noopener noreferrer"target="_blank" style="color:blue;">->Abrir en pestaña<-</a><br>
                     Ultima modificación: {{$objeto->updated_at}} UTC
                @endif
                @if ($objeto->esVideo())
                    <video class="imgtabla" src="{{ asset('storage/' . $objeto->Url_Img) }}" controls autoplay></video><br>
                        <a class="imgtabla" href="{{ asset('storage/' . $objeto->Url_Img) }}" rel="noopener noreferrer"target="_blank" style="color:blue;">->Abrir en pestaña<-</a><br>
                         Ultima modificación: {{$objeto->updated_at}} UTC
                @endif
                @if ($objeto->esDocumento())
                    <iframe src="{{ asset('storage/' . $objeto->Url_Img) }}" width="90%" allowfullscreen></iframe><br>
                    <a class="imgtabla" href="{{ asset('storage/' . $objeto->Url_Img) }}" rel="noopener noreferrer"target="_blank" style="color:blue;">->Abrir en pestaña<-</a><br>
                     Ultima modificación: {{$objeto->updated_at}} UTC
                @endif
                @if ($objeto->esAudio())
                    <audio controls class="imgtabla" type="audio/mpeg">
                        <source src="{{ asset('storage/' . $objeto->Url_Img) }}" >
                    </audio><br>
                    <a class="imgtabla" href="{{ asset('storage/' . $objeto->Url_Img) }}" rel="noopener noreferrer"target="_blank" style="color:blue;">->Abrir en pestaña<-</a><br>
                     Ultima modificación: {{$objeto->updated_at}} UTC
                @endif

                
                    <br>
                </div><br>
            @endforeach
            </div>
            <br><br><br>
             <div class="tablare" id="recuperables">
            <label class="textform">Recuperar objetos </label>
            <br>
           
            <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Recuperar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($objetoselim as $objetoelim)
                    <tr>
                        <td style="width: 30%;">{{ $objetoelim->Nombre }}</td>
                        <td style="width: 10%;"><button class="nbcheck"><a href="{{ route('RecuperarSU',['id'=>$id,'iduser'=>$iduser,'idobj'=>$objetoelim->id]) }}">✓</a></button></td>
                    </tr>
                @endforeach
            </tbody>
            </table>
            </div>
        </div>

        <div class="formulario_img">
            <div class="fondoid">
                <p class="idtexto">ID de usuario: </p><p class="idtexto" name="idusuario">{{$id??'Sin ID'}}</p>
            </div>
             Ver:
            <select id="visible" onchange="Ver()" >
                <option class="form-control" value="disponible" required>Disponibles</option>
                <option class="form-control" value="recuperables" required>No disponibles</option>
            </select>
            <script>
                function Ver() {
                    const x = document.getElementById("visible");
                    const y = document.getElementById("disponibles");
                    const z = document.getElementById("recuperables");
                    if (x.value === "disponible") {
                        y.style.display = "block";
                        z.style.display = "none";
                    } 
                    if(x.value === "recuperables") {
                        y.style.display = "none";
                        z.style.display = "block";
                    }
                }
                document.addEventListener('DOMContentLoaded', Ver);
            </script>
            <br><br>
            <label class="textform">Ingrese los datos del objeto: </label>
            <br><br>
            <form name="form" action="{{ route('AddSU', ['id'=>$id,'iduser'=>$iduser]) }}" method="POST" enctype="multipart/form-data">
                @csrf
            <label class="textform">¿Que es?: </label>
            <input type="text" id="nombre" name="nombre" placeholder="Perro">
            <br><br>
            <label class="textform">Sube una imagen de eso: </label>
            <br><br>
            <input type="file" id="imagen" name="imagen" onchange="mostrarPrevia(event)" style="display:inline;">
            <br><br>
            <img class="imgprevio" id="imagenPrevisualizacion" src="#" alt="Aqui debe de haber algo...">
            <br><br>
            <input class="confbutton" type="submit" value="Confirmar">
            </form>

        </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const salir = document.getElementById("salir");
        if(salir){
            salir.addEventListener('click', function() {
                Swal.fire({
                    background: '#fdff78ff',
                    icon: 'question',
                    iconColor: '#464646ff',
                    title: '¡Estas por salir de tu cuenta!',
                    confirmButtonText: 'Si quiero',
                    showCancelButton: true,
                    cancelButtonText: 'No quiero',
                    toast: true,
                    confirmButtonColor: '#7bff00ff',
                    cancelButtonColor: '#ff3c00ff', 
                    customClass:{
                        title: 'alerta_texto',
                        confirmButton: 'confboton',
                        cancelButton: 'cancboton',
                        popup: 'sa_pu',
                    },

                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('Cierre',['id'=>$id]) }}';
                    }
            });;
            })
        }
    });
    </script>
    vi va enjambre beibi
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
    </script>
</body>

</html>
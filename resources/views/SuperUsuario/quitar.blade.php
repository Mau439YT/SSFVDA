<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('mi-icono.png') }}">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
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
                <a class="nav-link active"disabled>Estas por quitar a {{$NameUser}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Consultas',['id'=>$id]) }}">Volver</a>
            </li>
        </ul>
    </nav>

    <div class="formulario">
        <div class="fondoid">
            <p class="idtexto">ID de usuario: </p><p class="idtexto" name="idusuario">{{$id??'Sin ID'}}</p>
        </div>
        <label class="textform">¿Estas seguro que quieres eliminar la cuenta?: </label>
        <br><br>
        <form action="{{ route('Exh',['id'=>$id,'iduser'=>$IDUser]) }}" method="GET">
            @csrf
        <label class="textform">Usuario: </label>
        <input type="text" name="usuario" placeholder="John Doe" value="{{$NameUser}}" disabled>
        <br><br>
        <label class="textform">Email: </label>
        <input type="text" name="usuario" placeholder="John Doe" value="{{$Email}}" disabled>
        <br><br>
        <label class="textform" >Se borraran las imagenes que el usuario haya creado </label>
        <input type="text" name="password" value="{{$Password}}" hidden disabled>
        <br><br>
        <input class="confbutton"type="submit" value="Confirmar">
        </form>
    </div>
    vi va enjambre beibi
</body>
</html>
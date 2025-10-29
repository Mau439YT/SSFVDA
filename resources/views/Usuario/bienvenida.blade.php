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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    @vite(['resources/css/vista.css', 'resources/js/app.js'])
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
                <a class="nav-link active"disabled>Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" value="Add" id="add" href="{{ route('Agregar',['id'=>$IDUsuario]) }}">Agregar objeto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" value="Editar" id="Editar" href="{{ route('Selfmodif',['id'=>$IDUsuario]) }}">Editar usuario</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" value="Salir" id="salir" href="#">Salir</a>
            </li>
        </ul>
    </nav>
    
<div class="cuerpo">
    <div class="fondotexto">
        <div class="fondoid">
            <p class="idtexto">ID de usuario: </p><p class="idtexto"id="idusuario">{{$IDUsuario}}</p>
        </div>
         <p class="texto">¿Que deseas hacer?</p>
         <br><br>
         <p>Aun estamos en version DEMASIADO temprana, puede que se modifiquen cosas a lo largo del tiempo de desarrollo</p>
    </div>
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
                        window.location.href = '{{ route('Cierre',['id'=>$IDUsuario]) }}';
                    }
            });;
            })
        }
    });
    </script>
    vi va enjambre beibi
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  
</body>
</html>
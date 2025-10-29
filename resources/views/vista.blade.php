<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('mi-icono.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    @vite(['resources/css/vista.css', 'resources/js/vista.js'])
</head>
<body>
    @if (session('failed'))

            <script>

        Swal.fire({

                background: '#ff7878ff',
                icon: 'success',
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

    <div class="divportada">
        <p class="portada">Inicio de sesion</label>
    </div>
    <div class="formulario">
        <label class="textform">Ingrese sus datos: </label>
        <br><br>
        <form action="{{ route('Validacion') }}" method="GET">
            @csrf
        <label class="textform">Usuario: </label>
        <input type="email" name="email" placeholder="alguien@example.com" required autofocus>
        <br><br>
        <label class="textform" >Contraseña: </label>
        <input type="password" name="password" placeholder="********" required>
        <br><br>
        <input class="confbutton" type="submit" value="Confirmar">
        </form>
        <p class="texto">¿No tienes cuenta? <a href="crear">Da clic aqui</a></p>
    </div>
    vi va enjambre beibi
</body>
</html>
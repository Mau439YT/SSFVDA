<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" 
    integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" 
    crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Inicia sesión</title>
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
    <nav class="nav divportada">
        <div class="navbar-header">
        <a class="navbar-brand portadaul">Log In</a>
        </div>
    </nav>
    <div class="formulario">
        <div style="padding-left: 25%; padding-right: 25%;">
        <label class="textform">Ingrese sus datos: </label>
        <br><br>
        <form action="{{ route('Validacion') }}" method="GET">
            @csrf
        <label class="textform">Usuario:  </label>
        <input class="form-control form-control-lg" type="email" id="email" name="email" placeholder="alguien@example.com" required autofocus>
        <br><br>
        <label class="textform" >Contraseña:  </label>
        <input class="form-control form-control-lg" type="password" id="password"  name="password" placeholder="********" required>
        <br><br>
        <input class="confbutton" type="submit" value="Confirmar">
        </form>
        <br><br>
        <p class="texto">¿No tienes cuenta? <a href="crear">Da clic aqui</a></p>
    </div>
</div>
    vi va enjambre beibi
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script>
        //validaciones de tamaño de entradas
        document.addEventListener('DOMContentLoaded', (event) => {
            const email = document.getElementById('email');
            const limite = 40; 

            email.addEventListener('input', function() {
                if (this.value.length > limite) {

                    this.value = this.value.substring(0, limite);
                    
                }
            });

        });
        document.addEventListener('DOMContentLoaded', (event) => {
            const password = document.getElementById('password');
            const limite = 50; 

            password.addEventListener('input', function() {
                if (this.value.length > limite) {

                    this.value = this.value.substring(0, limite);
                    
                }
            });

        });
    </script>
</body>
</html>
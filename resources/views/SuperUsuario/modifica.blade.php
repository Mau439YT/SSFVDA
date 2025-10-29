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
    <title>Edita usuarios</title>
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
                <a class="nav-link active"disabled>Editando a {{$NameUser}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Consultas',['id'=>$id]) }}">Volver</a>
            </li>
        </ul>
    </nav>

    <div class="formulario">
        <div style="padding-left: 25%; padding-right: 25%;">
        <label class="textform">Ingrese los datos a cambiar: </label>
        <br><br>
        <form action="{{ route('Moddata',['id'=>$id,'iduser'=>$iduser]) }}" method="POST">
            @csrf
        <label class="textform">Usuario: </label>
        <input class="form-control form-control-lg" type="text" id="usuario" name="usuario" placeholder="John Doe" value="{{$NameUser}}">
        <br><br>
        <label class="textform">Email: </label>
        <input class="form-control form-control-lg" type="text" id="email" name="email" placeholder="John Doe" value="{{$Email}}">
        <br><br>
        <label class="textform">Edad: </label>
        <input class="form-control form-control-lg" type="number" name="edad"  id="edad" placeholder="ej. 20" style="width: 70px; display: inline" value="{{ $Edad }}" required>
        <br><br><br>
        <label class="textform">Estado donde reside: </label>
        <select name="estado" required>
            <option class="form-control" value="" required>-- Selecciona un estado --</option>
            @foreach ($Estados as $estado)

                @if($Estado === $estado->id)
                    <option class="form-control" value="{{$estado->id}}" type="radio" name="{{$estado->Nombre}}" selected required>{{$estado->Nombre}}
                @else
                    <option class="form-control" value="{{$estado->id}}" type="radio" name="{{$estado->Nombre}}" required>{{$estado->Nombre}}
                @endif
                
            @endforeach
        </select>
        <br><br>
         <div>
        <label class="textform" name="sx">Sexo: </label><br>
            @if($Sexo === 'Masculino')
                <input class="form-control" value="Masculino" type="radio" name="radio" checked required><label>Masculino</label>
            @else
                <input class="form-control" value="Masculino" type="radio" name="radio" required><label>Masculino</label>
            @endif
            @if($Sexo === 'Femenino')
                <input class="form-control" value="Femenino" type="radio" name="radio" checked required><label>Femenino</label>
            @else
                <input class="form-control" value="Femenino" type="radio" name="radio" required><label>Femenino</label>
            @endif
            @if($Sexo === 'Prefiere no decirlo') 
                <input class="form-control" value="Prefiere no decirlo" type="radio" name="radio" checked required><label>Prefiero no decirlo</label>
            @else 
                <input class="form-control" value="Prefiere no decirlo" type="radio" name="radio" required><label>Prefiero no decirlo</label>
            @endif
         </div>
         <br><br>
        <label class="textform" >Contraseña: </label>
        <input class="form-control form-control-lg" type="password" id="password" name="password" placeholder="********">
        <input type="hidden" name="passwordhash" value="{{$Password}}">
        <br><br>
        <input class="confbutton" type="submit" value="Confirmar">
        </form>
        <script>

        //Validaciones del tamaño de caracteres
    document.addEventListener('DOMContentLoaded', (event) => {
        const edad = document.getElementById('edad');
        const limite = 3; 

        edad.addEventListener('input', function() {
            this.value = this.value.toString().replace(/[eE-]/g, '');

            if (this.value.length > limite) {

                this.value = this.value.substring(0, limite);
                
            }
        });

    });
    document.addEventListener('DOMContentLoaded', (event) => {
        const usuario = document.getElementById('usuario');
            const limite = 40; 

            usuario.addEventListener('input', function() {
                if (this.value.length > limite) {

                    this.value = this.value.substring(0, limite);
                    
                }
            });
        });
        document.addEventListener('DOMContentLoaded', (event) => {
        const email = document.getElementById('email');
            const limite = 50; 

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
                        window.location.href = '{{ route('Cierre',['id'=>$id]) }}';
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
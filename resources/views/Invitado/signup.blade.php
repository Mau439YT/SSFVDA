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
    <title>Crear usuario</title>
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

    <nav class="nav divportada">
        <a class="navbar-brand portadaul">Sign Up</a>
    </nav>
    
    <div class="formulario">
        <div style="padding-left: 25%; padding-right: 25%;">
        <label class="textform">Ingrese sus datos: </label>
        <br><br>
        <form id="registroform" action="{{ route('Registro') }}" method="POST">
             @csrf
        <label class="textform">Usuario: </label>
        <input class="form-control form-control-lg" type="text" name="usuario" id="usuario" placeholder="John Doe" value="{{ old('usuario') }}" @if (old('usuario')=='') autofocus @endif required>
        <br><br>
        <label class="textform">Email: </label>
        <input class="form-control form-control-lg" type="email" name="email" id="email" placeholder="alguien@example.com" value="{{ old('email') }}" required>
        <br><br>
        <label class="textform">Edad: </label>
        <input class="form-control form-control-lg" type="number" name="edad" id="edad" placeholder="ej. 20" style="width: 100px; display: inline" value="{{ old('edad') }}" maxlength="3" required>
        <br><br>
        <label class="textform">Estado donde reside: </label>
        <select name="estado" required>
            <option class="form-control" value="" @selected(old('estado')=='') required>-- Selecciona un estado --</option>
            @foreach ($Estados as $estado)
                <option class="form-control" value="{{$estado->id}}" @selected(old('estado')==$estado->id)  type="radio" name="{{$estado->Nombre}}" required>{{$estado->Nombre}}
            @endforeach
        </select>
        <br><br>
         
        <label class="textform" name="sx" >Sexo: </label><br><br>
        <div>
            <label><input class="form-control" value="Masculino"  type="radio" name="radio" required @checked(old('radio')=='Masculino') style="display: inline-block;" >Masculino</label>
            <label><input class="form-control" value="Femenino" type="radio" name="radio" required @checked(old('radio')=='Femenino') style="display: inline-block;">Femenino</label>
            <label><input class="form-control" value="Prefiere no decirlo" type="radio" name="radio" required @checked(old('radio')=='Prefiere no decirlo') style="display: inline-block;">Prefiero no decirlo</label>
         </div>
         <br><br>
         <div>
        <label class="textform">Como pequeña encuesta: ¿Qué cosas subiras?: </label><br><br>
            <label><input class="form-control" value="Imagenes" @if(is_array(old('check')) && in_array('Imagenes', old('check'))) checked @endif type="checkbox" name="check[]" style="display: inline-block;">Imagenes</label>
            <label><input class="form-control" value="Videos" @if(is_array(old('check')) && in_array('Videos', old('check'))) checked @endif type="checkbox" name="check[]" style="display: inline-block;">Videos</label>
            <label><input class="form-control" value="Documentos" @if(is_array(old('check')) && in_array('Documentos', old('check'))) checked @endif type="checkbox" name="check[]" style="display: inline-block;">Documentos</label>
            <label><input class="form-control" value="Audios" @if(is_array(old('check')) && in_array('Audios', old('check'))) checked @endif type="checkbox" name="check[]" style="display: inline-block;">Audios</label>
        </div>
        <br><br>
        <label class="textform" >Contraseña: </label>
        <input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="********" required>
        <br><br>
        <label class="textform" >Confirmar contraseña: </label>
        <input class="form-control form-control-lg" type="password" name="passwordconf" id="passwordconf" placeholder="********" required>
        <br><br>
        <input class="confbutton" type="submit" value="Confirmar">
        </form>
        <br><br>
        <p class="texto">¿Ya tienes cuenta? <a href="/">Da clic aqui</a></p>
    </div>
</div>
    vi va enjambre beibi
    <script>

        const form = document.getElementById('registroform');
        const contraI = document.getElementById('password');
        const concofI = document.getElementById('passwordconf');

        form.addEventListener('submit', function(event) {

            event.preventDefault();
            const contra = contraI.value;
            const concof = concofI.value;

            if (contra !== concof) {
                alert('Las contraseñas nos coinciden');
                contraI.focus();
            } else {
                form.submit();
            }
        });

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
        document.addEventListener('DOMContentLoaded', (event) => {
        const passwordconf = document.getElementById('passwordconf');
            const limite = 50; 

            passwordconf.addEventListener('input', function() {
                if (this.value.length > limite) {

                    this.value = this.value.substring(0, limite);
                    
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  
</body>
</html>
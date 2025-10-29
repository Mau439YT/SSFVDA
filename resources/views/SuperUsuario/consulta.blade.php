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
    <title>Consulta de usuarios</title>
    @vite(['resources/css/vista.css', 'resources/js/app.js'])
</head>
<body>
    @if (session('failed'))

            <script>

        Swal.fire({

                background: '#ff7878ff',
                icon: 'failed',
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
                <a class="nav-link" href="{{ route('Inicio',['id'=>$IDUsuario]) }}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" value="Add" id="add" href="{{ route('Agregar',['id'=>$IDUsuario]) }}">Agregar objeto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" value="Editar" id="Editar" href="{{ route('Selfmodif',['id'=>$IDUsuario]) }}">Editar usuario</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('Consultas',['id'=>$IDUsuario]) }}" disabled>Consulta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Encuestas',['id'=>$IDUsuario]) }}">Encuestas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" value="Salir" id="salir" href="#">Salir</a>
            </li>
        </ul>
    </nav>

    <div class="cuerpoconsultas">
    <div class="fondotexto">
        <div class="fondoid">
            <p class="idtexto">ID de usuario: </p><p class="idtexto" name="Idusuario">{{$IDUsuario??'Sin ID'}}</p>
        </div>
        <p class="textform">Se despliega la lista de usuarios </p>
        <div style="text-align:right;">
            <button class="nboton"><a href="{{ route('RegistroVista',['id'=>$IDUsuario]) }}">+</a></button>
        </div>
        <br>
        <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Ver sus Imgs</th>
                <th scope="col">Editar</th>
                <th scope="col">Eliminar</th>
                <th scope="col">Info</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->usuarios }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td class="bg-success"><button class="nbcheck"><a href="{{ route('ObjUsuario',['id'=>$IDUsuario,'iduser'=>$usuario->id]) }}">✓</a></button></td>
                    <td class="bg-warning"><button class="nbcheck"><a href="{{ route('Modif',['id'=>$IDUsuario,'iduser'=>$usuario->id]) }}">✓</a></button></td>
                    <td class="bg-danger"><button class="nbcheck"><a href="{{ route('Elimina',['id'=>$IDUsuario,'iduser'=>$usuario->id]) }}">✓</a></button></td>
                    <td class="bg-info"><button class="nbcheck"  id="info_{{ $usuario->id }}">✓</button></td>
                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                    const info = document.getElementById("info_{{ $usuario->id }}");
                    if(info){
                        info.addEventListener('click', function() {
                            Swal.fire({
                                background: '#fdff78ff',
                                icon: 'info',
                                iconColor: '#464646ff',
                                title: 'Informacion',
                                text:'| ID: {{ $usuario->id }} \n|'+
                                ' Nombre: {{ $usuario->usuarios }} \n|'+
                                ' Email: {{ $usuario->email }}\n|'+
                                @foreach ($estados as $estado)
                                    @if ($usuario->id_estado === $estado->id)
                                        ' Estado: {{ $estado->Nombre }} \n|'+
                                    @endif
                                @endforeach
                                ' Edad: {{ $usuario->Edad }} \n|'+
                                ' Sexo: {{ $usuario->Sexo }} \n|'+
                                ' Nivel: {{ $usuario->nivel }}',
                                confirmButtonText: 'Ok',
                                showCancelButton: false,
                                confirmButtonColor: '#7bff00ff',
                                customClass:{
                                    title: 'alerta_texto',
                                    confirmButton: 'confboton',
                                    popup: 'sa_pu',
                                },
                            })
                        })
                    }
                });
                </script>
                </tr>
                
            @endforeach
        </tbody>
        </table>
    <br><br>
</div>
</div>
    vi va enjambre beibi
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
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
</body>

</html>
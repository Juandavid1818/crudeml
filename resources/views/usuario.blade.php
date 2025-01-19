<html>

<head>
    <!-- Enlace al archivo de script externo -->
    <script src="../js/scrip.js" defer></script>

    <!-- Enlaces a CSS y JS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <!-- SweetAlert2 para alertas personalizadas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Font Awesome para íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- DataTables para tablas interactivas -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!-- Fuente personalizada -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Enlace al archivo CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <!-- Barra lateral con opciones -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h5>Opciones</h5>
                    <a href="{{ route('index') }}">Inicio</a><br>
                    <a href="{{ route('usuarios.desactivados') }}">Usuarios desactivados</a><br>
                </div>
            </div>

            <!-- Sección principal de la página -->
            <div class="col-md-9">
                <h1>Usuarios Desactivados</h1>

                <!-- Botones para ordenar la tabla -->
                <div class="d-flex justify-content-between mb-3">
                    <button id="sortAZ" class="btn btn-secondary">Ordenar A-Z</button>
                    <button id="sortZA" class="btn btn-secondary">Ordenar Z-A</button>
                </div>

                <!-- Tabla de usuarios desactivados -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Teléfono</th>
                                <th>Fecha de Registro</th>
                                <th>Fecha de Actualización</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($usuarios->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                            </tr>
                            @else
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <td>
                                    @if ($usuario->foto)
                                    <img src="{{ asset('storage/fotos/' . $usuario->foto) }}" alt="Foto" width="40" height="40">
                                    @else
                                    <img src="{{ asset('storage/fotos/perfil.png') }}" alt="Foto por defecto" width="40" height="40">
                                    @endif
                                </td>
                                <td>{{ $usuario->nombres }}</td>
                                <td>{{ $usuario->apellidos }}</td>
                                <td>{{ $usuario->telefono }}</td>
                                <td>{{ $usuario->fecha_registro }}</td>
                                <td>{{ $usuario->updated_at }}</td>
                                <td>
                                    <button class="boton" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $usuario->id }}">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación de Activación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres activar a este usuario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmActivarButton" href="" class="btn btn-primary">Activar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script para manejar el ID del usuario en el modal de activación
        var deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
        var confirmDeleteButton = document.getElementById('confirmActivarButton');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var userId = button.getAttribute('data-id');
                confirmDeleteButton.setAttribute('href', '/usuarios/activar/' + userId);
            });
        });

        $(document).ready(function() {
            // Inicializar DataTable con idioma en español
            var table = $('table').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sPrevious": "Anterior",
                        "sNext": "Siguiente",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": activar para ordenar la columna de manera descendente"
                    }
                }
            });

            // Manejar orden A-Z
            $('#sortAZ').on('click', function() {
                table.order([1, 'asc']).draw(); // Ordena la columna de "Nombre" en forma ascendente
            });

            // Manejar orden Z-A
            $('#sortZA').on('click', function() {
                table.order([1, 'desc']).draw(); // Ordena la columna de "Nombre" en forma descendente
            });
        });
    </script>
</body>

</html>

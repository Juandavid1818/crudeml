<!DOCTYPE html>
<html>

<head>
    <!-- Carga de scripts y estilos externos -->
    <script src="../js/scrip.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <!-- Barra lateral de opciones -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h5>Opciones</h5>
                    <a href="{{ route('index') }}">Inicio</a><br>
                    <a href="{{ route('usuarios.desactivados') }}">Usuarios desactivados</a><br>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="col-md-9">
                <h1>Usuario</h1>

                <!-- Botón para abrir el modal de agregar usuario -->
                <button type="button" class="btn btn-primary mb-3" id="openAddUserModal">
                    Agregar Usuario
                </button>

                <!-- Botones de ordenamiento -->
                <div class="d-flex justify-content-between mb-3">
                    <button id="sortAZ" class="btn btn-secondary">Ordenar A-Z</button>
                    <button id="sortZA" class="btn btn-secondary">Ordenar Z-A</button>
                </div>

                <!-- Modal para agregar usuario -->
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario para agregar un nuevo usuario -->
                                <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="nombres">Nombre</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                                        <small id="nameMessage" class="form-text"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="apellidos">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                        <small id="lastnameMessage" class="form-text"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="telefono">Teléfono</label>
                                        <input type="number" class="form-control" id="telefono" name="telefono" required>
                                        <small id="phoneMessage" class="form-text"></small>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="foto">Foto</label>
                                        <input type="file" class="form-control" id="foto" name="foto" accept="image/png, image/jpg, image/jpeg">
                                        <img id="preview" src="#" alt="Imagen previa" style="display: none; width: 100%; margin-top: 10px;">
                                        <small id="photoMessage" class="form-text"></small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de usuarios -->
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
                                <td colspan="8" class="text-center">No hay usuarios registrados.</td>
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
                                    <!-- Botones de edición y eliminación -->
                                    <button class="boton" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $usuario->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="boton" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="{{ $usuario->id }}">
                                        <i class="fas fa-trash-alt"></i>
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

    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación de Desactivación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres desactivar a este usuario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="confirmDeleteButton" href="" class="btn btn-danger">Desactivar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de edición -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para editar usuario -->
                    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                            <img id="fotoPreview" alt="Previsualización de la foto" width="100" height="100">
                        </div>

                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" value="{{ old('nombres', $usuario->nombres) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts adicionales -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        // Script para mostrar el modal de agregar usuario
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("openAddUserModal").addEventListener("click", function() {
                var addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
                addUserModal.show();
            });
        });

        // Script para cargar datos en el modal de edición
        document.querySelectorAll('[data-bs-target="#editModal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                const userId = button.getAttribute('data-id');
                fetch(`/usuarios/${userId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('#editModal #nombres').value = data.nombres || '';
                        document.querySelector('#editModal #apellidos').value = data.apellidos || '';
                        document.querySelector('#editModal #telefono').value = data.telefono || '';
                        document.querySelector('#editModal #fotoPreview').src = data.foto ? `/storage/fotos/${data.foto}` : '/images/default.png';
                        document.querySelector('#editModal form').action = `/usuarios/${userId}`;
                    });
            });
        });

        // Script para manejar eliminación de usuario
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                const userId = button.getAttribute('data-id');
                document.getElementById('confirmDeleteButton').href = `/usuarios/desactivar/${userId}`;
            });
        });

        // Inicialización de DataTables
        $(document).ready(function() {
            const table = $('table').DataTable({
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningún dato disponible en esta tabla",
                    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                    sSearch: "Buscar:",
                    oPaginate: {
                        sFirst: "Primero",
                        sPrevious: "Anterior",
                        sNext: "Siguiente",
                        sLast: "Último"
                    },
                }
            });

            // Manejo de botones de orden
            $('#sortAZ').on('click', function() {
                table.order([1, 'asc']).draw();
            });

            $('#sortZA').on('click', function() {
                table.order([1, 'desc']).draw();
            });
        });
    </script>
</body>

</html>

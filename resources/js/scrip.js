// Archivo: modals.js

document.addEventListener("DOMContentLoaded", function () {
    const addUserModalButton = document.getElementById("openAddUserModal");
    const deleteButtons = document.querySelectorAll('[data-bs-target="#confirmDeleteModal"]');
    const editButtons = document.querySelectorAll('[data-bs-target="#editModal"]');

    // Mostrar el modal de agregar usuario
    addUserModalButton.addEventListener("click", function () {
        Swal.fire({
            title: 'Agregar Usuario',
            html: document.getElementById('addUserModal').innerHTML,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: 'Guardar',
            preConfirm: () => {
                // Aquí puedes procesar el formulario
                Swal.fire('¡Éxito!', 'Usuario agregado correctamente.', 'success');
            }
        });
    });

    // Confirmación para eliminar usuario
    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás deshacer esta acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('¡Eliminado!', 'El usuario ha sido eliminado.', 'success');
                }
            });
        });
    });

    // Modal para editar usuario
    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            const userId = button.getAttribute('data-id');

            fetch(`/usuarios/${userId}/edit`)
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        title: 'Editar Usuario',
                        html: `
                            <input id="edit-nombres" class="swal2-input" placeholder="Nombre" value="${data.nombres}">
                            <input id="edit-apellidos" class="swal2-input" placeholder="Apellidos" value="${data.apellidos}">
                            <input id="edit-telefono" class="swal2-input" placeholder="Teléfono" value="${data.telefono}">
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Actualizar',
                        preConfirm: () => {
                            const nombres = document.getElementById('edit-nombres').value;
                            const apellidos = document.getElementById('edit-apellidos').value;
                            const telefono = document.getElementById('edit-telefono').value;

                            return fetch(`/usuarios/${userId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ nombres, apellidos, telefono })
                            }).then(response => {
                                if (!response.ok) {
                                    throw new Error('Error al actualizar');
                                }
                                Swal.fire('¡Actualizado!', 'El usuario ha sido actualizado.', 'success');
                            }).catch(error => {
                                Swal.fire('Error', 'No se pudo actualizar el usuario.', 'error');
                            });
                        }
                    });
                });
        });
    });
});

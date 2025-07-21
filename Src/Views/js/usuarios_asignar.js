document.addEventListener('DOMContentLoaded', function() {
    // Filtros
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    const usersTable = document.getElementById('usersTable');
    const rows = usersTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const resultsCount = document.getElementById('resultsCount');
    
    // Función para filtrar
    function filterUsers() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedRole = roleFilter.value;
        const selectedStatus = statusFilter.value;
        let visibleCount = 0;
        
        for (let row of rows) {
            const cells = row.getElementsByTagName('td');
            const nombre = cells[0].textContent.toLowerCase();
            const apellido = cells[1].textContent.toLowerCase();
            const rol = cells[2].textContent.trim();
            const estado = cells[3].textContent.trim();
            
            const matchesSearch = nombre.includes(searchTerm) || apellido.includes(searchTerm);
            const matchesRole = !selectedRole || rol === selectedRole;
            const matchesStatus = !selectedStatus || estado === selectedStatus;
            
            if (matchesSearch && matchesRole && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
        
        resultsCount.textContent = visibleCount + ' usuarios encontrados';
    }
    
    // Event listeners para filtros
    searchButton.addEventListener('click', filterUsers);
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') filterUsers();
    });
    roleFilter.addEventListener('change', filterUsers);
    statusFilter.addEventListener('change', filterUsers);
    
    // Gestión del modal de edición de roles
    const editButtons = document.querySelectorAll('.edit-roles-btn');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            
            fetch(`/user/rol/${userId}`)
            .then(response => {
                console.log('Respuesta del servidor:', response);
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data);
                if (data.status === 200) {
                    openEditRolesModal(userId, userName, data.data.rol);
                } else {
                    alert('Error al obtener rol: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                alert('Error al obtener rol del usuario: ' + error.message);
            });
        });
    });
    
    function openEditRolesModal(userId, userName, userRol) {
        document.getElementById('userName').textContent = userName;
        
        const currentRolesContainer = document.getElementById('currentRoles');
        currentRolesContainer.innerHTML = '';
        
        // Mostrar el rol actual
        const badge = document.createElement('span');
        badge.className = `badge ${getBadgeClassForRole(userRol)}`;
        badge.textContent = userRol;
        currentRolesContainer.appendChild(badge);
        
        // Seleccionar el radio button correspondiente al rol actual
        document.querySelector(`.role-radio[value="${userRol}"]`).checked = true;
        
        currentRolesContainer.setAttribute('data-user-id', userId);
        
        const modal = new bootstrap.Modal(document.getElementById('editRolesModal'));
        modal.show();
    }
    
    function getBadgeClassForRole(role) {
        switch(role) {
            case 'Administrador': return 'bg-danger';
            case 'Doctor': return 'bg-success';
            case 'Recepcionista': return 'bg-warning text-dark';
            case 'Paciente': return 'bg-info';
            default: return 'bg-primary';
        }
    }
    
    document.getElementById('saveRolesButton').addEventListener('click', saveUserRole);
    
    function saveUserRole() {
        const currentRolesContainer = document.getElementById('currentRoles');
        const userId = currentRolesContainer.getAttribute('data-user-id');
        
        if (!userId) {
            alert('No se ha seleccionado ningún usuario');
            return;
        }
        
        // Obtener el rol seleccionado
        const selectedRadio = document.querySelector('.role-radio:checked');
        
        if (!selectedRadio) {
            alert('Debe seleccionar un rol');
            return;
        }
        
        const nuevoRol = selectedRadio.value;
        
        fetch('/gestion/public/user/asignar-rol', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            body: JSON.stringify({
                user_id: userId,
                rol: nuevoRol
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 200) {
                alert('Rol actualizado correctamente');
                // Cerrar el modal
                bootstrap.Modal.getInstance(document.getElementById('editRolesModal')).hide();
                // Recargar la página para ver los cambios
                window.location.reload();
            } else {
                throw data;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar rol: ' + (error.message || 'Error desconocido'));
        });
  
    }
});
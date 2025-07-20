document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formCita');
    const idMedicoSelect = document.getElementById('id_medico');
    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');
    const horariosDisponiblesDiv = document.getElementById('horarios-disponibles');
    
    // Cargar horarios disponibles cuando cambian médico o fecha
    idMedicoSelect.addEventListener('change', cargarHorariosDisponibles);
    fechaInput.addEventListener('change', cargarHorariosDisponibles);
    
    // Seleccionar hora cuando se hace clic en un horario disponible
    horariosDisponiblesDiv.addEventListener('click', function(e) {
        if (e.target.classList.contains('horario-item')) {
            const hora = e.target.getAttribute('data-hora');
            horaSelect.value = hora;
            
            // Marcar como seleccionado
            document.querySelectorAll('.horario-item').forEach(item => {
                item.classList.remove('active');
            });
            e.target.classList.add('active');
        }
    });
    
    // Validación antes de enviar el formulario
    form.addEventListener('submit', function(e) {
        if (!validarFormulario()) {
            e.preventDefault();
        }
    });
    
    function cargarHorariosDisponibles() {
        const idMedico = idMedicoSelect.value;
        const fecha = fechaInput.value;
        
        if (idMedico && fecha) {
            fetch(`/gestion/public/api/cita/disponibilidad/${idMedico}/${fecha}`)
                .then(response => {
                    if (!response.ok) throw new Error('Error al obtener horarios');
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        mostrarHorariosDisponibles(data.data);
                    } else {
                        throw new Error(data.message || 'Error desconocido');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    horariosDisponiblesDiv.innerHTML = `
                        <div class="alert alert-danger">
                            ${error.message || 'Error al cargar horarios disponibles'}
                        </div>
                    `;
                });
        }
    }
    
    function mostrarHorariosDisponibles(horarios) {
        if (horarios.length === 0) {
            horariosDisponiblesDiv.innerHTML = `
                <div class="alert alert-warning">
                    No hay horarios disponibles para este médico en la fecha seleccionada
                </div>
            `;
            return;
        }
        
        let html = '';
        horarios.forEach(horario => {
            const horaFormatted = horario.Hora_Disponible || horario; // Ajuste según estructura de respuesta
            html += `
                <button type="button" class="list-group-item list-group-item-action horario-item" 
                        data-hora="${horaFormatted}">
                    ${horaFormatted}
                </button>
            `;
        });
        
        horariosDisponiblesDiv.innerHTML = html;
    }
    
    function validarFormulario() {
        let isValid = true;
        
        // Validar que se haya seleccionado una hora disponible
        if (horaSelect.value === '') {
            alert('Por favor seleccione un horario disponible');
            isValid = false;
        }
        
        // Validar que la fecha no sea pasada
        const fechaSeleccionada = new Date(fechaInput.value);
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        
        if (fechaSeleccionada < hoy) {
            alert('No puede agendar citas en fechas pasadas');
            isValid = false;
        }
        
        return isValid;
    }
    
    // Cargar horarios si ya hay valores seleccionados
    if (idMedicoSelect.value && fechaInput.value) {
        cargarHorariosDisponibles();
    }
});
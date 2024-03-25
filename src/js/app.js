document.addEventListener('DOMContentLoaded', function() {

    eventListeners();

    darkMode();
});

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    // Mostrar campos condicionales
    document.querySelectorAll('input[name="contacto[contacto]"]').forEach(input => input.addEventListener('click', mostrarMetodoContacto));
    
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    navegacion.classList.toggle('mostrar')
}

function mostrarMetodoContacto(event) {
    const contactoDiv = document.querySelector('#contacto');
    console.log(event.target.value);
    if(event.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <label for="telefono">Número Telefónico</label>
            <input type="tel" id="telefono" placeholder="Tu Teléfono" name="contacto[telefono]">

            <p>Elija fecha y hora para la llamada</p>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora:</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    } else {
        contactoDiv.innerHTML = `
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Tu Email" name="contacto[email]">
        `;
    }
}
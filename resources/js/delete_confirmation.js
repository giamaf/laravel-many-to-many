//# OPERAZIONI PRELIMINARI
const deleteForms = document.querySelectorAll('.delete-form');
const modal = document.getElementById('modal');
const modalBody = document.querySelector('.modal-body');
const modalTitle = document.querySelector('.modal-title');
const deleteConfirmation = document.getElementById('modal-delete-confirmation');


//# VARIABILI
let activeForm = null;

//# FUNZIONI
// Funzione per inserire i contenuti
const contentsFill = () => {
    deleteConfirmation.innerText = 'Delete';
    deleteConfirmation.className = 'btn btn-danger';
    modalTitle.innerText = 'Delete project';
    modalBody.innerText = 'Are you sure to delete this project?'
}

const deleteProject = () => {
    deleteConfirmation.addEventListener('click', () => {
        // Invio il form...
        if (activeForm) activeForm.submit();
    });
}

const clearActiveForm = () => {
    // Alla chiusura della modale...
    modal.addEventListener('hidden.bs.modal', () => {
        // Ripulisco l'active form
        activeForm = null;
    });
};

//* LOGICA -------------------------------------------
// Per ogni tasto 'cestino' aggiungo un event listener
deleteForms.forEach(form => {
    // Al click sul tasto 'cestino'...
    form.addEventListener('submit', e => {
        // Impedisco il ricaricamento della pagina
        e.preventDefault();

        // Al submit del form devo capire quale devo eliminare
        activeForm = form;
        console.log(activeForm);

        // Inserisco i contenuti
        contentsFill();
    });
});

// Al click sul tasto 'delete'...
deleteProject();

// Ripulisco l'activeForm
clearActiveForm();

//* --------------------------------------------------

// OPZIONE 1 -- Recupero gli elementi
const image = document.getElementById('image');
const preview = document.getElementById('preview');
const placeholder = 'https://marcolanci.it/boolean/assets/placeholder.png';
const resetButton = document.getElementById('reset-button');
const changeImageButton = document.getElementById('change-image-button');
const previousImageField = document.getElementById('previous-image-field');


console.log(changeImageButton, previousImageField);

//# LOGICA PREVIEW IMMAGINE
let blobUrl;

// Agganciamo un evento al cambio del file...
image.addEventListener('change', () => {
    //! Controllo se è stato caricato un file
    // Se è stato caricato allora...
    if (image.files && image.files[0]) {

        // Prendo il file caricato
        const file = image.files[0];

        // Costruisco un URL temporaneo
        blobUrl = URL.createObjectURL(file);

        // Inserisco il blob nell'src dell'immagine
        preview.src = blobUrl;
    } else {
        // Se NON è stato caricato alcun file allora metti il placeholder
        preview.src = placeholder;
    };
});

// Agganciamo un evento all'abbandono della pagina
window.addEventListener('beforeunload', () => {
    // Se è stato creato un URL temporaneo allora lo eliminalo
    if (blobUrl) URL.revokeObjectURL(blobUrl);
});

// Al click sul reset button reinserisco il placeholder
resetButton.addEventListener('click', () => {
    preview.src = placeholder;
});

//* OPZIONE 2 - Non recupero gli elementi ma ho delle variabili globali
// image.addEventListener('input', () => {
// C'è qualcosa nell'input?.. Se si allora metti il valore dell'input altrimenti il placeholder
// preview.src = image.value ? image.value : placeholder;
// })

//# LOGICA FILE INPUT
// Al click del button cambiamo azioniamo il toggle degli inputs
changeImageButton.addEventListener('click', () => {
    // Nascondo l'input con il button change image
    previousImageField.classList.add('d-none');

    // Mostro l'input con il button scegli file
    image.classList.remove('d-none');

    // Aggiorno la preview dell'immagine con il placeholder
    preview.src = placeholder;

    // Al click scateniamo l'evento (altrimenti dovremmo cliccare due volte per caricare il file)
    image.click();
})

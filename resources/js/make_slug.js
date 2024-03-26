// Recuper gli elementi
const projectName = document.getElementById('name');
const slug = document.getElementById('slug');

// All'uscita dal campo 'Project Name' fai qualcosa...
projectName.addEventListener('blur', () => {
    // Prendi il campo slug e mettici ciò che è stato inserito nel campo 'Project Name' opportunamente modificato con trattini al posto degli spazi
    slug.value = projectName.value.trim().toLowerCase().split(' ').join('-');
})

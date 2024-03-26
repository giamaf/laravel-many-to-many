<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Boolfolio - Project Technology

In questa repo aggiungo una nuova entità Technology al progetto sviluppato nella repo `laravel-one-to-many`.<br>
Questa entità rappresenta le tecnologie utilizzate ed è in relazione many to many con i progetti.<br>
I tasks sono: 
- creare il model Type
- creare la migration per la tabella types
- creare la migration di modifica per la tabella projects per aggiungere la chiave esterna
- aggiungere ai model Type e Project i metodi per definire la relazione one to many
- se presente, visualizzare nella pagina di dettaglio di un progetto la tipologia associata
- permettere all’utente di associare una tipologia nella pagina di creazione e modifica di un progetto
- gestire il salvataggio dell’associazione progetto-tipologia con opportune regole di validazione

---

#### Bonus:
1. creare il seeder per il model Technology
2. aggiungere le operazioni CRUD per il model Technology, in modo da gestire le tecnologie utilizzate nei progetti direttamente dal pannello di amministrazione.




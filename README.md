PHP Blog
===

- front office: post solo lettura per utenti non autenticati
- login
- back office: crud per i post per utenti autenticati

- title
- content
- author (user session)
- categories (tag)
- image

### Milestone 1
- importare il db
- creare form di login
- al login crea una nuova sessione per l'utente
- try/catch se i dati sono corretti o meno

### Milestone 2
- crea form per inserire dati nuovo prodotoo
- title, text, author
- utente autenticato tutte le operazioni crud
- utente non autenticato solo lettura 

### Milestone 3
- metodo per creazione nuova categoria
- aggiungere una select dentro al form

### Milestone 4
- aggiungi al form campo input per immagine
- nel form di update sostituire l'immagine se non presente



return header("Location: ../dashboard/form.php");
vs 
header("Location: ../dashboard.php");
exit();
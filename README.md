PHP Blog
===

Progetto in PHP Plain che permette all'utente autenticato di creare nuovi post e di modificare o eliminare quelli già esistenti, mentre l'utente non autenticato potrà accedere a tutti i post in modalità solo lettura.

### Scaffolding 
- Nella cartella principale sono presenti solo la Homepage e la pagina di Errore (index.php e error.php);
- Auth contiene le pagine relative all'autenticazione (login.php e signup.php);
- Admin contiente le pagine accessibili solo dopo essersi autenticati (forms e index.php);
- Models contiente le varie classi con i metodi applicati, compreso il controller;
- Storage contiene tutte le immagini che vengono inserire o aggiornate tramite form.

### Admin
Per tutte le pagine è presente un comando che controlla se la Sessione è aperta, altrimenti si viene reindirizzati alla pagina di Errore.
- Pagina Index: corrisponde alla Homepage della Dashboard; si accede ai propri post, eventualemente suddivisi per categoria;
- Form per le Categorie: serve a mostrare la lista completa delle categorie e ad aggiungerne di nuove.
- Form per i Post: permette sia creare che aggiornare un post, in base all'input passato dentro la pagina Index; vanno inseriti il titolo, il contenuto, un immagine e va scelta la categoria;
- Bottone Elimina: permette di fare una chiamata al database e di eliminare quel determinato record, compresa l'immagine associata.

### Auth
Le due pagine sono scritte in HTML puro e una volta inseriti i dati il controller indirizza al metodo a cui fare riferimento.
- Nel login verrà fatto un controllo: in caso di errore si viene reindirizzati alla stessa pagina, altrimenti parte un confronto con lo username e poi con la password codificata salvata nel database; 
- Nel signup verrà controllato se il nome dell'utente è già presente nel database; se non si trova un nome utente uguale allora si procede a codificare la password e salvare i dati nel database.

### Models
Il model Controller permette di gestire i dati provenienti dai vari form e richiama una determinato metodo in base all'input che arriva.
- Il model Database è la classe genitore che contiene il metodo per creare la connessione al database e caricare una nuova immagine nel server;
- Post, User, Catergory sono classi figlie della classe Database. Una volta creata una nuova connessione si accede ai vari metodi CRUD (per leggere, creare, modificare o cancellare record da una tabella) o metodi custom;
- Auth è una classe figlia di User ed accede ai suoi metodi per fare tutte le opeazioni relativa all'autenticazione.

### Storage
Cartella che contiene un'immagine che fa da placeholder e tante immagini quante sono quella caricate nella creazione dei post: la prima è visibile da Github mentre le altre vengono ignorate trimite il file .gitignore.

### Altro
- Error.php è la pagine dove si atterra se si prova ad accedere ad una pagine in cui c'è bisogno dell'autenticazione. Da questa pagina si può scegliere se tornare alla Homepage o alla pagina di Login.
- Index.php è la pagina che fa da Homepage, dove vengono stampati tutti i post di tutti gli utenti e sono accessibili a tutti in modalità solo lettura. Anche qui è possibile scegliere i post che fanno parte di una sola categoria.

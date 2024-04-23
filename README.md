PHP Blog
===

Progetto in PHP Plain che permette all'utente autenticato di creare nuovi post e di modificare o eliminare quelli già esistenti, mentre l'utente non autenticato potrà accedere a tutti i post in modalità solo lettura.

### Scaffolding 
Nella cartella principale sono presenti solo la Homepage e la pagina di Errore (index.php e error.php).
Tutte le pagine relative all'autenticazione (login.php e signup.php) si trovano all'interno di Auth.
Le pagine accessibili solo dopo essersi autenticati (forms e index.php) si trovano dentro Admin.
Le classi che contengono i metodi applicati, compreso il controller, si trovano all'interno della cartella Models.
Tutte le immagini che vengono inserire o aggiornate tramite form, vengono salvate nella cartella storage.

### Admin
A inizio codice, per tutte le pagine, è presente un comando che controlla se la Sessione è aperta o meno, altrimenti si viene reindirizzati alla pagina di Errore.
La pagina Index corrisponde alla Homepage della Dashboard. Vengono stampati tutti i Post ed è possibile accedere ai vari Form o di eliminare un determinato Post. E' possibile anche scegliere di vedere i Post solo di una determinata Categoria.
Il Form delle Categorie serve a mostrare la lista completa delle categorie e, eventualmente, ad aggiungerne di nuove con un piccolo Form a cui assegnare l'input name.
Il Form dei Post permette sia creare che aggiornare in base all'input passato dentro la pagina Index. Vanno inseriti il titolo, il contenuto e un immagine e va scelta la categoria. 
Il bottone Elimina permette di fare una chiamata al database e di eliminare quel determinato record, compresa l'immagine associata.

### Auth
Le due pagine sono scritte in HTML puro e una volta inseriti i dati, tramite controller che indirizza a quale metodo fare riferimento.
Nel login verrà fatto un controllo: se l'utente non esiste si ritorna alla pagine di Login altrimenti viene confrontata la password inserita con quella salata salvata nel database. Se non ci sono problemi si verrà reindirizzati alla Homepage della Dashboard.
Nel signup verrà controllato se il nome dell'utente è già presente nel database e se non si trova un nome utente uguale allora si procede a salare la password e salvare i dati nel database.

### Models
Il model Controller permette di gestire i dati provenienti dai vari form e richiama una determinato metodo in base all'input che arriva.
Il model Database è la classe genitore che contiene il metodo per creare la connessione al database e caricare una nuova immagine nel server.
Post, User, Catergory sono classi figlie della classe Database. Una volta creata una nuova connessione si accede ai vari metodi CRUD (per leggere, creare, modificare o cancellare record da una tabella) o metodi custom.
Auth è una classe figlia di User ed accede ai suoi metodi per fare tutte le opeazioni relativa all'autenticazione.

### Storage
Cartella che contiene un'immagine che fa da placeholder e tante immagini quante sono quella caricate nella creazione dei post.
La prima è visibile da Github mentre le altre vengono ignorate da file .gitignore.

### Altro
Error.php è la pagine dove si atterra se si prova ad accedere ad una pagine in cui c'è bisogno dell'autenticazione. Da questa pagina si può tornare alla Home o alla pagina di Login.
Index.php è la pagina che fa da Homepage, dove vengono stampati tutti i post di tutti gli utenti e sono accessibili a tutti in modalità solo lettura. Anche qui è possibile scegliere i post che fanno parte di una sola categoria.

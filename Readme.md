# Machine virtuelle (VM) à l'IUT

Plusieurs informations pour l'utilisation de la VM

### Pour démarrer la VM et le serveur de gestion des stages
1. Se connecter sur une station en salle Linux
2. Repérer l'adresse IP de la station hôte : `ip a show` ou `nslookup pc-dg-033-01`
3. Se placer dans le répertoire de votre groupe :

  Par exemple : `cd /users/Stockage-HDD/images-kvm/S4.A.01/groupes/groupe2/`

4. Exécuter le script de démarrage de la VM : `./launch.sh`
5. Vous disposez des droits administrateurs avec le compte:
	
	`root` (mdp : `root`) 
	
	et d'un compte standard `stage` (mdp : `stage`)
	
6. Se connecter avec le compte `stage`
7. Pour démarrer le serveur PHP de gestion des stages, faire : 
	
	`cd ~/bo-stages` 
	
	puis `symfony server:start -no-tls -d`
	
8. Le code du serveur se trouve entièrement dans ce répertoire
9. Pour arrêter le serveur faire `symfony server:stop`

### Se connecter au serveur de stages

La machine virtuelle est accessible depuis n'importe quelle station pour les ports 

	8000 (serveur de gestion des stages)
	et 
	2222 (accès distant ssh)

1. Accès depuis un navigateur avec l'URL :

	`http://localhost:8000` (en local), 
	
	`http://@IP.station.hôte:8000/` (à distance)
	
2. Accès à l'API REST du serveur :

	`http://localhost:8000/api/` (en local), 
	
	`http://@IP.station.hôte:8000/api/` (à distance)
	
3. Accès depuis l'application mobile (simulateur AndroidStudio), éditer le fichier 
	
	`mc2s-mobile/app/src/main/java/fr/iut2/saeprojet/api/APIClient.java`
	
	et mettre à jour la constante `BASE_URL` (ne pas mettre `127.0.0.1` ou `localhost`)
	
4. Accès en ssh depuis une station : `ssh stage@IP.station.hôte -p 2222`

5. Accéder au serveur postgres (ligne de commande) :
	1. Se connecter avec le compte `stage`
	2. Exécuter la commande `su -` (mdp `root`) pour un accès administrateur
	3. Exécuter la commande `su - postgres` pour un accès au compte `postgres`
	4. Pour se connecter avec l'utilisateur `postgres` (mdp `postgres`) : `psql -U app-stages -d app-stages -W -h 127.0.0.1`
	5. Pour se connecter à la **base app-stages** avec l'utilisateur `app-stages` (mdp `app-stages`) : `psql -U app-stages -d app-stages -W -h 127.0.0.1`

### Comptes pour l'application serveur de stages

Tous les comptes sont répertoriés dans l'extraction de la base (fichier `dump_BD.sql`). Il y a un compte administrateur `fontenae` (mdp `eric`) et des faux comptes étudiants comme `borealea` (mdp `aurore`).

# Machine virtuelle (VM) VirtualBox

1. Prévoir environ 9 Go à 10 Go d'espace disque
1. Télécharger l'application VirtualBox à l'adresse `https://www.virtualbox.org/` et faire une installation standard
2. Récupérer depuis le serveur `transit` les fichiers `SAE.vbox` et `serveur-sae-s4.vdi.xz` (image compressée, 1.7Go) depuis le répertoire `/users/Stockage-HDD/images-kvm/S4.A.01/install`
3. Placer les deux fichiers dans un même répertoire et décompresser l'image
4. Faire un double-click sur le fichier `SAE.vbox` : une nouvelle machine est automatiquement ajoutée dans VirtualBox
5. Dans l'application VirtualBox, il suffit de démarrer la VM. Elle est configurée pour accéder à internet et être accessible sur les ports 8000 et 2222 (voir plus haut)
6. Vous pouvez ensuite configurer le copier-coller entre votre station et la VM ainsi que des dossier partagés ce qui est pratique pour échanger des fichiers.


  

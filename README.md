Bonjour INCEPTUS
=========
## Pour Lenovo
### Génération des clés SSH
Générez vos clé SSH comme suit:  
ouvrir le **git bash** et taper:
>
>ssh-keygen -t rsa -C "GitLab" -b 4096
>
Puis avec **Powershell** taper: 
>
>cat ~/.ssh/id_rsa.pub | clip
>  

Naviguer au tab 'SSH Keys' dans '_Profile Settings_'. Coller votre clé, qui est déja dans le press papier, dans la zone de texte 'Key' et lui accorder un titre 'Title'  

### Configuration du git
Après l'ajout des clés SSH, dans le **git bash**  taper :
>git config --global "votre_username"  
>git config --global "votre_email"  

### Téléchrger le projet sur votre machine locale
Vous êtes maintenant prêt à télécharger le projet sur votre machine.
pour faire cette opération vous tapez :  

>git clone git@gitlab.com:pidev-inceptus/tahwissa-web.git  

### Commit et push des changements
Après avoir terminer une tâche vous pouvez envoyer votre travail en tapant les commandes suivantes : 
>git add --all  
>git commit -m "ce que vous avez fait exactement"  
>git push

Quelques remarques:  

```
* Pas de modification sur des fichiers qui se trouvent dans le dossier Vendor
* N' Oublier pas de taper :  
   > $git pull
* pour avoir les derniers changements 

# Mediatekformation
## Présentation
Ce site, développé avec Symfony 6.4, permet d'accéder aux vidéos d'auto-formation proposées par une chaîne de médiathèques et qui sont aussi accessibles sur YouTube.<br> 
Dans cette version, les fonctionnalités suivantes ont été développées et intégrées au back-office :<br>
<img width="525" height="494" alt="image" src="https://github.com/user-attachments/assets/328b41c1-6b64-45f0-87d1-ff579509aa43" /><br>

## Le lien vers le dépot origine :
Le dépôt d’origine est disponible ici :
https://github.com/CNED-SLAM/mediatekformation/blob/master/README.md
Ce dépôt contient la présentation complète de l’application d’origine dans son README.<br>

## Fonctionnalités ajoutées et mode opératoire :
### Page Gestion des formations
Cette page permet de gérer les formations disponibles sur la plateforme.<br>
Les fonctionnalités suivantes ont été ajoutées :<br>
•	Ajout de nouvelles formations.<br>
•	Modification des formations existantes.<br>
•	Suppression des formations.<br>
Ces fonctionnalités facilitent la gestion complète des formations pour les administrateurs.
<img width="929" height="458" alt="image" src="https://github.com/user-attachments/assets/a687073a-4f3a-4a6b-8541-9e23d4a8a224" /><br>

Pour ajouter une formation, l’administrateur doit cliquer sur le bouton Ajouter. Il est alors redirigé vers un formulaire d’ajout où il peut saisir les informations nécessaires.
<img width="926" height="454" alt="image" src="https://github.com/user-attachments/assets/149c027c-6d8d-405e-b99e-68e4e27c2928" /><br>

Pour modifier une formation, l’administrateur clique sur le bouton Modifier correspondant à la formation concernée. Il est ensuite redirigé vers un formulaire pré-rempli avec les informations actuelles de la formation, qu’il peut modifier avant de valider les changements.
<img width="945" height="448" alt="image" src="https://github.com/user-attachments/assets/199ac25c-1e20-4221-9f38-8c7e8d1e9387" /><br>
Pour supprimer une formation, l’administrateur doit cliquer sur le bouton Supprimer. Après validation d’un message de confirmation, la formation est supprimée et la liste des formations est automatiquement mise à jour.

### Page Gestion des playlists :
Cette page permet de gérer les playlists.<br>
Les fonctionnalités suivantes ont été ajoutées :<br>
•	Ajout de nouvelles playlist.<br>
•	Modification des playlists existantes.<br>
•	Suppression des playlists qui ne contient pas aucun formation.<br>
<img width="945" height="428" alt="image" src="https://github.com/user-attachments/assets/203eae6e-f827-41cc-966e-d874f0a46e7f" />
Pour ajouter une playlist, l’administrateur clique sur le bouton Ajouter et est redirigé vers un formulaire permettant de saisir les informations de la nouvelle playlist.
<img width="945" height="290" alt="image" src="https://github.com/user-attachments/assets/d1a861e2-b89c-4325-b038-c57e1bc1d2f2" />
Pour modifier une playlist, il clique sur le bouton Modifier associé à la playlist souhaitée, ce qui ouvre un formulaire pré-rempli avec les données actuelles, modifiables avant validation.
<img width="945" height="278" alt="image" src="https://github.com/user-attachments/assets/b07ff5d9-73cd-4037-ba5d-a4c73217919b" />
La suppression d’une playlist n’est possible que si celle-ci ne contient aucune formation. Si une playlist contient des formations, sa suppression est empêchée afin de garantir la cohérence des données.


### Page Gestion des catégories :
Cette page permet de gérer les categories.<br>
Les fonctionnalités suivantes ont été ajoutées :<br>
•	Ajout de nouvelles categorie.<br>
•	Suppression des categories qui n'est pas ataché au aucune formation.<br>
<img width="945" height="376" alt="image" src="https://github.com/user-attachments/assets/4bb0e009-4047-449f-a3b8-a22bf02a4901" /><br>
L’ajout d’une catégorie se fait via un petit formulaire accompagné d’un bouton Ajouter.
L’ajout n’est possible que si le nom saisi est unique dans la base de données et que le formulaire n’est pas vide, afin d’éviter les doublons et les entrées invalides.<br>
La suppression d’une catégorie n’est possible que si celle-ci n’est attachée à aucune formation. Si une catégorie est liée à des formations, sa suppression est bloquée pour garantir l’intégrité des données.


## Test de l'application en local
- Vérifier que Composer, Git et Wamserver (ou équivalent) sont installés sur l'ordinateur.
- Télécharger le code et le dézipper dans www de Wampserver (ou dossier équivalent) puis renommer le dossier en "mediatekformation".<br>
- Ouvrir une fenêtre de commandes en mode admin, se positionner dans le dossier du projet et taper "composer install" pour reconstituer le dossier vendor.<br>
- Dans phpMyAdmin, se connecter à MySQL en root sans mot de passe et créer la BDD 'mediatekformation'.<br>
- Récupérer le fichier mediatekformation.sql en racine du projet et l'utiliser pour remplir la BDD (si vous voulez mettre un login/pwd d'accès, il faut créer un utilisateur, lui donner les droits sur la BDD et il faut le préciser dans le fichier ".env" en racine du projet).<br>
- De préférence, ouvrir l'application dans un IDE professionnel. L'adresse pour la lancer est : http://localhost/mediatekformation/public/index.php<br>

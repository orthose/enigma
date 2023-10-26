# Description
Enigma est un site web PHP minimaliste permettant de créer des énigmes via formulaire.

# Déploiement
```shell
cd /var/www/html
git clone https://github.com/orthose/enigma.git
cd enigma
mkdir data
```

On ne doit pas pouvoir accéder aux fichiers du répertoire `data/` autrement que par PHP.
PHP doit avoir les permissions pour lire et écrire dans ce répertoire.
* **Apache**: Créer un fichier `.htaccess` dans ce répertoire.
```
Order deny,allow
Deny from all
```

* **NGINX**: Modifier le fichier de configuration.
```shell
sudo nano /etc/nginx/sites-available/html
```
```
location ^~ /enigma/data { deny all; }
```
```shell
sudo systemctl restart nginx.service
```

L'accès administrateur se fait via un token à configurer dans `config.php`.
```php
$config = array(
    "token" => "abc",
);
```

# Utilisation
Pour créer une énigme il suffit de créer un fichier JSON dans le répertoire `data/`.
```json
{
    "passwords": ["arbre", "brebis"],
    "reward": "abcdefghij"
}
```

Pour accéder à l'énigme et y répondre il suffit de paramétrer l'URL par le nom
du fichier sans l'extension. Par exemple pour un fichier `test.json`
il faudra entrer l'URL `http://localhost/enigma?id=test`.
Remplacez `localhost` par votre nom de domaine.

Le champ `reward` s'affiche lorsque tous les champs `passwords` du formulaire sont bien remplis.

Il existe également l'interface web de l'administrateur accessible via l'URL
`http://localhost/enigma/admin.php` pour créer et supprimer des énigmes sans avoir besoin
d'éditer manuellement les fichiers JSON.

* `http://localhost/enigma/admin.php`: Connexion à l'interface administrateur via le token.
* `http://localhost/enigma/admin.php?logout`: Déconnexion de l'interface administrateur.
* `http://localhost/enigma/admin.php?new=enigmaName`: Création d'une nouvelle énigme.
* `http://localhost/enigma/admin.php?del=enigmaName`: Suppression d'une énigme.

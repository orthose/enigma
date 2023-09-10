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

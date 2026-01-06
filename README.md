# Cassandre

Voici les liens pour s'y connecter :

-   nginx : 7840:80
-   cloudbeaver : 7841:8978
-   postgres : 7842:5432
-   mailer : 1025 et 8025

```text
http://localhost:7840
http://localhost:7841
```

et on définit la variable de nom de projet

```bash
PROJECT_NAME="Cassandre"
```

## Création de la stack de conteneurs Docker

<details><summary class="button">Spoiler</summary><div class="spoiler">

Ici l'on créé le `env.local` et l'on lui met les variables tels qu'identifiants et mots de passe de DB.

```bash
USER_ID=$(id -u)
GROUP_ID=$(id -g)
cat <<EOF > .env.local
DB_USER="root"
DB_PASSWORD="root"
DB_NAME="blog"
SERVER_VERSION="16"
DB_CONTAINER="postgres_cassandre"
USER_ID="${USER_ID}"
GROUP_ID="${GROUP_ID}"
DATABASE_URL="postgresql://\${DB_USER}:\${DB_PASSWORD}@\${DB_CONTAINER}:5432/\${DB_NAME}?serverVersion=\${SERVER_VERSION}&charset=utf8"
EOF
```

On lance le daemon de Docker (ou sinon via Docker Desktop)

```bash
sudo systemctl start docker
```

Et on lance le compose up

```bash
PROJECT_NAME="Cassandre"
docker compose -p "${(L)PROJECT_NAME}" --env-file .env.local up -d
```

### Connection au shell

Symfony est installé dans php, ici, c'est dans le conteneur `container_name: php_cassandre` donc

```bash
docker exec -it php_cassandre bash
```

On peut vérifier que tout est bien installé

```bash
composer --version
php bin/console --version
ls -la var/
```

Pour installer les dépendances

```bash
composer install
```

Pour enlever les alertes de sécurité

```bash
git config --global --add safe.directory /var/www
```

</div></details>

## Setup CloudBeaver

<details>
  <summary class="button">
    Spoiler
  </summary>
  <div class="spoiler">

J'au rempli **Administrator Credentials**.
**Login** : `Admin-user`
**Password** `Admin-password-1234`
**Repeat Password** `Admin-password-1234`

Normalement CloudBeaver est prêt à être utilisé, il ne reste qu'à cliquer sur son icône en haut à droite pour accéder au **tableau de bord CloudBeaver**.

### Connexion CloudBeaver à la DB

1. Dans le tableau de bord, cliquez sur **New Connection** et cherchez "PostgreSQL".
2. Créez une connexion PostgreSQL avec :

-   **Host** : `database` (il s'agit du nom du service `database:` dans le `compose.yml`)
-   **Port** : `5432` (le port "3851:5432")
-   **Database** : `blog` (il s'agit de la valeur dans le .yml POSTGRES_DB=blog )
-   **User name** : `root` (ce que j'ai stocké dans le .env dans notre cas)
-   **User password** : `root` (ce que j'ai stocké dans le .env dans notre cas)

Cocher `Save credentials for all users with access` puis `Create`.
Après ça, vous pourrez explorer vos tables et données.

  </div>
</details>

```bash
sudo systemctl start docker
docker compose -p "${(L)PROJECT_NAME}" start
docker compose -p "${(L)PROJECT_NAME}" stop
```

## Utilisation via CLI

On se connecte ainsi

```bash
docker exec -it php_cassandre bash
```

## Premières actions

On crée la base de donnée

```bash
php bin/console doctrine:database:create
```

On crée les entités

```bash
php bin/console make:entity Client
```

<details><summary class="button">Spoiler</summary><div class="spoiler">

PROPERTY

string
100

mail

ensuite

console make:crud

sur client

php bin/console make:crud

Client

ClientController

no pour les tests

php bin/console doctrine:schema:update --force

php bin/console make:controller pour faire d'autres controlleurs

</div></details>

<style>.spoiler{border-left:4px solid #1abc9c;border-bottom-left-radius:3px;padding-left:10px;padding-top:15px;margin-top:-10px;margin-bottom:15px}.button{cursor:pointer;padding:5px 10px;background-color:#3498db;color:white;border-radius:3px;margin-bottom:5px;display:inline-block;transition:background-color 0.2s}.button:hover{background-color:#217dbb}details[open] .button{background-color:#1abc9c}</style>

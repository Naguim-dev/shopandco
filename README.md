# Shopandco

Création d'un shop ecommerce.

## Environnement de développement / Dev environment

### Pré-requis / Requirements

- PHP 7.4
- Composer
- Symfony CLI
- Docker
- Docker-compose

Vous pouvez vérifier les pré-requis (sauf Docker et Docker-compose) avec la commande suivante (de la CLI Symfony) / You can verify requirements (except Docker and Docker-compose) with command (Symfony CLI):

```bash
symfony check:requirements
```

### Lancer l'environnement de développement / Launch dev environment

```bash
composer install
docker-compose up -d
symfony serve -d
```

### Ajout / Add fixtures

```bash
symfony console doctrine:fixtures:load
```

## Lancer les tests / Unit Test

```bash
php bin/phpunit --testdox
```

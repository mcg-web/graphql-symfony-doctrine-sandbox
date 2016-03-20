McG-web/Graphql-Symfony-Doctrine-Sandbox
========================================

[![Build Status](https://travis-ci.org/mcg-web/graphql-symfony-doctrine-sandbox.svg?branch=master)](https://travis-ci.org/mcg-web/graphql-symfony-doctrine-sandbox)

Installation
-------------

```bash
composer create-project mcg-web/graphql-symfony-doctrine-sandbox --stability dev
```

Usage
------

Using docker compose

```bash
docker-compose up -d
```

Create database and load fixtures

```bash
docker exec -it graphqlsymfonydoctrinesandbox_web_1 bash
bin/console doctrine:database:create
bin/console doctrine:schema:create
bin/console doctrine:fixtures:load
```

Endpoints
---------

- **GraphiQL :** http://127.0.0.1/graphiql
- **GraphQL :** http://127.0.0.1/

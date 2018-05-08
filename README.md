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

Blackfire
----------

```bash
docker exec -it graphqlsymfonydoctrinesandbox_blackfire_1 blackfire curl 'http://web' -H 'Content-Type: application/json' \
    --data-binary '{"query":"{ fake { name first: ships(first: 5) { ...shipConnection } withLastAndAfter: ships(last: 3, after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } withLastAndBeforeAndAfter: ships(last: 3, before: \"YXJyYXljb25uZWN0aW9uOjQ=\", after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } originalShips: ships(first: 2) { ...shipConnection } moreShips: ships(first: 3, after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } }} fragment shipConnection on ShipConnection { sliceSize edges { cursor node { name } } pageInfo { hasNextPage hasPreviousPage }}","variables":null,"operationName":null}'
```

```bash
docker exec -it graphqlsymfonydoctrinesandbox_blackfire_1 blackfire curl 'http://web/batch' -H 'Content-Type: application/json' \
    --data-binary '[{"query":"{ fake { name first: ships(first: 5) { ...shipConnection } withLastAndAfter: ships(last: 3, after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } withLastAndBeforeAndAfter: ships(last: 3, before: \"YXJyYXljb25uZWN0aW9uOjQ=\", after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } originalShips: ships(first: 2) { ...shipConnection } moreShips: ships(first: 3, after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } }} fragment shipConnection on ShipConnection { sliceSize edges { cursor node { name } } pageInfo { hasNextPage hasPreviousPage }}"}, {"query":"{ fake { name first: ships(first: 5) { ...shipConnection } withLastAndAfter: ships(last: 3, after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } withLastAndBeforeAndAfter: ships(last: 3, before: \"YXJyYXljb25uZWN0aW9uOjQ=\", after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } originalShips: ships(first: 2) { ...shipConnection } moreShips: ships(first: 3, after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } }} fragment shipConnection on ShipConnection { sliceSize edges { cursor node { name } } pageInfo { hasNextPage hasPreviousPage }}"}, {"query":"{ fake { name first: ships(first: 5) { ...shipConnection } withLastAndAfter: ships(last: 3, after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } withLastAndBeforeAndAfter: ships(last: 3, before: \"YXJyYXljb25uZWN0aW9uOjQ=\", after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } originalShips: ships(first: 2) { ...shipConnection } moreShips: ships(first: 3, after: \"YXJyYXljb25uZWN0aW9uOjE=\") { ...shipConnection } }} fragment shipConnection on ShipConnection { sliceSize edges { cursor node { name } } pageInfo { hasNextPage hasPreviousPage }}"}]'
```

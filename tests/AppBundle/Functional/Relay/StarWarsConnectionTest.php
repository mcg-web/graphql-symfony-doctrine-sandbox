<?php

namespace Tests\AppBundle\Functional\Relay;

use Tests\AppBundle\Functional\WebTestCase;

class StarWarsConnectionTest extends WebTestCase
{
    public function testFetchesTheFirstShipOfTheRebels()
    {
        $query = <<<EOF
query RebelsShipsQuery {
  rebels {
    name
    ships(first: 1) {
      edges {
        node {
          name
        }
      }
    }
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "rebels": {
      "name": "Alliance to Restore the Republic",
      "ships": {
        "edges": [
          {
            "node": {
              "name": "X-Wing"
            }
          }
        ]
      }
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testFetchesTheFirstTwoShipsOfTheRebelsWithACursor()
    {
        $query = <<<EOF
query MoreRebelShipsQuery {
  rebels {
    name
    ships(first: 2) {
      edges {
        cursor
        node {
          name
        }
      }
    }
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "rebels": {
      "name": "Alliance to Restore the Republic",
      "ships": {
        "edges": [
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjA=",
            "node": {
              "name": "X-Wing"
            }
          },
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjE=",
            "node": {
              "name": "Y-Wing"
            }
          }
        ]
      }
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testFetchesTheNextThreeShipsOfTheRebelsWithACursor()
    {
        $query = <<<EOF
query EndOfRebelShipsQuery {
  rebels {
    name
    ships(first: 3, after: "YXJyYXljb25uZWN0aW9uOjE=") {
      edges {
        cursor
        node {
          name
        }
      }
    }
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "rebels": {
      "name": "Alliance to Restore the Republic",
      "ships": {
        "edges": [
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjI=",
            "node": {
              "name": "A-Wing"
            }
          },
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjM=",
            "node": {
              "name": "Millenium Falcon"
            }
          },
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjQ=",
            "node": {
              "name": "Home One"
            }
          }
        ]
      }
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testFetchesNoShipsOfTheRebelsAtTheEndOfConnection()
    {
        $query = <<<EOF
query RebelsQuery {
  rebels {
    name
    ships(first: 3, after: "YXJyYXljb25uZWN0aW9uOjQ=") {
      edges {
        cursor
        node {
          name
        }
      }
    }
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "rebels": {
      "name": "Alliance to Restore the Republic",
      "ships": {
        "edges": []
      }
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testIdentifiesTheEndOfTheList()
    {
        $query = <<<EOF
query EndOfRebelShipsQuery {
  rebels {
    name
    originalShips: ships(first: 2) {
      edges {
        node {
          name
        }
      }
      pageInfo {
        hasNextPage
      }
    }
    moreShips: ships(first: 3, after: "YXJyYXljb25uZWN0aW9uOjE=") {
      edges {
        node {
          name
        }
      }
      pageInfo {
        hasNextPage
      }
    }
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "rebels": {
      "name": "Alliance to Restore the Republic",
      "originalShips": {
        "edges": [
          {
            "node": {
              "name": "X-Wing"
            }
          },
          {
            "node": {
              "name": "Y-Wing"
            }
          }
        ],
        "pageInfo": {
          "hasNextPage": true
        }
      },
      "moreShips": {
        "edges": [
          {
            "node": {
              "name": "A-Wing"
            }
          },
          {
            "node": {
              "name": "Millenium Falcon"
            }
          },
          {
            "node": {
              "name": "Home One"
            }
          }
        ],
        "pageInfo": {
          "hasNextPage": false
        }
      }
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testFetchesShipsWithLastBeforeAndAfter()
    {
        $query = <<<EOF
query EndOfRebelShipsWithLastAndBeforeAndAfterQuery {
  rebels {
    name
    ships: ships(last: 3, before: "YXJyYXljb25uZWN0aW9uOjQ=", after: "YXJyYXljb25uZWN0aW9uOjE=") {
      edges {
        cursor
        node {
          name
        }
      }
      pageInfo {
        hasNextPage
        hasPreviousPage
      }
    }
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "rebels": {
      "name": "Alliance to Restore the Republic",
      "ships": {
        "edges": [
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjI=",
            "node": {
              "name": "A-Wing"
            }
          },
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjM=",
            "node": {
              "name": "Millenium Falcon"
            }
          }
        ],
        "pageInfo": {
          "hasNextPage": false,
          "hasPreviousPage": false
        }
      }
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testFetchesShipsWithLastAfter()
    {
        $query = <<<EOF
query EndOfRebelShipsWithLastAndAfterQuery {
  rebels {
    name
    ships: ships(last: 3, after: "YXJyYXljb25uZWN0aW9uOjE=") {
      edges {
        cursor
        node {
          name
        }
      }
      pageInfo {
        hasNextPage
        hasPreviousPage
      }
    }
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "rebels": {
      "name": "Alliance to Restore the Republic",
      "ships": {
        "edges": [
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjI=",
            "node": {
              "name": "A-Wing"
            }
          },
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjM=",
            "node": {
              "name": "Millenium Falcon"
            }
          },
          {
            "cursor": "YXJyYXljb25uZWN0aW9uOjQ=",
            "node": {
              "name": "Home One"
            }
          }
        ],
        "pageInfo": {
          "hasNextPage": false,
          "hasPreviousPage": false
        }
      }
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }
}

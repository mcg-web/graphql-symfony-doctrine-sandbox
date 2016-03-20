<?php

namespace Tests\AppBundle\Functional\Relay;

use Tests\AppBundle\Functional\WebTestCase;

class StarWarsObjectIdentificationTest extends WebTestCase
{
    public function testFetchesTheIdAndNameOfTheRebels()
    {
        $query = <<<EOF
query RebelsQuery {
  rebels {
    id
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "rebels": {
      "id": "RmFjdGlvbjox",
      "name": "Alliance to Restore the Republic"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testRefetchesTheRebels()
    {
        $query = <<<EOF
query RebelsRefetchQuery {
  node(id: "RmFjdGlvbjox") {
    id
    ... on Faction {
      name
    }
  }
}

EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "node": {
      "id": "RmFjdGlvbjox",
      "name": "Alliance to Restore the Republic"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testFetchesTheIdAndNameOfTheEmpire()
    {
        $query = <<<EOF
query EmpireQuery {
  empire {
    id
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "empire": {
      "id": "RmFjdGlvbjoy",
      "name": "Galactic Empire"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testRefetchesTheXWing()
    {
        $query = <<<EOF
query XWingRefetchQuery {
  node(id: "U2hpcDox") {
    id
    ... on Ship {
      name
    }
  }
}

EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "node": {
      "id": "U2hpcDox",
      "name": "X-Wing"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }
}

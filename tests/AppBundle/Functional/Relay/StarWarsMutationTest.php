<?php

namespace Tests\AppBundle\Functional\Relay;

use Tests\AppBundle\Functional\WebTestCase;

class StarWarsMutationTest extends WebTestCase
{
    public function testMutatesTheDataSet()
    {
        $query = <<<'EOF'
mutation AddBWingQuery($input: IntroduceShipInput!) {
  introduceShip(input: $input) {
    ship {
      id
      name
    }
    faction {
      name
    }
    clientMutationId
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "introduceShip": {
      "ship": {
        "id": "U2hpcDo5",
        "name": "B-Wing"
      },
      "faction": {
        "name": "Alliance to Restore the Republic"
      },
      "clientMutationId": "abcde"
    }
  }
}
EOF;
        $jsonVariables = <<<EOF
{
  "input": {
    "shipName": "B-Wing",
    "factionId": "1",
    "clientMutationId": "abcde"
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected, $jsonVariables);
        $this->resetDatabase();
    }
}

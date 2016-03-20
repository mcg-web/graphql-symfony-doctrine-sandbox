<?php

namespace Tests\AppBundle\Functional\Relay;

use Tests\AppBundle\Functional\WebTestCase;

class StarWarsQueryTest extends WebTestCase
{
    public function testBasicQueries()
    {
        $query = <<<'EOF'
query HeroNameQuery {
  hero {
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "hero": {
      "name": "R2-D2"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testAllowsUsToQueryForTheIdAndFriendsOfR2D2()
    {
        $query = <<<'EOF'
query HeroNameAndFriendsQuery {
  hero {
    id
    name
    friends {
      name
    }
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "hero": {
      "id": "2001",
      "name": "R2-D2",
      "friends": [
        {
          "name": "Luke Skywalker"
        },
        {
          "name": "Han Solo"
        },
        {
          "name": "Leia Organa"
        }
      ]
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testAllowsUsToQueryForTheFriendsOfFriendsOfR2D2()
    {
        $query = <<<'EOF'
query NestedQuery {
  hero {
    name
    friends {
      name
      appearsIn
      friends {
        name
      }
    }
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "hero": {
      "name": "R2-D2",
      "friends": [
        {
          "name": "Luke Skywalker",
          "appearsIn": [
            "NEWHOPE",
            "EMPIRE",
            "JEDI"
          ],
          "friends": [
            {
              "name": "Han Solo"
            },
            {
              "name": "Leia Organa"
            },
            {
              "name": "C-3PO"
            },
            {
              "name": "R2-D2"
            }
          ]
        },
        {
          "name": "Han Solo",
          "appearsIn": [
            "NEWHOPE",
            "EMPIRE",
            "JEDI"
          ],
          "friends": [
            {
              "name": "Luke Skywalker"
            },
            {
              "name": "Leia Organa"
            },
            {
              "name": "R2-D2"
            }
          ]
        },
        {
          "name": "Leia Organa",
          "appearsIn": [
            "NEWHOPE",
            "EMPIRE",
            "JEDI"
          ],
          "friends": [
            {
              "name": "Luke Skywalker"
            },
            {
              "name": "Han Solo"
            },
            {
              "name": "C-3PO"
            },
            {
              "name": "R2-D2"
            }
          ]
        }
      ]
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testAllowsUsToQueryForLukeSkywalkerDirectlyUsingHisId()
    {
        $query = <<<'EOF'
query FetchLukeQuery {
  human(id: "1000") {
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "human": {
      "name": "Luke Skywalker"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testAllowsUsToCreateAGenericQueryThenUseItToFetchLukeSkywalkerUsingHisId()
    {
        $query = <<<'EOF'
query FetchSomeIDQuery($someId: String!) {
  human(id: $someId) {
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "human": {
      "name": "Luke Skywalker"
    }
  }
}
EOF;
        $jsonVariables = <<<EOF
{
  "someId": "1000"
}
EOF;

        $this->assertQuery($query, $jsonExpected, $jsonVariables);
    }

    public function testAllowsUsToCreateAGenericQueryThenUseItToFetchHanSoloUsingHisId()
    {
        $query = <<<'EOF'
query FetchSomeIDQuery($someId: String!) {
  human(id: $someId) {
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "human": {
      "name": "Han Solo"
    }
  }
}
EOF;
        $jsonVariables = <<<EOF
{
  "someId": "1002"
}
EOF;

        $this->assertQuery($query, $jsonExpected, $jsonVariables);
    }

    public function testAllowsUsToCreateAGenericQueryThenPassAnInvalidIdToGetNullBack()
    {
        $query = <<<'EOF'
query humanQuery($id: String!) {
  human(id: $id) {
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "human": null
  }
}
EOF;
        $jsonVariables = <<<EOF
{
  "id": "not a valid id"
}
EOF;

        $this->assertQuery($query, $jsonExpected, $jsonVariables);
    }

    public function testAllowsUsToQueryForLukeChangingHisKeyWithAnAlias()
    {
        $query = <<<'EOF'
query FetchLukeAliased {
  luke: human(id: "1000") {
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "luke": {
      "name": "Luke Skywalker"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testAllowsUsToQueryForBothLukeAndLeiaUsingTwoRootFieldsAndAnAlias()
    {
        $query = <<<'EOF'
query FetchLukeAndLeiaAliased {
  luke: human(id: "1000") {
    name
  }
  leia: human(id: "1003") {
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "luke": {
      "name": "Luke Skywalker"
    },
    "leia": {
      "name": "Leia Organa"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testAllowsUsToQueryUsingDuplicatedContent()
    {
        $query = <<<'EOF'
query DuplicateFields {
  luke: human(id: "1000") {
    name
    homePlanet
  }
  leia: human(id: "1003") {
    name
    homePlanet
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "luke": {
      "name": "Luke Skywalker",
      "homePlanet": "Tatooine"
    },
    "leia": {
      "name": "Leia Organa",
      "homePlanet": "Alderaan"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testAllowsUsToUseAFragmentToAvoidDuplicatingContent()
    {
        $query = <<<'EOF'
query UseFragment {
  luke: human(id: "1000") {
    ...HumanFragment
  }
  leia: human(id: "1003") {
    ...HumanFragment
  }
}

fragment HumanFragment on Human {
  name
  homePlanet
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "luke": {
      "name": "Luke Skywalker",
      "homePlanet": "Tatooine"
    },
    "leia": {
      "name": "Leia Organa",
      "homePlanet": "Alderaan"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testAllowsUsToVerifyThatR2D2IsADroid()
    {
        $query = <<<'EOF'
query CheckTypeOfR2 {
  hero {
    __typename
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "hero": {
      "__typename": "Droid",
      "name": "R2-D2"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }

    public function testAllowsUsToVerifyThatLukeIsAHuman()
    {
        $query = <<<'EOF'
query CheckTypeOfLuke {
  hero(episode: EMPIRE) {
    __typename
    name
  }
}
EOF;

        $jsonExpected = <<<EOF
{
  "data": {
    "hero": {
      "__typename": "Human",
      "name": "Luke Skywalker"
    }
  }
}
EOF;

        $this->assertQuery($query, $jsonExpected);
    }
}

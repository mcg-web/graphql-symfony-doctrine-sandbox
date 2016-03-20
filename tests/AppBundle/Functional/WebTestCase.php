<?php

namespace Tests\AppBundle\Functional;

use Doctrine\ORM\Tools\SchemaTool;
use Liip\FunctionalTestBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    private static $dbLoaded = false;

    public function setUp()
    {
        if (self::$dbLoaded) {
            return;
        }
        $this->resetDatabase();
        self::$dbLoaded = true;
    }

    protected function resetDatabase()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        if (!isset($metadatas)) {
            $metadatas = $em->getMetadataFactory()->getAllMetadata();
        }
        $schemaTool = new SchemaTool($em);
        $schemaTool->dropDatabase();
        if (!empty($metadatas)) {
            $schemaTool->createSchema($metadatas);
        }
        $this->postFixtureSetup();

        $this->loadFixtures([
            'AppBundle\DataFixtures\ORM\LoadCharacterData',
            'AppBundle\DataFixtures\ORM\LoadShipAndFactionData'
        ]);
    }

    protected function assertQuery($query, $jsonExpected, $jsonVariables = '{}')
    {
        $client = static::makeClient();
        $path = $this->getUrl('overblog_graphql_endpoint');

        $client->request(
            'GET', $path, ['query' => $query, 'variables' => $jsonVariables], [], ['CONTENT_TYPE' => 'application/graphql']
        );
        $result = $client->getResponse()->getContent();
        $this->assertStatusCode(200, $client);
        $this->assertEquals(json_decode($jsonExpected, true), json_decode($result, true), $result);
    }
}

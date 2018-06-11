<?php
namespace CFX\Brokerage;

class LegalEntityTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;
    protected $className = '\\CFX\\Brokerage\\LegalEntity';

    public function testResourceType() {
        $this->assertEquals('legal-entities', $this->resource->getResourceType());
    }

    public function testType() {
        $field = 'type';

        $this->assertInvalid($field, [ null, '', 'bunk' ]);
        $this->assertValid($field, LegalEntity::getValidTypes());
        $this->assertChanged($field, LegalEntity::getValidTypes()[1], 'attributes');
        $this->assertChains($field);
    }

    public function testLegalId() {
        $field = 'legalId';

        $this->assertInvalid($field, [ [], new \DateTime() ]);
        $this->assertValid($field, [ null, '', "555-11-2233", "555112233", "12345", 12345, "AB23GG3298" ]);
        $this->assertChanged($field, "111111111", 'attributes');
        $this->assertChains($field);
    }

    public function testLegalName() {
        $field = 'legalName';

        $this->assertInvalid($field, [ [], new \DateTime() ]);
        $this->assertValid($field, [ null, '', "OneWordName", "Some Name" ]);
        $this->assertChanged($field, "Tester Name", 'attributes');
        $this->assertChains($field);
    }

    public function testDateOfBirth() {
        $field = 'dateOfBirth';
        $this->_testDateField($field, false);
        $this->assertChains($field);
    }

    public function testDateOfBirthSerializesCorrectly()
    {
        $date = new \DateTime();
        $this->resource->setDateOfBirth($date);
        $data = json_decode(json_encode($this->resource), true);
        $this->assertEquals($date->format("Y-m-d"), $data['attributes']['dateOfBirth']);

        // Shouldn't choke when serializing bad values
        $this->resource->setDateOfBirth("excalibur!!");
        $data = json_decode(json_encode($this->resource), true);
        $this->assertEquals("excalibur!!", $data['attributes']['dateOfBirth']);
    }

    public function testPlaceOfOrigin() {
        $field = 'placeOfOrigin';

        $this->assertInvalid($field, [ [], new \DateTime(), 12345 ]);
        $this->assertValid($field, [ null, '', "US", "US:AL", "Abu Dhabi", "UK:London" ]);
        $this->assertChanged($field, "India", 'attributes');
        $this->assertChains($field);
    }

    public function testFinraStatus()
    {
        $field = 'finraStatus';

        $this->assertInvalid($field, [ 15, 'good', 'bad', 'true', 'false' ]);
        $this->assertValid($field, [ 1, '1', true, 0, '0', false, null ], function($expected, $actual) {
            if ($expected === null) {
                $this->assertNull($actual);
            } else {
                $this->assertEquals((bool)$expected, $actual);
            }
        });
        $this->assertChanged($field, true, 'attributes');
        $this->assertChains($field);
    }

    public function testNetWorth()
    {
        $field = "netWorth";
        $this->assertValid($field, [ 1234555, "500000", 0, null, '' ]);
        $this->assertInvalid($field, [ "cool", true, false, [ "array-of-things" ], new \DateTime() ]);
        $this->assertChanged($field, 300000, "attributes");
        $this->assertChains($field);
    }

    public function testAnnualIncome()
    {
        $field = "annualIncome";
        $this->assertValid($field, [ 1234555, "500000", 0, null, '' ]);
        $this->assertInvalid($field, [ "cool", true, false, [ "array-of-things" ], new \DateTime() ]);
        $this->assertChanged($field, 300000, "attributes");
        $this->assertChains($field);
    }

    public function testAccreditationStatus()
    {
        $field = "accreditationStatus";
        $this->assertFalse($this->resource->hasErrors($field), "Should instantiate cleanly");
        $this->assertReadOnly($field, 2);
        $this->assertEquals(LegalEntity::getValidAccreditationStatuses()[0], $this->resource->getAccreditationStatus());
    }

    public function testAccreditationStatusExtended(LegalEntityInterface $resource = null)
    {
        if ($resource) {
            $this->resource = $resource;
        } else {
            $this->resource = new Test\LegalEntity($this->datasource);
        }

        $field = "accreditationStatus";
        $statuses = LegalEntity::getValidAccreditationStatuses();
        $statuses = array_merge($statuses, array_keys($statuses), [ "0", "1", "2" ]);
        $this->assertValid($field, $statuses, function($expected, $actual) use ($field) {
            $origExpected = $expected;
            if (is_numeric($expected)) {
                $expected = LegalEntity::getValidAccreditationStatuses()[$expected];
            }
            $this->assertEquals([], $this->resource->getErrors($field));
            $this->assertEquals($expected, $actual, "Expected status '$expected' (from '$origExpected'), but got '$actual'");
        });
        $this->assertInvalid($field, [ "cool", "true", "false", [ "array-of-things" ], new \DateTime(), 3, -1 ]);
        $this->assertChanged($field, "In Review", "attributes");
        $this->assertChains($field);

        // Test serialization
        $this->resource->setAccreditationStatus(LegalEntity::getValidAccreditationStatuses()[2]);
        $serialized = json_decode(json_encode($this->resource), true);
        $this->assertEquals(2, $serialized["attributes"][$field], "Should have serialized to integer but didn't");
    }

    public function testFinraStatusText()
    {
        $field = 'finraStatusText';

        $this->assertInvalid($field, [ 15, true, false, new \DateTime() ]);
        $this->assertValid($field, [ null, '', 'All good', 'Nothing to see here' ]);
        $this->assertChanged($field, 'Some new finra status text', 'attributes');
        $this->assertChains($field);
    }

    public function testCorporateStatus()
    {
        $field = 'corporateStatus';

        $this->assertInvalid($field, [ 15, 'good', 'bad', 'true', 'false' ]);
        $this->assertValid($field, [ 1, '1', true, 0, '0', false, null ], function($expected, $actual) {
            if ($expected === null) {
                $this->assertNull($actual);
            } else {
                $this->assertEquals((bool)$expected, $actual);
            }
        });
        $this->assertChanged($field, true, 'attributes');
        $this->assertChains($field);
    }

    public function testCorporateStatusText()
    {
        $field = 'corporateStatusText';

        $this->assertInvalid($field, [ 15, true, false, new \DateTime() ]);
        $this->assertValid($field, [ null, '', 'All good', 'Nothing to see here' ]);
        $this->assertChanged($field, 'Some new corporate status text', 'attributes');
        $this->assertChains($field);
    }

    public function testCustodianName()
    {
        $field = 'custodianName';

        $this->assertInvalid($field, [ 15, true, false, new \DateTime() ]);
        $this->assertValid($field, [ null, '', 'Custodian One' ]);
        $this->assertChanged($field, 'Custodian Two', 'attributes');
        $this->assertChains($field);
    }

    public function testCustodianAccountNum()
    {
        $field = 'custodianAccountNum';

        $this->assertInvalid($field, [ true, false, new \DateTime() ]);
        $this->assertValid($field, [ null, '', 12345567, '1234567', 'ABC123-333.551' ]);
        $this->assertChanged($field, '111111111111111', 'attributes');
        $this->assertChains($field);
    }

    public function testWalletAccount()
    {
        $field = "walletAccount";
        $this->assertReadOnly($field, (new WalletAccount($this->datasource))->setId("12345"));
    }

    public function testPrimaryAddress() {
        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors('primaryAddress'));

        $val = (new Address($this->datasource))
            ->setId('12345');
        $this->resource->setPrimaryAddress($val);
        $this->assertFalse($this->resource->hasErrors('primaryAddress'));
        $this->assertEquals($val, $this->resource->getPrimaryAddress());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains('relationships', array_keys($changes));
        $this->assertContains('primaryAddress', array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships']['primaryAddress']->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setPrimaryAddress($val));
    }

    public function testIdDocs() {
        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors('idDocs'));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated('idDocs', $val);

        $this->resource->setIdDocs($val);
        $this->assertFalse($this->resource->hasErrors('idDocs'));
        $this->assertEquals($val, $this->resource->getIdDocs());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains('idDocs', array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships']['idDocs']->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setIdDocs($val));

        // AddIdDoc
        $doc = new Document($this->datasource);
        $this->resource->addIdDoc($doc);
        $this->assertFalse($this->resource->hasErrors('idDocs'));
        $this->assertEquals(1, count($this->resource->getIdDocs()));

        // HasIdDoc
        $this->assertTrue($this->resource->hasIdDoc($doc));

        // RemoveIdDoc
        $this->resource->removeIdDoc($doc);
        $this->assertFalse($this->resource->hasErrors('idDocs'));
        $this->assertEquals(0, count($this->resource->getIdDocs()));
    }

    public function testAccreditationDocs() {
        $field = "accreditationDocs";

        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors($field));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated($field, $val);

        $this->resource->setAccreditationDocs($val);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals($val, $this->resource->getAccreditationDocs());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains($field, array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships'][$field]->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setAccreditationDocs($val));

        // AddDoc
        $doc = new Document($this->datasource);
        $this->resource->addAccreditationDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(1, count($this->resource->getAccreditationDocs()));

        // HasDoc
        $this->assertTrue($this->resource->hasAccreditationDoc($doc));

        // RemoveDoc
        $this->resource->removeAccreditationDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(0, count($this->resource->getAccreditationDocs()));
    }

    public function testResidencyDocs() {
        $field = "residencyDocs";

        // Assert field NOT required
        $this->assertFalse($this->resource->hasErrors($field));

        $val = new \CFX\JsonApi\ResourceCollection();
        $this->datasource->setRelated($field, $val);

        $this->resource->setResidencyDocs($val);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals($val, $this->resource->getResidencyDocs());

        // Assert changed
        $changes = $this->resource->getChanges();
        $this->assertContains($field, array_keys($changes['relationships']));
        $this->assertSame($val, $changes['relationships'][$field]->getData());

        // Assert chaining
        $this->assertSame($this->resource, $this->resource->setResidencyDocs($val));

        // AddDoc
        $doc = new Document($this->datasource);
        $this->resource->addResidencyDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(1, count($this->resource->getResidencyDocs()));

        // HasDoc
        $this->assertTrue($this->resource->hasResidencyDoc($doc));

        // RemoveDoc
        $this->resource->removeResidencyDoc($doc);
        $this->assertFalse($this->resource->hasErrors($field));
        $this->assertEquals(0, count($this->resource->getResidencyDocs()));
    }


    public function testIntegration() {
        $data = [
            "type" => "legal-entities",
            "attributes" => [
                "type" => "person",
                "legalId" => "111223333",
                "legalName" => "My Person",
            ],
            "relationships" => [
                "primaryAddress" => [
                    "data" => [
                        "type" => "addresses",
                        "id" => "12345",
                    ],
                ],
                "idDocs" => [
                    "data" => [
                        [
                            "type" => 'documents',
                            "id" => "12345",
                        ],
                    ],
                ],
            ],
        ];

        $this->datasource
            ->addClassToCreate("\\CFX\\Brokerage\\Address")
            ->addClassToCreate("\\CFX\\Brokerage\\Document")
        ;

        $entity = new LegalEntity($this->datasource, $data);
        $this->assertFalse($entity->hasErrors());

        $data["attributes"]["accreditationStatus"] = 0;
        $this->assertEquals($data, json_decode(json_encode($entity->getChanges()), true));
    }
}


<?php
namespace CFX\Brokerage;

class TenderTest extends \PHPUnit\Framework\TestCase
{
    use \CFX\ResourceTestTrait;

    protected $className = "\\CFX\\Brokerage\\Tender";

    public function testResourceType()
    {
        $this->assertEquals('tenders', $this->resource->getResourceType());
    }

    public function testSharePrice()
    {
        $field = 'sharePrice';
        $this->assertValid($field, [ 1, 1.50, 1.5223, 0.195, '1.525', '3', 12345.6789 ]);
        $this->assertInvalid($field, [ null, '', 0, -1, new \DateTime(), true, false, [], 'one fifty', 105526.32333 ]);
        $this->assertChanged($field, 1.11, "attributes");
        $this->assertChains($field);
    }

    public function testShareLimit()
    {
        $field = 'shareLimit';
        $this->assertValid($field, [ 1, 1000, 15233.33, '12345', 123456789.01 ]);
        $this->assertInvalid($field, [ null, '', 0, -1, new \DateTime(), true, false, [], 'one fifty', 1234567890.12 ]);
        $this->assertChanged($field, 1332, "attributes");
        $this->assertChains($field);
    }

    public function testSpendLimit()
    {
        $field = 'spendLimit';
        $this->assertValid($field, [ 1000, 52333, 123456789, '12345', 12345.78 ]);
        $this->assertInvalid($field, [ null, '', 0, -1, new \DateTime(), true, false, [], 'one fifty', 1234567890 ]);
        $this->assertChanged($field, 5533, "attributes");
        $this->assertChains($field);
    }

    public function testMinSharesThreshold()
    {
        $field = 'minSharesThreshold';
        $this->assertValid($field, [ null, '', 0, 12345, 4294967295 ]);
        $this->assertInvalid($field, [ 4294967296, 1323.50, -1, 'one fifty', true, false, [], new \DateTime() ]);
        $this->assertChanged($field, 1122, "attributes");
        $this->assertChains($field);
    }

    public function testOpenDate()
    {
        $field = 'openDate';
        $this->assertValid($field, [ 1234567890, -12345566828, '12345', new \DateTime() ], function($expected, $actual) {
            if (is_numeric($expected)) {
                $exp = new \DateTime("@".$expected);
            } else {
                $exp = $expected;
            }
            $this->assertInstanceOf('\\DateTime', $actual);
            $this->assertEquals( $exp->format('YmdHis'), $actual->format('YmdHis')
            );
        });
        $this->assertInvalid($field, [ null, '', 0, false, true, 'the thirteenth' ]);
        $this->assertChanged($field, 55522233, "attributes", function($expected, $actual) use ($field) {
            if (is_numeric($expected)) {
                $exp = new \DateTime("@".$expected);
            } else {
                $exp = $expected;
            }
            $this->assertTrue(is_string($actual), "`$field` should have returned a string on serialize.");
            $this->assertEquals($exp->format('Y-m-d H:i:s'), $actual);
        });
        $this->assertChains($field, 332233322);
        $this->assertSerializesDateForSql($field);
    }

    public function testCloseDate()
    {
        $field = 'closeDate';
        $this->assertValid($field, [ 1234567890, -12345566828, '12345', new \DateTime() ], function($expected, $actual) {
            if (is_numeric($expected)) {
                $exp = new \DateTime("@".$expected);
            } else {
                $exp = $expected;
            }
            $this->assertInstanceOf('\\DateTime', $actual);
            $this->assertEquals($exp->format('YmdHis'), $actual->format('YmdHis'));
        });
        $this->assertInvalid($field, [ null, '', 0, false, true, 'the thirteenth' ]);
        $this->assertChanged($field, 55522233, "attributes", function($expected, $actual) use ($field) {
            if (is_numeric($expected)) {
                $exp = new \DateTime("@".$expected);
            } else {
                $exp = $expected;
            }
            $this->assertTrue(is_string($actual), "`$field` should have returned a string on serialize.");
            $this->assertEquals($exp->format('Y-m-d H:i:s'), $actual);
        });
        $this->assertChains($field, 332233322);
        $this->assertSerializesDateForSql($field);
    }

    public function testStatus()
    {
        $field = 'status';
        $this->assertReadOnly($field);
    }

    public function testAnnouncementDoc()
    {
        $field = 'announcementDoc';
        $this->assertValid($field, [ null, new Document($this->datasource) ]);
        $this->assertChanged($field, new Document($this->datasource, ['id' => '12345']), "relationships");
        $this->assertChains($field);
    }

    public function testAgreementTemplates()
    {
        $field = 'agreementTemplates';
        $this->assertValid($field, [ null, new DocumentTemplate($this->datasource) ]);
        $this->assertChanged($field, new DocumentTemplate($this->datasource, ['id' => '12345']), "relationships");
        $this->assertChains($field);
    }

    public function testTenderRoom()
    {
        $field = 'tenderRoom';
        $this->assertValid($field, [ new TenderRoom($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, new TenderRoom($this->datasource, ['id' => '12345']), "relationships");
        $this->assertChains($field);
    }

    public function testAsset()
    {
        $field = 'asset';
        $this->assertValid($field, [ new \CFX\Exchange\Asset($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, new \CFX\Exchange\Asset($this->datasource, ['id'=>'12345']), "relationships");
        $this->assertChains($field);
    }

    public function testPurchaser()
    {
        $field = 'purchaser';
        $this->assertValid($field, [ new LegalEntity($this->datasource) ]);
        $this->assertInvalid($field, [ null ]);
        $this->assertChanged($field, new LegalEntity($this->datasource, ['id'=>'12345']), "relationships");
        $this->assertChains($field);
    }




    public function assertSerializesDateForSql($field)
    {
        $set = "set".ucfirst($field);
        $date = new \DateTime();
        $this->resource->$set($date);
        $changes = $this->resource->getChanges();
        $this->assertContains('attributes', array_keys($changes));
        $this->assertContains($field, array_keys($changes['attributes']));
        $this->assertEquals($date->format("Y-m-d H:i:s"), $changes['attributes'][$field]);
    }
}


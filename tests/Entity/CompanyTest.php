<?php

namespace App\Tests\Entity;

use App\Entity\Company;
use PHPUnit\Framework\TestCase;

class CompanyTest extends TestCase
{
    public function testGetSetName()
    {
        $company = new Company();
        $company->setName('company 1');

        // assert that your calculator added the numbers correctly!
        $this->assertEquals('company 1', $company->getName());
    }
}
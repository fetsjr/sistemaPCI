<?php namespace Tests\PCI\Models\User\Employee\Address;

use PCI\Models\Address;
use PCI\Models\Parish;
use PCI\Models\Employee;
use Tests\AbstractTestCase;

class AddressRelationsTest extends AbstractTestCase
{

    public function testParish()
    {
        $this->mockBasicModelRelation(
            Address::class,
            'parish',
            'belongsTo',
            Parish::class
        );
    }

    public function testUserDetails()
    {
        $this->mockBasicModelRelation(
            Address::class,
            'employee',
            'hasMany',
            Employee::class
        );
    }
}

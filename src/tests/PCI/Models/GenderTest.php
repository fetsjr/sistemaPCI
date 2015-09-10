<?php namespace Tests\PCI\Models;

use Mockery;
use PCI\Models\Gender;
use PCI\Models\Employee;
use Tests\BaseTestCase;

class GenderTest extends BaseTestCase
{

    public function testUserDetails()
    {
        $this->mockBasicModelRelation(
            Gender::class,
            'employee',
            'hasMany',
            Employee::class
        );
    }
}

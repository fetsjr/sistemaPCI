<?php namespace Tests\PCI\Models;

use PCI\Models\Attendant;
use PCI\Models\Note;
use PCI\Models\User;
use Tests\BaseTestCase;

class AttendantTest extends BaseTestCase
{

    public function testUser()
    {
        $this->mockBasicModelRelation(
            Attendant::class,
            'user',
            'belongsTo',
            User::class
        );
    }

    public function testNotes()
    {
        $this->mockBasicModelRelation(
            Attendant::class,
            'notes',
            'hasMany',
            Note::class
        );
    }
}

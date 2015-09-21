<?php namespace Tests\PCI\Repositories;

use Mockery;
use PCI\Models\User;
use Tests\AbstractTestCase;
use PCI\Models\AbstractBaseModel;
use PCI\Repositories\UserRepository as ConcreteClass;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AbstractRepositoryTest extends AbstractTestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @var User
     */
    private $user;

    /**
     * @var ConcreteClass
     */
    private $repo;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->user = factory(User::class)->create();
        $this->repo = new ConcreteClass($this->user);
    }

    public function testConstructShouldInitTheModel()
    {
        $model = Mockery::mock(AbstractBaseModel::class);

        $repo = new ConcreteClass($model);

        $this->assertSame(
            $model,
            $this->readAttribute($repo, 'model')
        );
    }

    public function testGetByNameOrIdShouldReturnModel()
    {
        $results = $this->repo->getByNameOrId($this->user->name);

        $this->assertInstanceOf(User::class, $results);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByNameOrIdShouldThrowExceptionWithNoValidName()
    {
        $this->repo->getByNameOrId('JOHNCENA');
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function testGetByIdThrowExceptionWithNoValidInput()
    {
        $this->repo->getById(null);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     * @expectedExceptionMessage No se pudo eliminar al Usuario, error inesperado.
     */
    public function testDeleteShouldThrowExceptionWhenOnlyAdmin()
    {
        $this->repo->delete(1);
    }
}

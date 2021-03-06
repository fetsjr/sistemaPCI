<?php namespace Tests\Integration\Aux;

use PCI\Models\MovementType;
use PCI\Models\NoteType;
use PCI\Models\PetitionType;

/**
 * Class NoteAndPetitionTypeIntegrationTest
 * Nota: se extiende AuxIntegrationTest para que
 * se ejecuten las pruebas heredadas.
 *
 * @package Tests\Integration\Aux
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteAndPetitionTypeIntegrationTest extends AuxIntegrationTest
{

    /**
     * @var \PCI\Models\MovementType
     */
    private $movementType;

    public function setUp()
    {
        parent::setUp();

        $this->movementType = factory(MovementType::class)->create();
    }

    /**
     * como estas entidades son tan genericas, solo se necesita
     * saber el nombre en la ruta , el alias y la clase para
     * crear nuevos registros y objetos en las vistas
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            'test_notes'     => [
                'tipos-nota',
                'noteTypes',
                NoteType::class,
            ],
            'test_petitions' => [
                'tipos-pedido',
                'petitionTypes',
                PetitionType::class,
            ],
        ];
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testAuxIndexShouldHaveTableWithValidInfo(
        $route,
        $alias,
        $class
    ) {
        $this->actingAs($this->user)
            ->visit(route("$alias.index"))
            ->seePageIs("/$route")
            ->see('No hay información que mostrar.');

        $model = factory($class)->create(['movement_type_id' => $this->movementType->id]);

        $this->actingAs($this->user)
            ->visit(route("$alias.index"))
            ->see($model->desc);
    }

    /**
     * @param $route
     * @param $alias
     * @dataProvider dataProvider
     */
    public function testCreatingAuxShouldReturnAShowView($route, $alias)
    {
        $this->actingAs($this->user)
            ->visit("{$route}/crear")
            ->type($this->movementType->id, 'movement_type_id')
            ->select('testing', 'desc')
            ->press(trans("models.{$alias}.create"))
            ->seePageIs("{$route}/testing");
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testEditAuxShouldReturnAForm($route, $alias, $class)
    {
        $model = factory($class)->create([
            'desc'             => 'testing',
            'movement_type_id' => $this->movementType->id,
        ]);

        $this->actingAs($this->user)
            ->visit("{$route}/{$model->desc}")
            ->click('Editar')
            ->seePageIs("{$route}/{$model->id}/editar")
            ->see(trans("models.$alias.edit"));
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testEditingAuxShouldReturnAShowView($route, $alias, $class)
    {
        $model = factory($class)->create([
            'desc'             => 'another',
            'movement_type_id' => $this->movementType->id,
        ]);

        $this->actingAs($this->user)
            ->visit("{$route}/{$model->id}/editar")
            ->type('check', 'desc')
            ->press(trans("models.$alias.edit"))
            ->seePageIs("{$route}/check");
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testEditAuxShouldDeleteWithWarning($route, $alias, $class)
    {
        unset($alias);
        $model = factory($class)->create([
            'desc'             => 'testing',
            'movement_type_id' => $this->movementType->id,
        ]);

        $this->actingAs($this->user)
            ->visit("{$route}/{$model->desc}")
            ->press('Eliminar')
            ->seePageIs("/{$route}");
    }
}

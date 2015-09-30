<?php namespace PCI\Http\Controllers\Item;

use Illuminate\Http\Request;
use Illuminate\View\Factory as View;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
use PCI\Http\Requests\Item\ItemRequest;
use PCI\Models\ItemType;
use PCI\Models\Maker;
use PCI\Repositories\Interfaces\Item\ItemRepositoryInterface;
use Redirect;

/**
 * Class ItemsController
 * @package PCI\Http\Controllers\Item
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemsController extends Controller
{

    /**
     * La implementacion del repositorio de items.
     * @var \PCI\Repositories\Interfaces\Item\ItemRepositoryInterface
     */
    private $repo;

    /**
     * La vista.
     * @var \Illuminate\View\Factory
     */
    private $view;

    /**
     * Genera la instancia de este controlador.
     * @param \PCI\Repositories\Interfaces\Item\ItemRepositoryInterface $repo
     * @param \Illuminate\View\Factory $view
     */
    public function __construct(ItemRepositoryInterface $repo, View $view)
    {
        $this->repo = $repo;
        $this->view = $view;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view
            ->make('items.index')
            ->with('items', $this->repo->getIndexViewVariables());
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = $this->repo->newInstance();

        // TODO: repositorio de este asunto
        $subCats = $this->repo->getSubCatsLists();
        $makers    = Maker::lists('desc', 'id');
        $itemTypes = ItemType::lists('desc', 'id');

        return $this->view->make(
            'items.create',
            compact('item', 'subCats', 'makers', 'itemTypes')
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param \PCI\Http\Requests\Item\ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $item = $this->repo->create($request->all());

        return Redirect::route('items.show', $item->id);
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->repo->find($id);

        return $this->view->make('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

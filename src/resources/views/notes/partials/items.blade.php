@unless($note->items->isEmpty())
    <?php

    $array = [];

    /** @var \PCI\Models\Item $item */
    foreach ($note->items as $item) {
        // super mamarracho.
        $number   = $item->pivot->quantity;
        $id       = $item->pivot->stock_type_id;
        $type     = \PCI\Models\StockType::findOrFail($id, ['desc'])->desc;
        $quantity = $item->formattedQuantity($number, $type);
        $array[]  = [
            'uid'         => $item->id,
            'Descripción' => $item->desc,
            'Cantidad'    => $quantity,
            'Fecha Vto.'  => $item->pivot->due ? $item->pivot->due : '-',
            'Existencia'  => $item->formattedRealStock(),
            'Reservado'   => $item->formattedReserved(),
            'Ajustado'    => $item->formattedStock(),
        ];
    }

    if (isset($title)) {
        $title = trans('models.items.plural')
            . ' registrados en el '
            . trans('models.notes.singular');
    } else {
        $title = null;
    }

    ?>

    <hr/>

    @include('partials.tables.withArray', [
        'data' => $array,
        'title' => $title,
        'resource' => 'items',
    ])
@endunless

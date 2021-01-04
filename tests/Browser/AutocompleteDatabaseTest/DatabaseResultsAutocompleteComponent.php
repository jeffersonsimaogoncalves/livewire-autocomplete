<?php

namespace LivewireAutocomplete\Tests\Browser\AutocompleteDatabaseTest;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LivewireAutocomplete\Tests\Browser\AutocompleteDatabaseTest\Models\Item;

class DatabaseResultsAutocompleteComponent extends Component
{
    public $items;

    public $itemName = '';

    public $selectedItem;

    public $rules = [
        'items.*.id' => '',
        'selectedItem' => ''
    ];

    public function mount()
    {
        $this->getItems();
    }

    public function getItems()
    {
        $this->items = Item::query()
            ->when($this->itemName, function ($query, $itemName) {
                return $query->where('name', 'LIKE', "%{$itemName}%");
            })
            ->get()
            ;
    }

    public function updatedItemName()
    {
        $this->reset('items');
        $this->getItems();
    }

    public function updatedSelectedItem($selected)
    {
        $this->selectedItem = Item::find($selected['id'] ?? null);
        $this->itemName = $this->selectedItem->name ?? null;
    }

    public function render()
    {
        return <<<'HTML'
            <div dusk="page">
                <x-lwc::autocomplete
                    wire:input-property="itemName"
                    wire:selected-property="selectedItem"
                    wire:results-property="items"
                    result-component="item-row"
                    />

                <div dusk="result-output">@if($selectedItem)ID:{{ $selectedItem->id }} - Name:{{ $selectedItem->name }}@endif</div>
            </div>
            HTML;
    }
}

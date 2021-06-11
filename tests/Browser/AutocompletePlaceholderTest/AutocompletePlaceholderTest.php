<?php

namespace LivewireAutocomplete\Tests\Browser\AutocompletePlaceholderTest;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use LivewireAutocomplete\Tests\Browser\TestCase;

class AutocompletePlaceholderTest extends TestCase
{
    /** @test */
    public function placeholder_text_is_shown_on_focus()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AutocompleteWithPlaceholderComponent::class)
                ->click('@autocomplete-input')
                // Pause to allow transitions to run
                ->pause(101)
                ->assertVisible('@autocomplete-dropdown')
                ->assertSeeIn('@autocomplete-dropdown', 'Start typing to search')
                ;
        });
    }

    /** @test */
    public function no_results_text_is_shown_if_nothing_found()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AutocompleteWithPlaceholderComponent::class)
                ->click('@autocomplete-input')
                // Pause to allow transitions to run
                ->pause(101)
                ->assertVisible('@autocomplete-dropdown')
                ->type('@autocomplete-input', 'a')
                ->assertSeeIn('@autocomplete-dropdown', 'There were no results found')
                ;
        });
    }
}

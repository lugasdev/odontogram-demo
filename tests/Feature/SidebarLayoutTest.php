<?php

test('guest users can render the sidebar layout', function () {
    $view = $this->blade('<x-layouts::app.sidebar>Content</x-layouts::app.sidebar>');

    $view->assertSee('Content');
});

test('guest users can render the desktop user menu', function () {
    $view = $this->blade('<x-desktop-user-menu />');

    $view->assertDontSee('sidebar-menu-button');
});

test('tooth chart renders condition and eruption markers', function () {
    $view = $this->blade('<x-tooth-chart :tooth="14" erupsi="mis" :extra="[\'rct\']" :conditions="[\'m\' => [\'car\' => true]]" />');

    $view->assertSee('stroke-width="5"', false)
        ->assertSee('30,110 50,135 70,110', false);
});

test('second tooth chart sends the clicked surface to Livewire', function () {
    $view = $this->blade('<x-tooth-chart-two tooth="14" erupsi="sou" />');

    $view->assertSee('tooth-surface', false)
        ->assertSee('pointer-events="all"', false)
        ->assertSee("\$wire.updateSurface('14', surface)", false);
});

test('second odontogram page renders selectable surface conditions', function () {
    $this->get('/gigi2')
        ->assertOk()
        ->assertSee('Kondisi Permukaan')
        ->assertSee('Karies');
});

test('odontogram simulation renders the full chart and selected tooth editor', function () {
    $this->get('/gigi')
        ->assertOk()
        ->assertSee('Permanen')
        ->assertSee('Status Erupsi');
});

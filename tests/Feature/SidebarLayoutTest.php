<?php

test('guest users can render the sidebar layout', function () {
    $view = $this->blade('<x-layouts::app.sidebar>Content</x-layouts::app.sidebar>');

    $view->assertSee('Content');
});

test('guest users can render the desktop user menu', function () {
    $view = $this->blade('<x-desktop-user-menu />');

    $view->assertDontSee('sidebar-menu-button');
});

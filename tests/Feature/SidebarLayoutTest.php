<?php

test('guest users can render the sidebar layout', function () {
    $view = $this->blade('<x-layouts::app.sidebar>Content</x-layouts::app.sidebar>');

    $view->assertSee('Content');
});

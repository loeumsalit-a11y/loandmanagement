<?php

it('returns a redirect response for unauthenticated users', function () {
    $response = $this->get('/');

    $response->assertStatus(302);
});

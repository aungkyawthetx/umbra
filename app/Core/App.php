<?php
require_once __DIR__ . '/../Helpers/auth.php';

class App
{
    public function run()
    {
        require_once __DIR__ . '/Router.php';
        require_once __DIR__ . '/Database.php';

        $router = new Router();

        require_once __DIR__ . '/../../routes/web.php';

        $router->dispatch();
    }
}

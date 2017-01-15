<?php

return array_merge(
    require __DIR__.'/prod.php',
    [
        'debug' => true,
        'db.options' => [
            'driver' => 'pdo_sqlite',
            'path'   => __DIR__.'/../../var/cache/test.db'
        ]
    ]
);

<?php
return [
    'cloudinary:copy' => [
        'class' => \Visol\Cloudinary\Command\CloudinaryCopyCommand::class,
    ],
    'cloudinary:move' => [
        'class' => \Visol\Cloudinary\Command\CloudinaryMoveCommand::class,
    ],
];

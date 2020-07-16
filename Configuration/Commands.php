<?php
return [
    'cloudinary:copy' => [
        'class' => \Visol\Cloudinary\Command\CloudinaryCopyCommand::class,
    ],
    'cloudinary:move' => [
        'class' => \Visol\Cloudinary\Command\CloudinaryMoveCommand::class,
    ],
    'cloudinary:tests' => [
        'class' => \Visol\Cloudinary\Command\CloudinaryAcceptanceTestCommand::class,
    ],
    'cloudinary:fix' => [
        'class' => \Visol\Cloudinary\Command\CloudinaryFixJpegCommand::class,
    ],
    'cloudinary:scan' => [
        'class' => \Visol\Cloudinary\Command\CloudinaryScanCommand::class,
    ],
    'cloudinary:query' => [
        'class' => \Visol\Cloudinary\Command\CloudinaryQueryCommand::class,
    ],
];

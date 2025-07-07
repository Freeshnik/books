<?php

namespace Main\Controllers;

use App\Controller\MainController;
use Main\Controllers\Actions\Book\BookCreate;
use Main\Controllers\Actions\Book\BookDelete;
use Main\Controllers\Actions\Book\BookIndex;
use Main\Controllers\Actions\Book\BookUpdate;
use Main\Controllers\Actions\Book\BookView;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends MainController
{
    public const ROUTE_INDEX = 'index';
    public const ROUTE_CREATE = 'create';
    public const ROUTE_VIEW = 'view';
    public const ROUTE_UPDATE = 'update';
    public const ROUTE_DELETE = 'delete';

    public function actions(): array
    {
        return [
            self::ROUTE_INDEX => BookIndex::class,
            self::ROUTE_CREATE => BookCreate::class,
            self::ROUTE_UPDATE => BookUpdate::class,
            self::ROUTE_VIEW => BookView::class,
            self::ROUTE_DELETE => BookDelete::class,
        ];
    }
}

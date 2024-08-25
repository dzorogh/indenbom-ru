<?php

namespace Dzorogh\Family\Rest\Controllers;


use Dzorogh\Family\Rest\Controller as RestController;
use Dzorogh\Family\Rest\Resources\FamilyCoupleResource;
use Lomkit\Rest\Http\Resource;

class FamilyCoupleController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<Resource>
     */
    public static $resource = FamilyCoupleResource::class;
}

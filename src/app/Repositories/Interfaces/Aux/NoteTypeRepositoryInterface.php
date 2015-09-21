<?php namespace PCI\Repositories\Interfaces\Aux;

use PCI\Repositories\Interfaces\GetBySlugOrIdInterface;
use PCI\Repositories\Interfaces\ModelRepositoryInterface;
use PCI\Repositories\Interfaces\Viewable\ViewableInterface;

interface NoteTypeRepositoryInterface extends ModelRepositoryInterface, ViewableInterface, GetBySlugOrIdInterface
{

}

<?php

namespace App\Controller\Admin;

use App\Entity\Tache;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TacheCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tache::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle')
        ];
    }

}

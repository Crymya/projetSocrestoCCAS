<?php

namespace App\Controller\Admin;

use App\Entity\TachePrevue;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TachePrevueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TachePrevue::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            yield AssociationField::new('tache'),
            yield AssociationField::new('zone'),
            yield AssociationField::new('periode')
        ];
    }

}

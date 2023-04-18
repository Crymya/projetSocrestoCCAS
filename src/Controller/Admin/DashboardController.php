<?php

namespace App\Controller\Admin;

use App\Entity\Editeur;
use App\Entity\Materiel;
use App\Entity\Tache;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {

    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(EditeurCrudController::class)->generateUrl();
        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SocrestoCCAS');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour sur le site SOCRESTO', 'fa fa-home', 'main_home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Editeur', 'fas fa-list');
        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter un éditeur', 'fas fa-plus-circle', Editeur::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::linkToCrud('Matériel', 'fas fa-list', Materiel::class);

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
           MenuItem::linkToCrud('Ajouter un matériel', 'fas fa-plus-circle', Materiel::class)->setAction(Crud::PAGE_NEW),
           MenuItem::linkToCrud('Supprimer un matériel', 'fas fa-times', Materiel::class)
        ]);

        yield MenuItem::linkToCrud('Tâche', 'fas fa-list', Tache::class);

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter une tâche', 'fas fa-plus-circle', Tache::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Supprimer une tâche', 'fas fa-times', Tache::class)
        ]);
    }
}

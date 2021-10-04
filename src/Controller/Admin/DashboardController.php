<?php

namespace App\Controller\Admin;

use App\Entity\Anime;
use App\Entity\Categories;
use App\Entity\Screenshot;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Online Movie');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Главная', 'fa fa-home');
        yield MenuItem::linkToCrud('Сериалы', 'fa fa-film', Anime::class);
        yield MenuItem::linkToCrud('Категории', 'fa fa-book', Categories::class);
        yield MenuItem::linkToCrud('Кадры из сериалов', 'fa fa-picture-o', Screenshot::class);
    }
}

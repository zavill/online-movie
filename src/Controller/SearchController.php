<?php


namespace App\Controller;


use App\Service\ElasticSearch\Indexer\AnimeIndexer;
use Elasticsearch\ClientBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/")
     * @param RequestStack $requestStack
     * @param LoggerInterface $logger
     */
    public function search(RequestStack $requestStack, LoggerInterface $logger)
    {
        $client = (new ClientBuilder())->build();
        $searchQuery = $requestStack->getCurrentRequest()->get('name');
        $animeIndexer = new AnimeIndexer($client, $logger);

        dd($animeIndexer->search(['name' => $searchQuery]));

        return $this->render('home.html.twig');
    }

}
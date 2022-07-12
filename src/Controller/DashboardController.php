<?php

namespace App\Controller;

use App\Repository\InventoryRepository;
use App\Repository\BrickItemRepository;
use App\Service\BrickLink;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(InventoryRepository $inventoryRepository, BrickItemRepository $itemsRepository): Response
    {
        $items = $itemsRepository->findAll(); // less queries
        $inventories = $inventoryRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'inventories' => $inventories,
            'total_inventories' => count($inventories),
        ]);
    }

    // #[Route('/testApi', name: 'app_dashboard_testapi')]
    // public function testApi(BrickLink $bl, InventoryRepository $inventoryRepository): Response
    // {
    //     $encoder = new JsonEncoder();
    //     $defaultContext = [
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
    //             return $object->getInventoryId();
    //         },
    //     ];
    //     $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

    //     $serializer = new Serializer([$normalizer], [$encoder]);

    //     $inv = $inventoryRepository->findOneBy(['inventoryId'=>'284005190']);

    //     $json_content = $serializer->serialize($inv, 'json');
    //     return $this->render('dashboard/testapi.html.twig', [
    //         'controller_name' => 'DashboardController',
    //         'githubapi' => $json_content
    //     ]);
    // }

}

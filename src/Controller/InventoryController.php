<?php

namespace App\Controller;

use App\Entity\Inventory;
use App\Htpp\HttpHandle;
use App\Repository\InventoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[Route('/inventory')]
class InventoryController extends AbstractController
{

	#[Route('/', name: 'app_inventory')]
    public function index(){
        return $this->render('inventory/index.html.twig', [
            'controller_name' => 'InventoryController',
        ]);
    }

    #[Route('/new', name: 'app_inventory_new')]
    public function new(InventoryRepository $inventoryRepository): Response
    {
		//For test purposes
        $json = '{
			"inventory_id": 294632795,
			"item": {
				"no": "2357",
				"name": "Brick 2 x 2 Corner",
				"type": "PART",
				"category_id": 5
			},
			"color_id": 5,
			"color_name": "Red",
			"quantity": 4,
			"new_or_used": "N",
			"unit_price": "0.6300",
			"bind_id": 0,
			"description": "",
			"remarks": "0590",
			"bulk": 1,
			"is_retain": false,
			"is_stock_room": false,
			"date_created": "2022-04-28T04:00:00.000Z",
			"my_cost": "0.0000",
			"sale_rate": 25,
			"tier_quantity1": 0,
			"tier_price1": "0.0000",
			"tier_quantity2": 0,
			"tier_price2": "0.0000",
			"tier_quantity3": 0,
			"tier_price3": "0.0000",
			"my_weight": "0.0000"
		}';

        $inventory = new Inventory($json);

        $inventoryRepository->add($inventory, true);

        return new Response('Saved new inventory with id '.$inventory->getId());
    }

	#[Route('/show/{id}', name: 'app_inventory_show')]
    public function show(InventoryRepository $inventoryRepository, int $id){

		$inventory = $inventoryRepository->find($id);

        return $this->render('inventory/show.html.twig', [
            'controller_name' => 'InventoryController',
            'inventory' => $inventory,
			'menu' => ''
        ]);
    }


	#[Route('/pull', name: 'app_inventory_pull')]
    public function pull(){

		$httpHandle = new HttpHandle(HttpClient::create());

        return $this->render('inventory/pull.html.twig', [
            'controller_name' => 'InventoryController',
            'response' => $httpHandle->fetchBrickLinkInventory(),
			'menu' => ''
        ]);
    }
}

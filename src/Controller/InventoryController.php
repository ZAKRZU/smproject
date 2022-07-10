<?php

namespace App\Controller;

use App\Entity\Inventory;
use App\Entity\BrickItem;
use App\Htpp\HttpHandle;
use App\Repository\InventoryRepository;
use App\Repository\BrickItemRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/inventory')]
class InventoryController extends AbstractController
{

	#[Route('/', name: 'app_inventory')]
    public function index(): Response 
	{
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
    public function show(InventoryRepository $inventoryRepository, int $id): Response
	{

		$inventory = $inventoryRepository->find($id);

        return $this->render('inventory/show.html.twig', [
            'controller_name' => 'InventoryController',
            'inventory' => $inventory,
        ]);
    }
	

	#[Route('/pull', name: 'app_inventory_pull')]
    public function pull(InventoryRepository $inventoryRepository, BrickItemRepository $itemRepository): Response 
	{

		// setup api request
		$httpHandle = new HttpHandle(HttpClient::create());

		// fetch items
		$response = $httpHandle->fetchBrickLinkInventory();

		// decode json respone to php array
		$response_json = json_decode($response, true);

		// for counting updated records
		$updated_items = 0;
		$updated_invs = 0;

		// processing all inventories from request
		foreach ($response_json['data'] as $key => $value) {
			// check if item exist in database
			$find_item = $itemRepository->findOneBy(['no' => $value['item']['no']]);
			if (!$find_item)
			{
				// if not create
				$item = new BrickItem();
				$item->setNo($value['item']['no']);
				$item->setName($value['item']['name']);
				$item->setType($value['item']['type']);
				$item->setCategoryId($value['item']['category_id']);

				$itemRepository->add($item, true);
				$updated_items++;
			} else {
				// if exist ignore
				$item = $find_item;
			}

			// check if inventory with that id already exist
			$find_inventory = $inventoryRepository->findOneBy(['inventoryId' => $value['inventory_id']]);
			$inventory = new Inventory();
			$inventory->setInventoryId($value['inventory_id']);
			$inventory->setItem($item);
			if (strcmp($item->getType(), 'SET') == 0) {
				$inventory->setCompleteness('completeness');
			}
			$inventory->setColorId($value['color_id']);
			$inventory->setColorName($value['color_name']);
			$inventory->setQuantity($value['quantity']);
			$inventory->setNewOrUsed($value['new_or_used']);
			$inventory->setUnitPrice($value['unit_price']);
			$inventory->setBindId($value['bind_id']);
			$inventory->setDescription($value['description']);
			$inventory->setRemarks($value['remarks']);
			$inventory->setBulk($value['bulk']);
			$inventory->setIsRetain($value['is_retain']);
			$inventory->setIsStockRoom($value['is_stock_room']);
			$inventory->setDateCreated(new \DateTime($value['date_created']));
			$inventory->setMyCost($value['my_cost']);
			$inventory->setSaleRate($value['sale_rate']);
			$inventory->setTierQuantity1($value['tier_quantity1']);
			$inventory->setTierPrice1($value['tier_price1']);
			$inventory->setTierQuantity2($value['tier_quantity2']);
			$inventory->setTierPrice2($value['tier_price2']);
			$inventory->setTierQuantity3($value['tier_quantity3']);
			$inventory->setTierPrice3($value['tier_price3']);
			$inventory->setMyWeight($value['my_weight']);
			if(!$find_inventory)
			{
				// if not create

				$inventoryRepository->add($inventory, true);
				$updated_invs++;
			} else {
				// otherwise assign
				if ($find_inventory->update($inventory))
				{
					// it will update inventory
					$inventoryRepository->add($find_inventory, true);
					$updated_invs++;
				}
				// $inventory = $find_inventory;
			}
		}

        return $this->render('inventory/pull.html.twig', [
            'controller_name' => 'InventoryController',
            // 'response' => $inventoryRepository->findAll(),
			'updated_items' => $updated_items,
			'updated_invs' => $updated_invs,
        ]);
    }
}

<?php
declare(strict_types=1);

namespace Practice\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Faker\Factory;
use Practice\Entity\Buyer;
use Practice\Entity\Vehicle;

class CsvParseService
{
    /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function parseCsvFromUrlToArray(string $sourceUrl): array
    {
        // todo: input data validation

        $header = [];
        $dataRows = [];
        $niceArray = [];

        ini_set('auto_detect_line_endings', '1');
        if (($handle = fopen($sourceUrl, 'r')) !== false) {
            $isFirstRow = true;
            $rowNumber = 0;
            while (($row = fgetcsv($handle, 1024, ',')) !== false) {
                if ($isFirstRow) {
                    $header = $row;
                    $isFirstRow = false;
                    continue;
                } else {
                    foreach ($row as $key => $value) {
                        $dataRows[$rowNumber][$header[$key]] = str_replace('<br>', '', $value);
                    }
                    ++$rowNumber;
                }
            }
            fclose($handle);

            $niceArray = [
                'HeadRows' => $header,
                'DataRows' => $dataRows,
            ];
        }

        return $niceArray;
    }

    /**
     * @param string $csvUrl
     * @throws OptimisticLockException
     */
    public function importCsvFromUrlToDb(string $csvUrl)
    {
        $niceArray = $this->parseCsvFromUrlToArray($csvUrl);
        $this->importToDb($niceArray);
    }

    /**
     * @param array $niceArray
     * @throws OptimisticLockException
     */
    private function importToDb(array $niceArray)
    {
        $dataRows = $niceArray['DataRows'];

        foreach ($dataRows as $dataRow) {
            $this->insertBuyerIfNotExist((int)$dataRow['BuyerID']);

            $vehicle = new Vehicle();
            $vehicle->setVehicleID((int)$dataRow['VehicleID']);
            $vehicle->setInhouseSellerID((int)$dataRow['InhouseSellerID']);
            $vehicle->setBuyerID((int)$dataRow['BuyerID']);
            $vehicle->setModelID((int)$dataRow['ModelID']);
            $vehicle->setSaleDate($dataRow['SaleDate']);
            $vehicle->setBuyDate($dataRow['BuyDate']);

            $this->entityManager->persist($vehicle);
        }

        $this->entityManager->flush();
    }

    /**
     * @param int $buyerID
     * @throws OptimisticLockException
     */
    private function insertBuyerIfNotExist(int $buyerID)
    {
        /** @var \Practice\Repository\BuyerRepository $buyerRepository */
        $buyerRepository = $this->entityManager->getRepository(Buyer::class);
        $buyer = $buyerRepository->findBuyerByID($buyerID);

        if (empty($buyer)) {
            $b = new Buyer();
            $b->setBuyerID($buyerID);

            $this->entityManager->persist($b);
            $this->entityManager->flush();
        }
    }

    public function fakeBuyerNames()
    {
        /** @var \Practice\Repository\BuyerRepository $buyerRepository */
        $buyerRepository = $this->entityManager->getRepository(Buyer::class);
        $buyers= $buyerRepository->getAll();

        $faker = Factory::create();

        foreach ($buyers as $buyer) {
            /** @var \Practice\Entity\Buyer $buyer */
            $buyer->setFirstName($faker->firstName);
            $buyer->setLastName($faker->lastName);

            $this->entityManager->persist($buyer);
        }

        try {
            $this->entityManager->flush();
        } catch (OptimisticLockException $e) {
        }
    }
}
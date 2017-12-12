<?php
declare(strict_types=1);

namespace Practice\Controller;

use Doctrine\ORM\EntityManager;
use Practice\Service\CsvParseService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
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

    public function indexAction()
    {
        ini_set('display_errors', '1');
    }

    public function step1Action()
    {
    }

    public function parseAction()
    {
        $returnData = [];
        $data = $this->params()->fromPost();

        if (!empty($data)) {
            if (array_key_exists('csvUrl', $data)) {
                $csvUrl = $data['csvUrl'];
                $csvParseService = new CsvParseService($this->entityManager);
                $returnData = $csvParseService->parseCsvFromUrlToArray($csvUrl);
            }
        }

        return new JsonModel($returnData);
    }

    /**
     * @return JsonModel
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function importDbAction()
    {
        $data = $this->params()->fromPost();

        if (!empty($data)) {
            if (array_key_exists('csvUrl', $data)) {
                $csvUrl = $data['csvUrl'];
                $csvParseService = new CsvParseService($this->entityManager);
                $csvParseService->importCsvFromUrlToDb($csvUrl);
            }
        }

        return new JsonModel(['Status' => 'Success']);
    }

    public function fakeBuyerNamesAction()
    {
        $csvParseService = new CsvParseService($this->entityManager);
        $csvParseService->fakeBuyerNames();
        return new JsonModel(['Status' => 'Success']);
    }

    public function step2Action()
    {
        $pageNumber = 1;
        $pageSize = 10;

        $data = $this->params()->fromPost();

        if (!$data) {
            if (array_key_exists('pageNumber', $data)) {
                $pageNumber = (int)$data['pageNumber'];
            }

            if (array_key_exists('pageSize', $data)) {
                $pageSize = (int)$data['pageSize'];
            }
        }

        $csvParseService = new CsvParseService($this->entityManager);
        $pageRows = $csvParseService->getPage($pageSize, $pageNumber);

        return new ViewModel([
            'pageRows' => $pageRows,
        ]);
    }

    public function step2pageAction()
    {
        $startRecordNumber = 1;
        $pageSize = 10;

        //$data = $this->params()->fromPost();
        $data = $this->params()->fromQuery();

        if (!$data) {
            if (array_key_exists('start', $data)) {
                $startRecordNumber = (int)$data['start'];
            }

            if (array_key_exists('length', $data)) {
                $pageSize = (int)$data['length'];
            }
        }

        $csvParseService = new CsvParseService($this->entityManager);
        $pageRows = $csvParseService->getPage($pageSize, $startRecordNumber);

        $simpleRows = [];
        foreach ($pageRows as $row) {
            /** @var \Practice\Entity\Vehicle $row */
            $simpleRows[] = [
                'VehicleID' => $row->getVehicleID(),
                'InhouseSellerID' => $row->getInhouseSellerID(),
                'BuyerID' => $row->getBuyerID(),
                'ModelID' => $row->getModelID(),
                'SaleDate' => $row->getSaleDate()->format('Y-m-d'),
                'BuyDate' => $row->getBuyDate()->format('Y-m-d'),
            ];
        }

        return new JsonModel([
            'data' => $simpleRows
        ]);
    }
}

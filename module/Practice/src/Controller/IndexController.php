<?php
declare(strict_types=1);

namespace Practice\Controller;

use Practice\Service\CsvParseService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        ini_set('display_errors', '1');
    }

    public function step1Action()
    {
    }

    public function parseAction()
    {
        $data = $this->params()->fromPost();

        if (!empty($data)) {
            if (array_key_exists('csvUrl', $data)) {
                $csvUrl = $data['csvUrl'];
                $csvParseService = new CsvParseService();
                $returnData = $csvParseService->parseCsvFromUrlToArray($csvUrl);
            }
        }

        return new JsonModel($returnData);
    }


}

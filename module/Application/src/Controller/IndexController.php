<?php
declare(strict_types=1);

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private const SAMPLE_DATA_URL = 'https://admin.b2b-carmarket.com//test/project';

    public function indexAction()
    {
        return new ViewModel();
    }

    public function forensicAction()
    {
        $dna = 'HHHKLJ140L98IHYYYN';

        $suspects = [
            [
                'Name' => 'John Novak',
                'DnaData' => [
                    'Hair' => 'Black',
                    'Eyes' => 'Green',
                    'Race' => 'Asian',
                ],
            ],
            [
                'Name' => 'Vin diesel',
                'DnaData' => [
                    'Hair' => 'Blonde',
                    'Eyes' => 'Brown',
                    'Race' => 'Caucasian',
                ],
            ],
            [
                'Name' => 'Guy Fawkes',
                'DnaData' => [
                    'Hair' => 'Black',
                    'Eyes' => 'Brown',
                    'Race' => 'Hispanic',
                ],
            ],
        ];

        $legend = [
            'Eyes' => [
                'Black' => '140L98',
                'Green' => '140A98',
                'Brown' => '140A88',
                'Blue' => '140L97',
            ],
            'Hair' => [
                'Brown' => 'HHHKLJ',
                'Black' => 'HHHKLI',
                'Blonde' => 'HHLH1L',
                'White' => 'HHLH2L',
            ],
            'Race' => [
                'Asian' => '1HYYYN',
                'Hispanic' => 'IHYYYN',
                'White' => 'IHYYNN',
            ],
        ];

        echo $this->getGuilty($dna, $suspects, $legend);
        exit;
    }

    private function getGuilty(string $dna, array $suspects, array $legend): string
    {
        $suspectScore = $this->getSuspectsScores($dna, $suspects, $legend);
        $guilty = $this->getSuspectWithMaxScore($suspectScore);

        return $guilty;
    }

    private function getSuspectsScores(string $dna, array $suspects, array $legend): array
    {
        $suspectScore = [];
        foreach ($suspects as $suspect) {
            $score = $this->getSuspectScore($dna, $suspect, $legend);
            $suspectScore[] = [
                $suspect['Name'] => $score,
            ];
        }

        return $suspectScore;
    }

    private function getSuspectScore(string $dna, array $suspect, array $legend): int
    {
        $suspectScore = 0;
        foreach ($suspect['DnaData'] as $key => $value) {
            $legendValue = $legend[$key][$value];   // e.g. 'HHHKLI' = ['Hair']['Black']
            $idx = strpos($dna, $legendValue);      // search in the Dna
            if ($idx !== false) {
                ++$suspectScore;
            }
        }

        return $suspectScore;
    }

    private function getSuspectWithMaxScore(array $suspectScore): string
    {
        arsort($suspectScore, SORT_NUMERIC);
        //test the following
        reset($suspectScore);
        return key($suspectScore);
    }

    public function parserAction()
    {
        $niceArray = $this->getNiceArray(self::SAMPLE_DATA_URL);

        print_r($niceArray);
        exit;
    }

    /**
     * I've got to move it, move it ... MOVE IT!
     * @param string $sourceUrl
     * @return array
     */
    private function getNiceArray(string $sourceUrl): array
    {
        $header = [];
        $niceArray = [];

        ini_set('auto_detect_line_endings', true);
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
                        $niceArray[$rowNumber][$header[$key]] = str_replace('<br>', '', $value);
                    }
                    ++$rowNumber;
                }
            }

            fclose($handle);
        }

        return $niceArray;
    }

    private function insertVehicles()
    {
        $niceArray = $this->getNiceArray(self::SAMPLE_DATA_URL);

        foreach ($niceArray as $row) {
            //$vehicle = new Vehicle();
            //$vehicle->VehicleID = $row['VehicleID'];
            //...
            //$vehicle->save();
        }
    }


}

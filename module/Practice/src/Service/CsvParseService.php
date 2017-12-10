<?php
declare(strict_types=1);

namespace Practice\Service;

class CsvParseService
{
    public function parseCsvFromUrlToArray(string $sourceUrl): array
    {
        // todo: input data validation

        $header = [];
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
                        $niceArray[$rowNumber][$header[$key]] = str_replace('<br>', '', $value);
                    }
                    ++$rowNumber;
                }
            }
            fclose($handle);
        }

        return $niceArray;
    }
}
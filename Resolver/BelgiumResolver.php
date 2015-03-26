<?php
/**
 * This file is part of the Clastic Modules package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CityBundle\Resolver;

use Clastic\CityBundle\Entity\Country;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class BelgiumResolver extends AbstractResolver
{
    private $tmpFile;
    private $country;
    private $count;

    protected function init()
    {
        $this->tmpFile = tempnam(sys_get_temp_dir(), '');
        $this->country = $this->getCountry('Belgium', 'BE');
        $this->loadData();
    }

    private function loadData()
    {
        $this->download('http://www.bpost2.be/zipcodes/files/zipcodes_num_nl.xls', $this->tmpFile);

        $inputFileType = \PHPExcel_IOFactory::identify($this->tmpFile);
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($this->tmpFile);

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $this->count = $highestRow-1;

        for ($row = 2; $row <= $highestRow; $row++){
            $dataRow = $sheet->rangeToArray('A' . $row . ':' . 'C' . $row, null, true, false);

            $this->data[] = array(
                'zip'      => $dataRow[0][0],
                'name'     => $dataRow[0][1],
                'province' => $dataRow[0][2],
                'country'  => $this->country,
            );
        }
    }

    protected function download($url, $to)
    {
        $fp = fopen($to, 'w+');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

    public function count()
    {
        return $this->count;
    }
}

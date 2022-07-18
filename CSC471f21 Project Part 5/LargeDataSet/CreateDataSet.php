<?php


$filenameVaccine = __DIR__ . "/" . "createVaccineLotsDataset.csv";
// $filenameLots = __DIR__ . "/" . "createLotsDataset.csv";

echo "Tuple dataset creation is in process.";

$vaccineArray = array();
$lotsArray = array();
$vaccineArray[0] = ["scient_name" => "scient_name", "disease" => "disease",  "no_doses" => "no_doses", "scient_name_fk" => "scient_name", "number" => "number",  "mfr_place" => "mfr_place" , "expiration" => "expiration" ];
// $lotsArray[0] = ["scient_name" => $scient_name, "number" => $disease,  "mfr_place" => $no_doses , "expiration" => $expiration  ];

for ($i = 0; $i < 3000; $i++)
{

    $scient_name = "John" . $i;
    if($i >2500)
        $disease = 'Chickenpox';
    else if($i > 2000)
        $disease = 'Covid 1.0';
    else if($i > 1500)
        $disease = 'Covid 2.0';
    else if($i >= 0)
        $disease = 'Maleria';

    $no_doses = $i%2 == 0 ? 10 : 30;
    $scient_name = "Mike" . $i;
    $number = $i . "" . $i . "" . $i;
    $mfr_place = $i%2 == 0 ? 'usa' : 'uk';

    if($i < 1500)
        $expiration = date(DATE_ATOM,mktime(0, 0, 0, 10, 3, 2021));
    else
        $expiration = null;

    $vaccineArray[$i] = ["scient_name" => $scient_name, "disease" => $disease,  "no_doses" => $no_doses, "scient_name_fk" => $scient_name, "number" => $number,  "mfr_place" => $mfr_place , "expiration" => $expiration ];
    // $lotsArray[$i] = [];
}

$fp = fopen($filenameVaccine, 'w');
//Write the header in csv
fputcsv($fp, array_keys($vaccineArray[0]));

//Write fields data in csv for vaccine
foreach ($vaccineArray as $row) {
    //echo json_encode($row);
    fputcsv($fp, $row);
}
fclose($fp);

// $fpLot = fopen($filenameLots, 'w');
// //Write the header in csv
// fputcsv($fp, array_keys($lotsArray[0]));

// //Write fields data in csv for vaccine
// foreach ($lotsArray as $row) {
//     //echo json_encode($row);
//     fputcsv($fpLot, $row);
// }
// fclose($fpLot);

echo "Dataset successfully created for vaccine and lots.";

?>

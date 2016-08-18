<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>ДЗ №2</title>
</head>
  <body>
    <h1>ДЗ №2</h1><hr>

<?php
echo 'Задание №1<br>';
//dfdsfsdsdf
$xml = simplexml_load_file('data.xml');
$attrs = $xml->attributes();
echo 'Oreder number: ', $attrs[0], '<br>', 'Date: ', $attrs[1], '<br><br>';

foreach ($xml->Address as $key) {
    echo '<b>Address type: </b>', $key->attributes (), '<br>';
    echo 'Name: ', $key->Name,'<br>';
    echo 'Address: ';
    foreach ($key->children() as $key) {
        if ($key->getName() != 'Name') {
            echo $key, ', ';
        }
    }
    echo '<br><br>';
}


echo 'Delivery notes: ', $xml->DeliveryNotes, '<br><br>';

foreach ($xml->Items->Item as $key) {
    echo '<b>Part Number: </b>', $key->attributes (), '<br>';
    foreach ($key->children() as $key)
    echo $key->getname(), ': ', $key,'<br>';

}

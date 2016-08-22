<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
    <title>ДЗ №3</title>
</head>
<body>
<h1>ДЗ №2</h1><hr>

<?php
echo 'Задание №1<br>';
$xml   = simplexml_load_file('data.xml');
$attrs = $xml->attributes();
echo 'Oreder number: ', $attrs[0], '<br>', 'Date: ', $attrs[1], '<br><br>';
foreach ($xml->Address as $key) {
    echo '<b>Address type: </b>', $key->attributes(), '<br>';
    echo "Name: {$key->Name} <br>";//так же удобнее,---- не знал что так можно/ Буду делать так
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
    echo '<b>Part Number: </b>', $key->attributes(), '<br>';
    foreach ($key->children() as $key) {
        echo $key->getname(), ': ', $key, '<br>';
    }//psr-2 забыл - вроде поправил)
}

echo '<br><br>','Задание №2<br>';
//сейчас считают это устаревшим и все массивы делают через []
//Да и двойные кавычки не к чему))
// ----- Я тоже пришел к тому что так удобнее,буду делать так!
$str= [
    "students" => [
        ['name' => 'Вова'],
        ['name' => 'Ибрагим'],
        ['name' => 'Иван'],
        ['name' => 'Света']
    ]
];
$jsonString = json_encode($str, JSON_UNESCAPED_UNICODE);
$fp   = fopen("output.json", "w");
$test = fwrite($fp, $jsonString);
fclose($fp);
$jPath  = 'output2.json';
$jFile  = file_get_contents($jPath);
$jArray = json_decode($jFile, true);
$a = $str['students'];
$b = $jArray ['students'];
$i = 0;

function twoarr($a, $b)
{
    foreach ($a as $key) {
        $i = 0;
        foreach ($b as $key2) {
            if ($key ['name'] == $key2 ['name']) {
                $i = $i + 1;
            }
        }
        if ($i == 0) {
            echo $key['name'], ' ';
        }
    }
}

echo 'Во втором нет: ', twoarr($a, $b), '<br>';
echo 'В первом нет: ', twoarr($b, $a), '<br>';


//Не совсем корректно работает, мы можем не только поменять значение ну удалить просто


echo '<br><br>','Задание №3<br>';
for ($i = 0; $i < 50; $i++) {
    $mas[] = rand(0, 100);
}
echo 'Сумма до: ', array_sum($mas);
echo '<br>';
$fp = fopen('test.csv', 'w');
fputcsv($fp, $mas);
$csvPath = 'test.csv';
$csvFile = fopen($csvPath, "r");
$csvData = fgetcsv($csvFile, 1000, ",");
$sum = 0;
foreach ($csvData as $value) {
    ($value%2 == 0) ? ($sum = $sum + $value) :'';
}
echo 'Сумма четных чисел: ', $sum;

//нужно посчитать сумму всех четных чисел -- поправил)
echo '<br><br>','Задание №4<br>';
/**
 * @param $method
 * @param array $param
 * @param $type
 */
function wikiRequest($method, $type, $param = array())
{
    $params = '';
    foreach ($param as $key => $value) {
        $params = $params.$key.'='.$value.'&';
    }
    $url = 'https://en.wikipedia.org/w/api.php?'.$method.'&'.$params.$type;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Запрещаем вывод в брауз
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); // Убираем проверку SSL
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // Убираем SSL проверку хо
    curl_setopt($curl, CURLOPT_URL, $url); // Устанавливаем URL для запроса
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
$ary = array(
    'titles' => 'Main%20Page',
    'prop' => 'revisions',
    'rvprop' => 'content'
);
$data = wikiRequest('action=query', 'format=json', $ary);
//var_dump(json_decode($data)->query->pages->{15580374}->pageid);
//var_dump(json_decode($data)->query->pages->{15580374}->title); //Так тоже работает)))
preg_match('@("title":".*?)\"@i', $data, $result);
echo $result[0], '<br>';
preg_match('@("pageid":)[\d]+@i', $data, $result);
echo $result[0], '<br>';


// Ещё вариан решениея

$abc = json_decode($data, true);


/**
 * @param $a
 */
function rec($a, $b)
{
    if (is_array($a)) {
        foreach ($a as $value => $key) {
            if ($value == $b) {
                $e = rec($key, $b);
                echo $e;
            } else {
                rec($key, $b);
            }
        }
    } else {
        return $a;
    }
}

echo 'Page ID: ', rec($abc, 'pageid'), '<br>';
echo 'Title: ', rec($abc, 'title');
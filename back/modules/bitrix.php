<?php
global $webhook;
//crm.deal.add.json?имя=&фамилия=&отчество=&телефон=&адрес доставки=
$webhook = "https://b24-uz5zkw.bitrix24.ru/rest/1/56nxm50eddnffjny/crm.deal.add.json?имя=&фамилия=&отчество=&телефон=&адрес доставки=";

$dat=array(
    "имя" => "лекс",
    "фамилия" => "лексов",
    "отчество" => "лексович",
    "телефон" => "8 999 999 99 99",
    "адрес доставки" => "симургов 1",
    "время заказа" => time(),
);
$met="crm.deal.add";

global $b24Url;
$b24Url = "https://b24-uz5zkw.bitrix24.ru";    // укажите URL своего Битрикс24
global $b24UserID;
$b24UserID = "1";                        // ID пользователя, от имени которого будем добавлять лид
global $b24WebHook;
$b24WebHook = "56nxm50eddnffjny";        // код вебхука, который мы только что получили
/*
// формируем URL, на который будем отправлять запрос
$queryURL = "$b24Url/rest/$b24UserID/$b24WebHook/$met.json";

// формируем параметры для создания лида
$queryData = http_build_query(array(
    "fields" => array(
        "TITLE" => "Лид с нашего сайта",	// название лида
        "NAME" => "Меган Фокс",				// имя ;)
        "PHONE" => array(	// телефон в Битрикс24 = массив, поэтому даже если передаем 1 номер, то передаем его в таком формате
            "n0" => array(
                "VALUE" =>  "+7 (123) 456-78-99",	// ненастоящий номер Меган Фокс
                "VALUE_TYPE" => "MOBILE",			// тип номера = мобильный
            ),
        ),
    ),
    'params' => array("REGISTER_SONET_EVENT" => "Y")    // Y = произвести регистрацию события добавления лида в живой ленте. Дополнительно будет отправлено уведомление ответственному за лид.
));

// отправляем запрос в Б24 и обрабатываем ответ
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryURL,
    CURLOPT_POSTFIELDS => $queryData,
));
$result = curl_exec($curl);
curl_close($curl);
$result = json_decode($result, 1);
$ID = $result['result'];

$queryData = http_build_query(array(
    'id' => $ID,
    'rows' => [
        [//product with auto calc tax
            'PRODUCT_ID' => $arProduct['ID'],
            'PRICE_EXCLUSIVE' => $arProduct['PRICE'],
            'TAX_RATE' => 15,
            'TAX_INCLUDED' => 'N',
            'QUANTITY' => 1
        ],
        [//product with tax include
            'PRODUCT_ID' => $arProduct['ID'],
            'PRICE' => $arProduct['PRICE'],
            'TAX_RATE' => 15,
            'TAX_INCLUDED' => 'Y',
            'QUANTITY' => 1
        ],
        [//product with discount
            'PRODUCT_ID' => $arProduct['ID'],
            'PRICE' => $arProduct['PRICE'],
            'DISCOUNT_SUM' => 100,
            'DISCOUNT_TYPE_ID' => 1,//is sum discount type
            'QUANTITY' => 1
        ],
        [//product with a real discount
            'PRODUCT_ID' => $arProduct['ID'],
            'PRICE' => $arProduct['PRICE'] - 100,
            'DISCOUNT_SUM' => 100,
            'DISCOUNT_TYPE_ID' => 1,//is sum discount type
            'QUANTITY' => 1
        ],
        [//product with discount percent
            'PRODUCT_ID' => $arProduct['ID'],
            'PRICE_EXCLUSIVE' => $arProduct['PRICE'],
            'DISCOUNT_RATE' => 10,
            'DISCOUNT_TYPE_ID' => 2,//is percent discount type
            'QUANTITY' => 1
        ],
        [//product with real discount percent
            'PRODUCT_ID' => $arProduct['ID'],
            'PRICE_EXCLUSIVE' => $arProduct['PRICE'] - ($arProduct['PRICE'] * 0.1),
            'DISCOUNT_RATE' => 10,
            'DISCOUNT_TYPE_ID' => 2,//is percent discount type
            'QUANTITY' => 1
        ],
    ]
    )
);

$queryURL = "$b24Url/rest/$b24UserID/$b24WebHook/crm.deal.productrows.set.json";

// если произошла какая-то ошибка - выведем её
if (array_key_exists('error', $result)) {
    die("Ошибка при сохранении лида: " . $result['error_description']);
}

echo "Лид добавлен, отличная работа :)"."\n".json_encode($result);
*/

function b24($metod,$param=array()){
    global $b24Url;
    global $b24WebHook;
    global $b24UserID;
    $queryURL = "$b24Url/rest/$b24UserID/$b24WebHook/$metod.json";

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryURL,
        CURLOPT_POSTFIELDS => http_build_query($param),
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result, 1);
    return $result;
}

$queryData = array(
    "fields" => array(
        "TITLE" => "Лид с нашего сайта",	// название лида
        "NAME" => "Меган Фокс",				// имя ;)
        "PHONE" => array(	// телефон в Битрикс24 = массив, поэтому даже если передаем 1 номер, то передаем его в таком формате
            "n0" => array(
                "VALUE" =>  "+7 (123) 456-78-99",	// ненастоящий номер Меган Фокс
                "VALUE_TYPE" => "MOBILE",			// тип номера = мобильный
            ),
        ),
    ),
    'params' => array("REGISTER_SONET_EVENT" => "Y")    // Y = произвести регистрацию события добавления лида в живой ленте. Дополнительно будет отправлено уведомление ответственному за лид.
);
$metod = "crm.deal.add";
echo b24($metod,$queryData);
?>
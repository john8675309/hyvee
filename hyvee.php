<?php
$username = "";
$password = "";
$GLOBALS['searchItems'] = array();

$ch =  curl_init();
curl_setopt($ch, CURLOPT_URL, "https://hy-vee.com" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_AUTOREFERER, true );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
$result = curl_exec($ch);

$ch =  curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com/account/login.aspx?retUrl=%2F" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_AUTOREFERER, true );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
$result = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, "https://hy-vee.com/account/login.aspx" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_AUTOREFERER, true );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
$result = curl_exec($ch);
$lines = explode("\n",$result);
$post_url = "";
foreach($lines as $line) {
    if (strstr($line,"data-cy-login-uri=")) {
        $line = trim($line);
        $line = str_replace("data-cy-login-uri=","",$line);
        $line = str_replace("\"","",$line);
        $line = str_replace(",","",$line);
        $post_url = $line;
    }
}
if ($post_url == "") {
    if (!strstr($result,"Order History")) {
        echo "No Soup For You -- No Post URL For Login\n";
        exit;
    }
}

if ($post_url != "") {
    curl_setopt($ch, CURLOPT_URL, $post_url );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_AUTOREFERER, true );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','Connection: keep-alive','Accept-Language: en-US,en;q=0.5',"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8"));
    curl_setopt($ch, CURLOPT_POSTFIELDS,"username=".urlencode($username)."&password=".urlencode($password));
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
    $result = curl_exec($ch);
}

if (!strstr($result,"Order History") && !strstr($result,"My Recipes")) {
    echo "Error Logging In\n";
    exit;
}

curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_AUTOREFERER, true );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
$result = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com/aisles-online/api/aisles-online-api" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_AUTOREFERER, true );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
curl_setopt($ch, CURLOPT_REFERER, 'https://www.hy-vee.com/aisles-online/checkout/cart?iframe=true');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: */*','Accept-Encoding: gzip, deflate, br','Accept-Language: en-US,en;q=0.5','Cache-Control: max-age=0','Connection: keep-alive','content-type: application/json','Origin: https://www.hy-vee.com','TE: Trailers'));
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
curl_setopt($ch, CURLOPT_POSTFIELDS,'[{"operationName":"getHomeBanners","variables":{"authType":"TWO_LEGGED_AUTH_TYPE"},"query":"query getHomeBanners {\n  banners(where: {isActive: true}) {\n    ...bannerFragment\n    subtitle\n    description\n    productGroupId\n    __typename\n  }\n}\n\nfragment bannerFragment on banner {\n  bannerId\n  mainHref\n  imageUri\n  isActive\n  type\n  title\n  __typename\n}\n"}]');
$result = curl_exec($ch);


curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com/aisles-online/login?redirect=%2Faisles-online%2Fiframe-modal" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_AUTOREFERER, true );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
curl_setopt($ch, CURLOPT_REFERER, 'https://www.hy-vee.com/grocery/');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Accept-Language: en-US,en;q=0.5','Cache-Control: max-age=0','Connection: keep-alive','Origin: https://www.hy-vee.com','TE: Trailers','Upgrade-Insecure-Requests: 1'));
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
$result = curl_exec($ch);
//echo $result;

curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com/my-account" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_AUTOREFERER, true );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
curl_setopt($ch, CURLOPT_REFERER, 'https://www.hy-vee.com/grocery/');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Accept-Language: en-US,en;q=0.5','Cache-Control: max-age=0','Connection: keep-alive','Origin: https://www.hy-vee.com','TE: Trailers','Upgrade-Insecure-Requests: 1'));
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
$result = curl_exec($ch);
$doc = new DOMDocument();
@$doc->loadHTML($result);
$xpath = new DOMXPath($doc);
$items = $xpath->query("//script[@id='__NEXT_DATA__']");
$json = json_decode($items[0]->textContent);

$firstName = $json->props->initialReduxState->user->customer->firstName;
$lastName = $json->props->initialReduxState->user->customer->lastName;
$GLOBALS['customerId'] = $json->props->initialReduxState->user->customer->customerId;
$customerUuid= $json->props->initialReduxState->user->customer->customerUuid;
$username = $json->props->initialReduxState->user->customer->username;
$preferredStoreId = $json->props->initialReduxState->user->customer->preferredStoreId;
$fuelSaverCardUuid= $json->props->initialReduxState->user->customer->fuelSaverCardUuid;

curl_close($ch);
$GLOBALS['ch'] = curl_init();

$GLOBALS['cartItems'] = array();
echo "Welcome $firstName $lastName Let's Go Shopping!\n";

while (42 == 42) {
    $command = readline("> ");
    if ($command == "?") {
	echo "\nSearch for Item\n";
        echo "> <item>\n\n";
	echo "Quit Program\n";
	echo "> quit\n\n";
	echo "Search and Add a UPC\n";
	echo "> code <upc>\n\n";
	echo "Add an Item to the cart\n";
	echo "> add <item id from search>\n\n";
	echo "View your cart\n";
	echo "> cart\n\n";
	echo "Add quantity to item in cart\n";
	echo "> addq <item id from cart>\n\n";
	echo "Remove Quantity from cart\n";
	echo "> remq <item id from cart>\n\n";

    } else if ($command == "quit") {
        exit;
    } else if (startsWith($command, "add ")) {
	$item = explode(" ",$command);
        $item = $item[1];
        if (array_key_exists($item,$GLOBALS['searchItems'])) {
            $quantity = readline("Quantity (1) > ");
            if ($quantity == "") {
                $quantity = 1;
            }
            if (!is_numeric($quantity)) {
                $quantity = 1;
            }
	    add($item,$quantity);
        } else {
            echo "Item Not Found\n";
        }
    } else if (trim($command) == "") {
        continue;
    } else if ($command == "ads") {
        curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/grocery/ADS0/A/Ads" );
        curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
	curl_setopt($GLOBALS['ch'], CURLOPT_POST, 0);
        curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($GLOBALS['ch']);
        $doc = new DOMDocument();
        @$doc->loadHTML($result);
        $xpath = new DOMXPath($doc);
        $item = $xpath->query("//ul[@id='ulProductList']/li");
        $GLOBALS['searchItems'] = array();
        $count = 0;
	//var_dump($item);
        foreach($item as $i) {
		print_r($i->text());
	}
    } else if (startsWith($command, "code ")) {
        $item = explode(" ",$command);
        $item = $item[1];
        curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/grocery/search?search=".$item );
        curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
	curl_setopt($GLOBALS['ch'], CURLOPT_POST, 0);
        curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($GLOBALS['ch']);
        $doc = new DOMDocument();
        @$doc->loadHTML($result);
        $xpath = new DOMXPath($doc);
        $item = $xpath->query("//div[@class='li-actions']/div/@data-item");
        $GLOBALS['searchItems'] = array();
        $count = 0;
        foreach($item as $i) {
            $arr = json_decode($i->nodeValue);
            echo $count . " Name: " . stripslashes($arr->name) ." Price: $" . $arr->price . " Brand: " . stripslashes($arr->brand) . "\n";
            //echo $arr->id . " Name: " . stripslashes($arr->name) ." Price: $" . $arr->price . " Brand: " . stripslashes($arr->brand) . "\n";
            $GLOBALS['searchItems'][$count]['hierarchyID'] = $arr->hierarchyID;
            $GLOBALS['searchItems'][$count]['weight'] = $arr->weight;
            $GLOBALS['searchItems'][$count]['hash'] = $arr->hash;
            $GLOBALS['searchItems'][$count]['squID'] = $arr->squID;
            $GLOBALS['searchItems'][$count]['sreID'] = $arr->sreID;
            $count++;
        }
        $item = "";
        $item = 0;
        $quantity = 1;
        $json = array("hierarchyID"=>$GLOBALS['searchItems'][$item]['hierarchyID'],"quantity"=>$quantity,"weightedItem"=>$GLOBALS['searchItems'][$item]['weight'],"squID"=>$GLOBALS['searchItems'][$item]['squID'],"sreID"=>$GLOBALS['searchItems'][$item]['sreID'],"rankScore"=>1,"index"=>1,"hash"=>$GLOBALS['searchItems'][$item]['hash'],"categoryName"=>"Search","refreshCartTotals"=>true,"adId"=>"null");
        $json=json_encode($json);
        curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/grocery/calls/ajax.asmx/AddSearchItemToCart" );
        curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_POST, 1);
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_HTTPHEADER, array('Content-Type:  application/json; charset=utf-8','X-Requested-With: XMLHttpRequest','Connection: keep-alive','Accept-Language: en-US,en;q=0.5','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'));
        curl_setopt($GLOBALS['ch'], CURLOPT_POSTFIELDS,$json);
        curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($GLOBALS['ch']);
        $j = json_decode($result);
        if ($j->d->ItemAdded) {
            echo "Added\n";
        }
    } else if ($command == "cart") {
	cart(false);
    } else if (startsWith($command, "remq ")) {
	$item = explode(" ",$command);
        $item = $item[1];
	$cQuantity = $GLOBALS['cartItems'][$item]['quantity'];
	$cartItemId = $GLOBALS['cartItems'][$item]['cartItemId'];
	$cQuantity--;
	if ($cQuantity == 0) {
        	curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/aisles-online/api/aisles-online-api" );
	        curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
        	curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
	        curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
        	curl_setopt($GLOBALS['ch'], CURLOPT_POST, 1);
	        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
        	curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
		curl_setopt($GLOBALS['ch'], CURLOPT_REFERER, 'https://www.hy-vee.com/aisles-online/checkout/cart?iframe=true');
        	curl_setopt($GLOBALS['ch'], CURLOPT_HTTPHEADER, array('Accept: */*','Accept-Encoding: gzip, deflate, br','Accept-Language: en-US,en;q=0.5','Cache-Control: max-age=0','Connection: keep-alive','content-type: application/json','Origin: https://www.hy-vee.com','TE: Trailers'));
		curl_setopt($GLOBALS['ch'],CURLOPT_POSTFIELDS,'[{"operationName":"DeleteCartItemMutation","variables":{"cartItemId":'.$GLOBALS['cartItems'][$item]['cartItemId'].'},"query":"mutation DeleteCartItemMutation($customerId: Int!, $cartItemId: Int!) {\n  deleteCartItem(customerId: $customerId, cartItemId: $cartItemId)\n}\n"}]');
	        curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        	$result = curl_exec($GLOBALS['ch']);
		$j = json_decode($result);
		$GLOBALS['cartItems'][$item]['quantity'] = $j->data->updateCartItem->quantity;	
	} else {
		//there is a big here, Hyvee Lets you go Negative... Someone didn't sanitize their inputs over there, this causes NEGATIVE balances WHOA!  We don't HAVE to use Javascript you know... I will report this later after I find out if this is exploitable.  But for now.. Handle it.
        	curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/aisles-online/api/aisles-online-api" );
	        curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
        	curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
	        curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
        	curl_setopt($GLOBALS['ch'], CURLOPT_POST, 1);
	        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
        	curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
		curl_setopt($GLOBALS['ch'], CURLOPT_REFERER, 'https://www.hy-vee.com/aisles-online/checkout/cart?iframe=true');
        	curl_setopt($GLOBALS['ch'], CURLOPT_HTTPHEADER, array('Accept: */*','Accept-Encoding: gzip, deflate, br','Accept-Language: en-US,en;q=0.5','Cache-Control: max-age=0','Connection: keep-alive','content-type: application/json','Origin: https://www.hy-vee.com','TE: Trailers'));
		curl_setopt($GLOBALS['ch'],CURLOPT_POSTFIELDS,'[{"operationName":"UpdateCartItemMutation","variables":{"cartItemId":"' . $cartItemId . '","cartItemInput":{"note":null,"quantity":'.$cQuantity.',"tax":0}},"query":"mutation UpdateCartItemMutation($customerId: Int!, $cartItemId: Int!, $cartItemInput: cartItemInput!) {\n  updateCartItem(customerId: $customerId, cartItemId: $cartItemId, cartItemInput: $cartItemInput) {\n    cartItemId\n    note\n    quantity\n    tax\n    __typename\n  }\n}\n"}]');
	        curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
	      	$result = curl_exec($GLOBALS['ch']);
		$j = json_decode($result);
		$GLOBALS['cartItems'][$item]['quantity'] = $j->data->updateCartItem->quantity;	
	}
	cart(false);
    } else if (startsWith($command, "addq ")) {
	$item = explode(" ",$command);
        $item = $item[1];
	$cQuantity = $GLOBALS['cartItems'][$item]['quantity'];
	$cartItemId = $GLOBALS['cartItems'][$item]['cartItemId'];
	$cQuantity++;
        curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/aisles-online/api/aisles-online-api" );
        curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_POST, 1);
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
	curl_setopt($GLOBALS['ch'], CURLOPT_REFERER, 'https://www.hy-vee.com/aisles-online/checkout/cart?iframe=true');
        curl_setopt($GLOBALS['ch'], CURLOPT_HTTPHEADER, array('Accept: */*','Accept-Encoding: gzip, deflate, br','Accept-Language: en-US,en;q=0.5','Cache-Control: max-age=0','Connection: keep-alive','content-type: application/json','Origin: https://www.hy-vee.com','TE: Trailers'));
	curl_setopt($GLOBALS['ch'], CURLOPT_POSTFIELDS,'[{"operationName":"UpdateCartItemMutation","variables":{"cartItemId":' . $cartItemId . ',"cartItemInput":{"note":null,"quantity":'.$cQuantity.',"tax":0}},"query":"mutation UpdateCartItemMutation($customerId: Int!, $cartItemId: Int!, $cartItemInput: cartItemInput!) {\n  updateCartItem(customerId: $customerId, cartItemId: $cartItemId, cartItemInput: $cartItemInput) {\n    cartItemId\n    note\n    quantity\n    tax\n    __typename\n  }\n}\n"}]');
        curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($GLOBALS['ch']);
	$j = json_decode($result);
	$GLOBALS['cartItems'][$item]['quantity'] = $j->data->updateCartItem->quantity;
        cart(false);	
    } else {
        //search it https://www.hy-vee.com/grocery/search?search=
        $item = urlencode($command);
        $sItem = $item;
        curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/grocery/search?search=".$item );
        curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
	    curl_setopt($GLOBALS['ch'], CURLOPT_POST, 0);
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($GLOBALS['ch']);
        $doc = new DOMDocument();
        @$doc->loadHTML($result);
        $xpath = new DOMXPath($doc);
        $item = $xpath->query("//div[@class='li-actions']/div/@data-item");
        $GLOBALS['searchItems'] = array();
        $count = 0;
        foreach($item as $i) {
            $arr = json_decode($i->nodeValue);
            echo $count . " Name: " . stripslashes($arr->name) ." Price: $" . $arr->price . " Brand: " . stripslashes($arr->brand) . "\n";
            //echo $arr->id . " Name: " . stripslashes($arr->name) ." Price: $" . $arr->price . " Brand: " . stripslashes($arr->brand) . "\n";
            $GLOBALS['searchItems'][$count]['hierarchyID'] = $arr->hierarchyID;
            $GLOBALS['searchItems'][$count]['weight'] = $arr->weight;
            $GLOBALS['searchItems'][$count]['hash'] = $arr->hash;
            $GLOBALS['searchItems'][$count]['squID'] = $arr->squID;
            $GLOBALS['searchItems'][$count]['sreID'] = $arr->sreID;
            $count++;
        }
    	if (is_numeric($sItem)) {
            if (sizeof($item) == 1) {
		        //echo "Numeric\n";
		        //echo $GLOBALS['searchItems'][0]['hierarchyID'] ."\n";
		        add(0);
            }
	    }
        $item = "";
    }

}


function add($item,$quantity=1) {
	$json = array("hierarchyID"=>$GLOBALS['searchItems'][$item]['hierarchyID'],"quantity"=>$quantity,"weightedItem"=>$GLOBALS['searchItems'][$item]['weight'],"squID"=>$GLOBALS['searchItems'][$item]['squID'],"sreID"=>$GLOBALS['searchItems'][$item]['sreID'],"rankScore"=>1,"index"=>1,"hash"=>$GLOBALS['searchItems'][$item]['hash'],"categoryName"=>"Search","refreshCartTotals"=>true,"adId"=>"null");
        $json=json_encode($json);
        curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/grocery/calls/ajax.asmx/AddSearchItemToCart" );
        curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_POST, 1);
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_HTTPHEADER, array('Content-Type:  application/json; charset=utf-8','X-Requested-With: XMLHttpRequest','Connection: keep-alive','Accept-Language: en-US,en;q=0.5','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'));
        curl_setopt($GLOBALS['ch'], CURLOPT_POSTFIELDS,$json);
        curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($GLOBALS['ch']);
        $j = json_decode($result);
        if ($j->d->ItemAdded) {
            echo "Added\n";
        }
	//cart(false);
}

function cart($silent=false) {
	curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/shop/checkout/cart.aspx" );
	curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
	curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
	curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($GLOBALS['ch'], CURLOPT_POST, 0);
	curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
	curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
	curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
	$result = curl_exec($GLOBALS['ch']);

        curl_setopt($GLOBALS['ch'], CURLOPT_URL, "https://www.hy-vee.com/aisles-online/api/aisles-online-api" );
        curl_setopt($GLOBALS['ch'], CURLOPT_RETURNTRANSFER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_AUTOREFERER, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($GLOBALS['ch'], CURLOPT_POST, 1);
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($GLOBALS['ch'], CURLOPT_COOKIEFILE, "cookies");
	curl_setopt($GLOBALS['ch'], CURLOPT_REFERER, 'https://www.hy-vee.com/aisles-online/checkout/cart?iframe=true');
        curl_setopt($GLOBALS['ch'], CURLOPT_HTTPHEADER, array('Accept: */*','Accept-Encoding: gzip, deflate, br','Accept-Language: en-US,en;q=0.5','Cache-Control: max-age=0','Connection: keep-alive','content-type: application/json','Origin: https://www.hy-vee.com','TE: Trailers'));
	curl_setopt($GLOBALS['ch'],CURLOPT_POSTFIELDS,'[{"operationName":"getActiveCart","variables":{"customerId":'.$GLOBALS['customerId'].'},"query":"query getActiveCart($customerId: Int!) {\n  customer(customerId: $customerId) {\n    customerId\n    customerMemberships {\n      customerMembershipId\n      isActive\n      membership {\n        membershipId\n        type\n        __typename\n      }\n      __typename\n    }\n    firstName\n    __typename\n  }\n  carts(customerId: $customerId, where: {isActive: true}) {\n    cartId\n    customerId\n    storeId\n    fulfillmentExpiration\n    fulfillmentId\n    fulfillmentWindowStart\n    fulfillmentWindowEnd\n    fulfillmentType\n    fulfillmentLocation {\n      fulfillmentLocationId\n      fulfillmentStoreId\n      locationName\n      fulfillmentFees {\n        feeWithMembership\n        feeWithoutMembership\n        orderMinimumAmount\n        duration\n        __typename\n      }\n      fulfillmentTimes {\n        duration\n        windowStart\n        windowEnd\n        __typename\n      }\n      __typename\n    }\n    cartItems {\n      cartItemId\n      note\n      quantity\n      quantityType\n      storeProduct {\n        storeProductId\n        onSale\n        onFuelSaver\n        isWeighted\n        isActive\n        isAlcohol\n        fuelSaver\n        price\n        priceMultiple\n        taxRate\n        department {\n          departmentId\n          __typename\n        }\n        product {\n          name\n          productId\n          size\n          averageWeight\n          upc\n          isNotEligibleForDelivery\n          productImages(where: {isPrimary: true, size: \"THUMBNAIL\"}) {\n            uri\n            size\n            isPrimary\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      tax\n      __typename\n    }\n    cartPromotions {\n      cartPromotionId\n      isApplied\n      promotion {\n        promotionId\n        promoCode\n        description\n        threshold\n        amount\n        isPercentage\n        isActive\n        startDate\n        endDate\n        allowedUsages\n        isStackable\n        isFuelSaver\n        newCustomersOnly\n        isAvailableForAllOrderTypes\n        isAvailableForAllStores\n        __typename\n      }\n      __typename\n    }\n    deliveryAddress {\n      addressOne\n      addressTwo\n      city\n      state\n      zip\n      fulfillmentLocations {\n        fulfillmentLocationId\n        __typename\n      }\n      __typename\n    }\n    pickupLocation {\n      pickupLocationId\n      name\n      address\n      city\n      state\n      zip\n      isActive\n      pickupLocationHasLocker\n      __typename\n    }\n    store {\n      name\n      address\n      city\n      state\n      zip\n      __typename\n    }\n    __typename\n  }\n}\n"}]');
        curl_setopt($GLOBALS['ch'], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($GLOBALS['ch']);
        $j = json_decode($result);
	$cartCount = 0;
	$GLOBALS['cartItems'] = array();
	//print_r($j[0]->data->carts[0]->cartItems);
	foreach($j[0]->data->carts as $cart) {
		foreach($cart->cartItems as $item) {			
			//print_r($item);
			$GLOBALS['cartItems'][$cartCount]['cartItemId'] = $item->cartItemId;
			$GLOBALS['cartItems'][$cartCount]['quantity'] = $item->quantity; 
			$GLOBALS['cartItems'][$cartCount]['name'] = $item->storeProduct->product->name; 
			if ($silent == false) {
				echo $cartCount . " Name: " . $item->storeProduct->product->name . " Price: " . $item->storeProduct->price . " Quantity: " . $item->quantity . "\n";
				$cartCount++;
			}
		}
	}
	if ($cartCount == 0) {
		if ($silent == false) {
			echo "Uh Oh no Items, you best be getting shopping!\n";
		}
	}
}


function startsWith ($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString); 
}

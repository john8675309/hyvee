<?php
$username = "";
$password = "";
$searchItems = array();

$ch =  curl_init();
curl_setopt($ch, CURLOPT_URL, "https://hy-vee.com" );
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
        echo "No Soup For You -- No Post URL For Login";
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
    echo "Error Logging In";
    exit;
}

echo "Let's Go Shopping!\n";

while (42 == 42) {
    $command = readline("> ");
    if ($command == "?") {
        echo "Type Item To Search";
    } else if ($command == "quit") {
        exit;
    } else if (startsWith($command, "add ")) {
        $item = explode(" ",$command);
        $item = $item[1];
        if (array_key_exists($item,$searchItems)) {
            $quantity = readline("Quantity (1) > ");
            if ($quantity == "") {
                $quantity = 1;
            }
            if (!is_numeric($quantity)) {
                $quantity = 1;
            }
            $json = array("hierarchyID"=>$searchItems[$item]['hierarchyID'],"quantity"=>$quantity,"weightedItem"=>$searchItems[$item]['weight'],"squID"=>$searchItems[$item]['squID'],"sreID"=>$searchItems[$item]['sreID'],"rankScore"=>1,"index"=>1,"hash"=>$searchItems[$item]['hash'],"categoryName"=>"Search","refreshCartTotals"=>true,"adId"=>"null");
            $json=json_encode($json);
            curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com/grocery/calls/ajax.asmx/AddSearchItemToCart" );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_AUTOREFERER, true );
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
            curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:  application/json; charset=utf-8','X-Requested-With: XMLHttpRequest','Connection: keep-alive','Accept-Language: en-US,en;q=0.5','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'));
            curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
            $result = curl_exec($ch);
            $j = json_decode($result);
            if ($j->d->ItemAdded) {
                echo "Added\n";
            }
        } else {
            echo "Item Not Found\n";
        }
    } else if ($command == "") {
        continue;
    } else if (startsWith($command, "code ")) {
        $item = explode(" ",$command);
        $item = $item[1];
        curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com/grocery/search?search=".$item );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_AUTOREFERER, true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($ch);
        $doc = new DOMDocument();
        @$doc->loadHTML($result);
        $xpath = new DOMXPath($doc);
        $item = $xpath->query("//div[@class='li-actions']/div/@data-item");
        $searchItems = array();
        $count = 0;
        foreach($item as $i) {
            $arr = json_decode($i->nodeValue);
            echo $count . " Name: " . stripslashes($arr->name) ." Price: $" . $arr->price . " Brand: " . stripslashes($arr->brand) . "\n";
            //echo $arr->id . " Name: " . stripslashes($arr->name) ." Price: $" . $arr->price . " Brand: " . stripslashes($arr->brand) . "\n";
            $searchItems[$count]['hierarchyID'] = $arr->hierarchyID;
            $searchItems[$count]['weight'] = $arr->weight;
            $searchItems[$count]['hash'] = $arr->hash;
            $searchItems[$count]['squID'] = $arr->squID;
            $searchItems[$count]['sreID'] = $arr->sreID;
            $count++;
        }
        $item = "";
        $item = 0;
        $quantity = 1;
        $json = array("hierarchyID"=>$searchItems[$item]['hierarchyID'],"quantity"=>$quantity,"weightedItem"=>$searchItems[$item]['weight'],"squID"=>$searchItems[$item]['squID'],"sreID"=>$searchItems[$item]['sreID'],"rankScore"=>1,"index"=>1,"hash"=>$searchItems[$item]['hash'],"categoryName"=>"Search","refreshCartTotals"=>true,"adId"=>"null");
        $json=json_encode($json);
        curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com/grocery/calls/ajax.asmx/AddSearchItemToCart" );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_AUTOREFERER, true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:  application/json; charset=utf-8','X-Requested-With: XMLHttpRequest','Connection: keep-alive','Accept-Language: en-US,en;q=0.5','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($ch);
        $j = json_decode($result);
        if ($j->d->ItemAdded) {
            echo "Added\n";
        }
    } else if ($command == "cart") {
        curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com/shop/checkout/cart.aspx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_AUTOREFERER, true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($ch);
        echo "Cart is broken on the Hy-Vee Side Right now\n";
    } else {
        //search it https://www.hy-vee.com/grocery/search?search=
        $item = urlencode($command);
        curl_setopt($ch, CURLOPT_URL, "https://www.hy-vee.com/grocery/search?search=".$item );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_AUTOREFERER, true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($ch, CURLOPT_COOKIEJAR,"cookies");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies");
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0');
        $result = curl_exec($ch);
        $doc = new DOMDocument();
        @$doc->loadHTML($result);
        $xpath = new DOMXPath($doc);
        $item = $xpath->query("//div[@class='li-actions']/div/@data-item");
        $searchItems = array();
        $count = 0;
        foreach($item as $i) {
            $arr = json_decode($i->nodeValue);
            echo $count . " Name: " . stripslashes($arr->name) ." Price: $" . $arr->price . " Brand: " . stripslashes($arr->brand) . "\n";
            //echo $arr->id . " Name: " . stripslashes($arr->name) ." Price: $" . $arr->price . " Brand: " . stripslashes($arr->brand) . "\n";
            $searchItems[$count]['hierarchyID'] = $arr->hierarchyID;
            $searchItems[$count]['weight'] = $arr->weight;
            $searchItems[$count]['hash'] = $arr->hash;
            $searchItems[$count]['squID'] = $arr->squID;
            $searchItems[$count]['sreID'] = $arr->sreID;
            $count++;
        }
        $item = "";
    }

}



function startsWith ($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString); 
}

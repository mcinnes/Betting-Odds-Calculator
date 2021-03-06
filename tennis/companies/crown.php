<?

// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.beteasy.com.au/mobile/event/sports/nav/104");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = "Host: api.beteasy.com.au";
$headers[] = "Clientprofileid: 0";
$headers[] = "Accept: application/json";
$headers[] = "Channel: 3";
$headers[] = "Accept-Language: en-au";
$headers[] = "Content-Type: application/json";
$headers[] = "Securitymd5: 1505093761_C643CB3A758CA5AF8FFDC48D12CD2EFC";
$headers[] = "Referer: beteasy-app";
$headers[] = "User-Agent: CrownBet/3885 CFNetwork/811.5.4 Darwin/16.6.0";
$headers[] = "X-Newrelic-Id: Ug4BVlJQGwoHUVFXBAI=";
$headers[] = "Cookie: incap_ses_606_202418=NOaYF9TJwBAz1DU9EvJoCGbotVkAAAAA1aJk3aS7OmVafwfAPeFwtw==; visid_incap_202418=FzXozJ4+TZKviextvfUgkBPltVkAAAAAQUIPAAAAAAB/+88MkFiYV7rfxCfhAXkN; nlbi_202418=by4afPM2Jjb3cCidU27PYwAAAABhkSOYLvomi/tgDhJGmvB+; incap_ses_607_202407=dEAgMczvzHvK/OQ1k39sCGTotVkAAAAApp0XzEe45y9QFN+yip2flQ==; visid_incap_202407=R/MNMivVTtiPvuGgw4baDhTltVkAAAAAQUIPAAAAAACM0Ch9T/aBemWvyW/gIZZm; nlbi_202407=zASlX0u+dEatyiO75ZSdyQAAAABPj5NDzxlCjmyz0+TAwlBh";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

$eventIDs[] = array();

$masterList = json_decode($result, true);
var_dump($masterList);

$masterCategories = $masterList["MasterCategories"];

foreach ($masterCategories as $cat){
    $eventCats = $cat["Categories"];
    foreach($eventCats as $event){
        $eventIDs[] = $event["CategoryID"];
        getCrownDetails($event["CategoryID"]);
    }
}
var_dump($eventIDs);

//getDetails(22843);




function getCrownDetails($id){

    // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.beteasy.com.au/mobile/event/sports/nav/104/mastercategories/62/categories/".$id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = "Host: api.beteasy.com.au";
    $headers[] = "Clientprofileid: 0";
    $headers[] = "Accept: application/json";
    $headers[] = "Channel: 3";
    $headers[] = "Accept-Language: en-au";
    $headers[] = "Content-Type: application/json";
    $headers[] = "Securitymd5: 1505093835_A90D1257FB54F4800D4FAB3C16920498";
    $headers[] = "Referer: beteasy-app";
    $headers[] = "User-Agent: CrownBet/3885 CFNetwork/811.5.4 Darwin/16.6.0";
    $headers[] = "X-Newrelic-Id: Ug4BVlJQGwoHUVFXBAI=";
    $headers[] = "Cookie: incap_ses_607_202407=dEAgMczvzHvK/OQ1k39sCGTotVkAAAAApp0XzEe45y9QFN+yip2flQ==; visid_incap_202407=R/MNMivVTtiPvuGgw4baDhTltVkAAAAAQUIPAAAAAACM0Ch9T/aBemWvyW/gIZZm; incap_ses_606_202418=NOaYF9TJwBAz1DU9EvJoCGbotVkAAAAA1aJk3aS7OmVafwfAPeFwtw==; visid_incap_202418=FzXozJ4+TZKviextvfUgkBPltVkAAAAAQUIPAAAAAAB/+88MkFiYV7rfxCfhAXkN; nlbi_202418=by4afPM2Jjb3cCidU27PYwAAAABhkSOYLvomi/tgDhJGmvB+; nlbi_202407=zASlX0u+dEatyiO75ZSdyQAAAABPj5NDzxlCjmyz0+TAwlBh";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);

    // Will dump a beauty json :3
    //var_dump(json_decode($result, true));

    $endResult = json_decode($result, true);

    $gameList = $endResult["SportsEvents"];

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "betting";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {



    }

    foreach($gameList as $item) { //foreach element in $arr
        
        $player1 = $item["FeaturedMarket"]["Outcomes"][0]["OutcomeName"];
        $player2 = $item["FeaturedMarket"]["Outcomes"][1]["OutcomeName"];
        $title = $item["MasterEventName"];
        $timestamp = strtotime($item["AdvertisedStartTime"]);
        $startTime = $timestamp;
        $competition = $item["CategoryName"];
        $player1Odds = floatVal($item["FeaturedMarket"]["Outcomes"][0]["Price"]);
        $player2Odds = floatVal($item["FeaturedMarket"]["Outcomes"][1]["Price"]);
        echo $player2Odds;
        $sql = "INSERT INTO tennisCrown (startTime, title, player1, player2, competition, player1Odds, player2Odds) VALUES ('$startTime', '$title', '$player1','$player2', '$competition',$player1Odds, $player2Odds)";
        
        if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: user already exists" . "<br>" . $conn->error;
                    }
    }

}

return true;

?>

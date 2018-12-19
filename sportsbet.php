<?

$gameID = $argv[1];

$url="https://pubapi.sportsbet.com.au/v1/sportsbook/events/".$gameID;
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
//var_dump(json_decode($result, true));

$endResult = json_decode($result, true);

//var_dump($endResult["marketList"][0]["outcomeList"][0]["name"]);


echo "\n";
echo "Game ID: " . $endResult["id"];
echo "\n";
echo "\n";
echo "Game Type: " . $endResult["className"];
echo "\n";
echo "\n";
echo "Odds for: ". $endResult["marketList"][0]["outcomeList"][0]["name"];
echo "\n";
echo "Player ID: ". $endResult["marketList"][0]["outcomeList"][0]["outcomeExternalId"];
echo "\n";
echo "Paying: ". $endResult["marketList"][0]["outcomeList"][0]["winPrice"];
echo "\n";
echo "\n";
echo "Odds for: ". $endResult["marketList"][0]["outcomeList"][1]["name"];
echo "\n";
echo "Player ID: ". $endResult["marketList"][0]["outcomeList"][1]["outcomeExternalId"];
echo "\n";
echo "Paying: ". $endResult["marketList"][0]["outcomeList"][1]["winPrice"];
echo "\n";
echo "\n";

?>
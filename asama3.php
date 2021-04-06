<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Benzerlik oranı bulucu</title>
</head>
<body>
<form action="" method="post">
    <label for="url">Birinci URL'yi giriniz:</label><br>
    <input type="text" id="url" name="url" size="100"><br>
    <label for="url2">İkinci URL'yi giriniz:</label><br>
    <input type="text" id="url2" name="url2" size="100"><br><br>
    <input type="submit" value="Benzerlik Kıyasla">
</form>
</body>
</html>

<?php
require_once('Html2Text.php');
if(isset($_POST["url"],$_POST["url2"]))
{
    $url = $_POST["url"];
    $url2 = $_POST["url2"];
    if($url != "" && $url2 != "")
    {
        $metin = ayikla($url);
        $metin2 = ayikla($url2);
        $sim = similar_text($metin, $metin2, $percent);
        echo "2 web sitesinin benzerlik oranı: %$percent\n";
    }
}
function ayikla( $url )
{
    $html = file_get_contents($url);
    $metin = new Html2Text($html);
    $metin = $metin->getText();  // Hazır kütüphane stringi arındırır.
    $metin = strtolower($metin);
    $metin = temizle($metin);
    $metin = preg_replace("/[^a-zA-Z]/"," ",$metin);
    $metin = str_replace('www', '', $metin);
    $metin = str_replace('com', '', $metin);
    $metin = str_replace('https', '', $metin);
    $metin = str_replace('http', '', $metin);
    $metin = preg_replace("/\b[a-zA-Zçğüşıöi]{1,3}\b/i","",$metin);
    $metin = str_replace('this', '', $metin);
    $metin = str_replace('that', '', $metin);
    $metin = str_replace('they', '', $metin);
    $metin = str_replace('have', '', $metin);
    $metin = str_replace('from', '', $metin);
    $metin = str_replace('what', '', $metin);
    $metin = str_replace('where', '', $metin);
    $metin = str_replace('which', '', $metin);
    $metin = str_replace('each', '', $metin);
    $metin = str_replace('their', '', $metin);
    $metin = str_replace('your', '', $metin);
    $metin = str_replace('said', '', $metin);
    $metin = str_replace('could', '', $metin);
    $metin = str_replace('there', '', $metin);
    $metin = str_replace('than', '', $metin);
    $metin = str_replace('with', '', $metin);
    $metin = str_replace('more', '', $metin);
    $metin = preg_replace('/\s\s+/', ' ',$metin);
    return $metin;
}
function temizle($text)
{
    $result = preg_replace(
        '/\b            # Start of word
    [\p{L}\p{N}]+   # One or     more Unicode letters
    [^\s\p{L}\p{N}] # One non-letter (and non-whitespace), followed by
    [^\s\p{P}]+     # at least one non-whitespace, non-punctuation character
    \b              # End of word
    \s*             # optional following whitespace
    /xu',
        '', $text);
    return $result;
}
?>
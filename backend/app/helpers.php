<?php

function base64url_encode($data)
{
    // First of all you should encode $data to Base64 string
    $b64 = base64_encode($data);

    // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
    if ($b64 === false) {
        return false;
    }

    // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
    $url = strtr($b64, '+/', '-_');

    // Remove padding character from the end of line and return the Base64URL result
    return rtrim($url, '=');
}

function MakeJwt($request)
{
    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];
    $header = json_encode($header);
    $header = base64_encode($header);

    $payload = $request;
    $payload = json_encode($payload);
    $payload = base64_encode($payload);

    $signature = hash_hmac('sha256', "$header.$payload", '3nc0d3d1g1w4ll3t', true);
    $signature = base64url_encode($signature);

    $jwt_token = "$header.$payload.$signature";

    return $jwt_token;
}

function DateRecurrences(String $date, Int $qtd)
{
    $initial = 0;

    $date = strtotime($date);

    $year = date("Y", $date);
    $month = date("m", $date);
    $day = date("d", $date);

    for ($i = $initial; $i < $qtd; $i++) {

        if ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
            if ($day == 31) {
                $date = "$year-$month-31";
            } else {
                $date = "$year-$month-$day";
            }
        } else if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
            if ($day > 30) {
                $date = "$year-$month-30";
            } else {
                $date = "$year-$month-$day";
            }
        } else if ($month == 2) {
            if ($day > 29) {
                $leap = date('L', mktime(0, 0, 0, 1, 1, $year));
                if ($leap) {
                    $date = "$year-$month-29";
                } else {
                    $date = "$year-$month-28";
                }
            } else {
                if ($day > 28) {
                    $date = "$year-$month-28";
                } else {
                    $date = "$year-$month-$day";
                }
            }
        }

        if ($month == 12) {
            $month = 0;
            $year++;
        }

        $month++;

        $dates[$i] = $date;
    }

    return $dates;
}

<?php


namespace App\Service;


class Kodik
{
    /**
     * Получение ссылки на плеер
     *
     * @param array $arIds
     * @return mixed
     * @todo: Переписать с CURL на SOAP
     */
    public function getPlayer(array $arIds): string
    {
        $arData = [
            'token' => $_ENV['KODIK_API'],
            'kinopoisk_id' => $arIds['kinopoiskID'] ?: null,
            'imdb_id' => $arIds['imdbID'] ?: null,
            'mdl_id' => $arIds['mdlID'] ?: null,
            'shikimori_id' => $arIds['shikimoriID'] ?: null,
            'worldart_animation_id' => $arIds['worldartanimeID'] ?: null,
            'prioritize_translations' => 1720,
            'not_blocked_in' => 'RU'
        ];

        $curl = curl_init('https://kodikapi.com/search');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($arData));
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true)['results'][0]['link'];
    }

}
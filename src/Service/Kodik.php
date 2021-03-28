<?php


namespace App\Service;


use App\Utils\Cache\Redis;

class Kodik
{
    /**
     * Получение ссылки на плеер
     *
     * @param string $kodikId
     * @param array $arIds
     * @return mixed
     */
    public function getPlayer(string $kodikId, array $arIds): string
    {
        $redisCache = new Redis();

        if ($linkPlayer = $redisCache->getValueFromCache($kodikId)) {
            return $linkPlayer;
        }

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

        $linkResult = json_decode($response, true)['results'][0]['link'];

        $redisCache->setValueToCache($kodikId, $linkResult);

        return $linkResult;
    }
}
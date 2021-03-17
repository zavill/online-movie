<?php


namespace App\Service;


class Kodik
{
    /**
     * Получение ссылки на плеер
     *
     * @param $id
     * @return mixed
     * @todo Переписать с CURL на SOAP
     */
    public function getPlayer($id)
    {

        $arData = [
            'token' => '57bc8bccd7f8625b4d5d8b32f54b89b1',
            'id' => $id,
        ];

        $curl = curl_init('https://kodikapi.com/search');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($arData));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true)['results'][0]['link'];
    }

}
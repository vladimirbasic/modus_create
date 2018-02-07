<?php

namespace Modus\Library;

use Modus\Exception\CurlAdapterException;

class CurlAdapter
{
    /**
     * @throws CurlAdapterException
     */
    public function sendRequest(string $url, array $headers): array
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 5,
        ]);

        $result = curl_exec($curl);

        try {
            if ($result === false) {
                throw new CurlAdapterException(curl_error($curl), curl_getinfo($curl, CURLINFO_HTTP_CODE));
            }
        } finally {
            curl_close($curl);
        }

        $result = json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new CurlAdapterException(json_last_error_msg(), json_last_error());
        }

        return $result;
    }
}

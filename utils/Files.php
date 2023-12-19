<?php

namespace Utils;

use Exception;
use Utils\ExceptionsHandler;

class Files
{
    /**
     * Escreve em um arquivo
     * @param string $fileName
     * @param string $mode
     * @param string $text
     * @return void
     */
    public static function write($fileName, $mode = "w", $text)
    {
        $file = fopen($fileName, $mode);
        if (!$file) return false;
        fwrite($file, $text);
        fclose($file);
    }

    /**
     * Cria um diretório
     * @param string $dirName
     * @param int $permissions
     * @return void
     */
    public static function createDir($dirName, $permissions = 0775)
    {
        if (!is_dir($dirName)) {
            if (!mkdir($dirName, $permissions)) throw new Exception("Failed to create '$dirName' dir");
        }
    }

    /**
     * Cria o arquivo de logs para as exceptions do sistema
     * @param array $request
     * @return void
     */
    public static function logExceptions(array $errors)
    {
        self::writeLogFile('exceptions.log', $_SESSION['userId'] . "\t" . Str::dataToJsonStr($errors) . "\n");
    }

    /**
     * Cria o arquivo de logs para as requisições curl
     *
     * @param integer $userId
     * @param string $data
     * @param string $response
     * @param integer $httpCode
     * @param string $curlError
     * @param string $curlInfo
     * @return void
     */
    public static function logCurlRequests(int $userId, string $url, string $data, string $response, int $httpCode, string $curlError, string $curlInfo)
    {
        $content  = $userId . "\t";
        $content .= $url . "\t";
        $content .= Str::dataToJsonStr($data) . "\t";
        $content .= Str::dataToJsonStr($response) . "\t";
        $content .= $httpCode . "\t";
        $content .= $curlError . "\t";
        $content .= Str::dataToJsonStr($curlInfo) . "\n";
        self::writeLogFile('curlRequests.log', $content);
    }

    /**
     * @param string|null $sql
     * @param array|null $params
     * @param boolean|null $strictTypes
     * @param string|null $thrownMessage
     * @return void
     */
    public static function logDbQuery(?string $sql, ?array $params, ?bool $strictTypes, ?string $thrownMessage)
    {
        $content  = str_replace(array("\r", "\n"), "", $sql) . "\t";
        $content .= Str::dataToJsonStr($params) . "\t";
        $content .= $strictTypes . "\t";
        $content .= $thrownMessage . "\n";
        self::writeLogFile('pdoExceptions.log', $content);
    }

    /**
     * Escreve em um arquivo de logs
     * @param string $fileName
     * @param string $content
     * @return void
     */
    private static function writeLogFile($fileName, $content)
    {
        try {
            $dirName  = ABSOLUTE_MAIN_PATH . DIRECTORY_SEPARATOR . ROOT_LOGS_DIR . DIRECTORY_SEPARATOR . date('Y-m-d') . DIRECTORY_SEPARATOR;
            $fileName = $dirName . $fileName;
            Files::createDir($dirName);
            Files::write($fileName, 'a', date('Y-m-d H:i:s') . "\t" . $content);
        } catch (\Exception $e) {
            (new ExceptionsHandler($e, 'E000-005', 500))->_print();
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 28/08/2017
 * Time: 15:21
 */

namespace Classes\Cdcl\Exceptions;


class InvalidSqlQueryException extends \Exception {
    /**
     * @param string $sql
     * @param \PDO|\PDOStatement $stmt
     * @param int $code
     * @param null $previous
     */
    public function __construct($sql, $stmt, $code = 0, $previous = null) {
        $message = 'Invalid query'."\r\n".$sql."\r\n";
        $message .= '-------------------------------'."\r\n".print_r($stmt->errorInfo(), 1);
        parent::__construct($message, $code, $previous);
    }
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
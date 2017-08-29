<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 28/08/2017
 * Time: 14:30
 */

namespace Classes\Cdcl\Db;


abstract class DbObject {
    /** @var int */
    protected $id;
    /** @var int */
    protected $created;

    public function __construct($id=0, $created='') {
        $this->id = $id;
        if (is_numeric($created)) {
            $this->created = $created;
        }
        else {
            $this->created = strtotime($created);
        }
    }

    /**
     * @param int $id
     * @return DbObject
     * @throws InvalidSqlQueryException
     */
    abstract public static function get($id);

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    abstract public static function getAll();

    /**
     * @return array
     * @throws InvalidSqlQueryException
     */
    abstract public static function getAllForSelect();



    /**
     * @return bool
     * @throws InvalidSqlQueryException
     */
    abstract public function saveDB();

    /**
     * @param int $id
     * @return bool
     * @throws InvalidSqlQueryException
     */
    abstract public static function deleteById($id);

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCreated() {
        return $this->created;
    }
}
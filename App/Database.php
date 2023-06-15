<?php
/**
 * @class Database
 * @created 31/03/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */

namespace App;

use DateTime;
use DateTimeZone;
use Exception;
use PDO;
use PDOException;

class Database
{
    private static Database $_instance;
    private PDO $_pdo;

    private $_error;
    private $_query;
    private $_results;
    private $_count;

    public function __construct($host, $db_name, $username, $password)
    {
        $date_time_zone = new DateTimeZone(date_default_timezone_get());
        $date_time = new DateTime('now', $date_time_zone);

        $dns = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $host, $db_name);
        $this->_pdo = new PDO($dns, $username, $password, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone='" . $date_time->format('P') . "'"
        ]);
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): Database
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    /**
     * @param $sql
     * @param array $params
     *
     * SELECT
     *
     * Искарване на нешата от датабазата. Като не може да се изпозлва за;
     * UPDATE, DELETE actions
     *
     * @return $this
     */
    public function query($sql, array $params = array()): Database
    {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);

                $this->_count = $this->_query->rowCount();

            } else {
                print_r($this->_pdo->errorInfo());
                $this->_error = true;
            }

        }

        return $this;
    }


    /**
     * @param $sql
     * @param array $params
     *
     * Служи за DELETE, UPDATE и тн от датабазата без SELECT
     *
     * @return $this
     * @throws Exception
     */
    public function createQuery($sql, array $params = array()): Database
    {

        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;

            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if ($this->_query->execute()) {
                $this->_count = $this->_query->rowCount();
            } else {
                print_r($this->_pdo->errorInfo());
                $this->_error = true;
            }

        }
        return $this;
    }

    public function getWhere($table, array $where = [])
    {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=', '<>');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            if (in_array($operator, $operators)) {
                $sql = "SELECT * FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    public function update($table, $where, $fields)
    {
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";

            if ($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=', '<>');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            $fields[] = $value;

            if (in_array($operator, $operators)) {
                $sql = "UPDATE {$table} SET {$set} WHERE {$field} {$operator} ?";
                if (!$this->createQuery($sql, $fields)->error()) {
                    return true;
                }

                return false;

            }
        }
        return false;
    }

    public function insert($table, $fields = array())
    {
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach ($fields as $field) {
            $values .= '?';
            if ($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }
        $sql = "INSERT INTO {$table} (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

        return (!$this->createQuery($sql, $fields)->error());
    }

    public function alterTable($table, $column, $attributes)
    {
        $sql = "ALTER TABLE `{$table}` ADD {$column} {$attributes}";

        if (!$this->createQuery($sql)->error()) {
            return $this;
        }
        return false;
    }

    public function error()
    {
        return $this->_error;
    }

    public function getLastId(): string
    {
        return $this->_pdo->lastInsertId();
    }

    public function getFirst()
    {
        if ($this->_results) {
            return $this->_results[0];
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getResults()
    {
        return $this->_results;
    }

    public function count()
    {
        return $this->_count;
    }


}
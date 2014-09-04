<?php

/**
 * Class DBO
 *
 * @author John L. Diaz.
 * @version 1.0.1
 * @created 31/01/2014
 */
class Database extends PDO {

    /**
     * @var string
     */
    private $_engine = 'mysql';

    /**
     * @var int
     */
    private $_port = 3306;

    /**
     * @var string
     */
    private $_server = '';

    /**
     * @var string
     */
    private $_user = '';

    /**
     * @var string
     */
    private $_password = '';

    /**
     * @var string
     */
    private $_database = '';

    /**
     * @var null
     */
    private $_rowCount = null;

    /**
     * @var
     */
    private $_dns;

    /**
     * @var array
     */
    private $_results;

    /**
     * @var object
     */
    private $_sth;

    /**
     * @var string
     */
    private $_errdesc = '';

    /**
     * @var bool
     */
    private $_showErrors = true;

    /**
     * @var bool
     */
    private $_throwErrors = false;

    /**
     * @var bool
     */
    public $constants = false;

    /**
     * flags for fetchAll in query method
     * http://php.net//manual/es/pdostatement.fetchall.php
     * @var int
     */
    public $fetchFlags = PDO::FETCH_ASSOC;

    public function __construct(stdClass $config) {
        try {

            $vars = get_object_vars($config);
            foreach ($vars as $key => $value) {
                if (isset($this->{$key})) {
                    $this->{$key} = $config->{$key};
                }
            }
            if (!empty($this->_database)) {
                $this->_dns = $this->_engine . ':host=' . $this->_server . ';port=' . $this->_port . ';dbname=' . $this->_database . ';';
                parent::__construct(
                        $this->_dns, $this->_user, $this->_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
                );
            }

            if ($this->_showErrors) {
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Error Handling
            }
        } catch (PDOException $e) {
            $message = 'The connection could not be established.<br />' . $e->getMessage() . '<br />' . strval(
                            $e->getCode()
                    ) . '<br />' . $e->getFile() . '<br />'; //.
            $message .= $e->getTrace() . '<br />' . strval($e->getLine()) . '<br />' . $e->getPrevious();
            $this->_errdesc = $message;
        }
    }

    /**
     * Returns PDO constant
     *
     * @param $type
     * @return int
     */
    private function getConstant($type) {
        switch ($type) {
            case "'%d'":
                return PDO::PARAM_INT;
            case "'%b'":
                return PDO::PARAM_BOOL;
            default:
                return PDO::PARAM_STR;
        }
    }

    /**
     * Get type of PDO params based in the string array
     *
     * @param $types
     * @return array
     */
    private function getTypes($types) {
        if (!is_array($types)) {
            return $types;
        }

        return array_map(
                function ($type) {
            return $this->getConstant($type);
        }, $types
        );
    }

    /**
     * Prepares the query for mysql use, it takes '%d', '%s', '%b' and parses its values to PDO::PARAM_...
     * the query must not contain mixed params, ? and '%d', they must be all ? or all typed params.
     *
     * @param $query
     * @param $args
     * @return array|bool
     */
    public function prepareQuery($query, $args) {
        $pattern = "/'%d'|'%s'|'%b'/m";
        //Unset query string from argument array
        unset($args[0]);
        $args = array_values($args);

        preg_match_all($pattern, $query, $getTypes);

        if (isset($getTypes[0]) && count($getTypes[0]) > 0) {
            if (count($getTypes[0]) !== count($args)) {
                $this->_errdesc = 'Params must be the same number as the query attributes and anonymous params cannot be combined with named params';
                return false;
            }

            $types = $this->getTypes($getTypes[0]);
            $query = preg_replace($pattern, '?', $query);
        }

        $this->_sth = $this->prepare($query);

        foreach ($args as $key => $value) {

            if (is_array($this->constants)) {
                $this->prepareStatement($key, $value, $args);
            } else {
                if (isset($types)) {
                    $this->_sth->bindValue(($key + 1), $value, $types[$key]);
                } else {
                    $this->_sth->bindValue(($key + 1), $value, PDO::PARAM_STR);
                }
            }
        }

        return $this->_sth;
    }

    /**
     * Executes the query, it receives dinamyc params and parses them against the query, so if a query "SELECT * FROM table_name WHERE id = ?"
     * a param value for ? must be passed, the object accepts plain queries too, example: "SELECT * FROM table_name WHERE id = 1"
     *
     * @param string $query
     * @return array|bool|PDOStatement|string
     * @throws Exception
     */
    public function query($query) {
        $this->_rowCount = 0;
        $this->_results = false;

        if (defined('TABLE_PREFIX')) {
            $query = preg_replace("#{([^}]\S+)}#", TABLE_PREFIX . "$1", $query);
        }

        try {

            $args = func_get_args();

            if (count($args) > 1) {

                $preparedQuery = $this->prepareQuery($query, $args);
                if (!$preparedQuery) {
                    return $preparedQuery;
                }
                $this->_sth->execute();
            } else {
                $this->_sth = parent::query($query);
            }

            //Unset constants if not empty
            $this->constants = false;

            preg_match("/^\s*+(?:select|show)\b.*\s*+$/is", $query, $isSelect);

            if (count($isSelect) > 0 && $this->_sth) {
                $this->_results = $this->_sth->fetchAll($this->fetchFlags);
                $this->_rowCount = count($this->_results);
            } else {
                $this->_results = $this->_sth;
            }
            if ($this->_results) {
                $this->_sth->closeCursor();
            }

            return $this->_results;
        } catch (PDOException $e) {

            $errorMessage = $e->getMessage();

            if ($this->_showErrors) {
                echo '<br />The SQL query, could not be executed: ' . $e->getMessage();
            } else {
                echo 'Error executing query';
            }

            $this->_errdesc = $e->getMessage() . '-';
        }
        if ($this->_throwErrors && isset($errorMessage)) {
            throw new Exception($errorMessage);
        }

        return false;
    }

    /**
     * Returns only the first record of row results, this will clone the query method and return only the first record.
     *
     * @return bool
     */
    public function queryFirst() {
        $args = func_get_args();
        $rows = call_user_func_array(array($this, 'query'), $args);

        if (count($rows) > 0) {
            return $rows[0];
        }
        return false;
    }

    /**
     * Prepares the statement to bind values against the query string
     *
     * @param int $key
     * @param string $value
     * @param array $args
     * @return bool
     */
    private function prepareStatement($key, $value, $args) {
        if ((count($args) - 1) !== count($this->constants)) {
            $this->_sth->bindValue($key, $value);

            return false;
        }

        $constantKey = ($key - 1);

        if (isset($this->constants[$constantKey])) {
            $this->_sth->bindValue($key, $value, $this->constants[$constantKey]);
        }
    }

    /**
     * @return null
     */
    public function getNumRows() {
        return $this->_rowCount;
    }

    /**
     * Just parses table prefix if exists.
     *
     * @param string $query
     * @return int
     */
    public function exec($query) {
        if (defined('TABLE_PREFIX')) {
            $query = preg_replace("#{([^}]\S+)}#", TABLE_PREFIX . "$1", $query);
        }

        return parent::exec($query);
    }

    /**
     * Returns the last occurred error.
     *
     * @return string
     */
    public function getError() {
        return $this->_errdesc;
    }

}

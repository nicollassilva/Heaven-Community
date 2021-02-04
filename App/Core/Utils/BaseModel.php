<?php

namespace App\Core\Utils;

use SimplePHP\Model\SimplePHP;

class BaseModel extends SimplePHP {
    /**
     * @param string $tableName
     * @param string $primaryKey
     */
    public function __construct(String $tableName, String $primaryKey)
    {
        if(empty($tableName) || empty($primaryKey))
            return;

        parent::__construct($tableName, $primaryKey);
    }

    public function antiSqlInjection(Array $words)
    {
        $filters = [
            "SELECT ", "UNION", "DROP", "TABLE", "FROM",
            "WHERE", "GROUP", "BY", "INSERT", "INTO",
            "ALTER", "UPDATE", "DELETE", "REPLACE",
            "RETURN", "DATABASE", "COLUMN", "CREATE",
            "BINARY", "JOIN", "LEFT", "JOIN", "RIGHT",
            "TEXT", "ACTION", "BIT", "TIMESTAMP", "TIME",
            "ENUM", "ZEROFILL", "XOR", "VALUES", "SQL", "SET",
            "SCHEMAS", "REQUIRE", "RESTRICT", "REFERENCES",
            "LIMIT", "OFFSET", "KILL", "LEAVE", "KEYS",
            "INOUT", "INDEX", "EXISTS", "DOUBLE",
            "CONSTRAINT", "CONDITION", "CHECK", "CASCADE",
            "CONTINUE", "DEFAULT", "PRIMARY", "DESC", "PERFORMANCE",
            "SQL_CACHE", "STORAGE", "SQL_THREAD", "TRUNCATE", "VARCHAR",
            "HASH", "ESCAPE", "ESCAPED", "EXECUTE", "QUERY", "PREPARE", "BINDPARAM",
            "%';", "%'", "'%"
        ];

        $response = [];
        foreach($words as $key => $word) {
            $response[$key] = str_replace($filters, '', trim(htmlspecialchars($word)));
        }
        
        return $response;
    }
}
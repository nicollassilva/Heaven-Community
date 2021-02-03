<?php

namespace App\Core\Utils;

class BaseModel {

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
<?php

namespace Mii\Database;

use PDO;
use Illuminate\Support\Collection;

class Builder extends DB
{
    public PDO $pdo;

    protected static string $table = '';

    protected array $fields = [];

    protected array $conditions = [];

    protected array $orderBy = [];

    protected ?int $limit = null;

    protected ?int $offset = null;

    public function __construct()
    {
        $this->pdo = $this->setConnection();
    }

    public static function __callStatic($name, $arguments)
    {
        return match ($name) {
            'table' => self::getTable(table: $arguments[0])
        };
    }

    // Set the table name
    public static function getTable(string $table): Builder
    {
        self::$table = $table;

        return new static;
    }

    // Select specific fields
    public function select(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    // Add a WHERE condition
    public function where(string $field, string $operator, $value): self
    {
        $this->conditions[] = [$field, $operator, $value];

        return $this;
    }

    // Add an ORDER BY clause
    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $this->orderBy[] = [$field, $direction];

        return $this;
    }

    // Set a limit on the number of results
    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    // Set an offset for the results
    public function offset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    // Build and return the SQL query string
    public function toSql(): string
    {
        $sql = 'SELECT ';

        // If fields are specified, join them into the SQL string, otherwise select all
        if (empty($this->fields)) {
            $sql .= '*';
        } else {
            $sql .= implode(', ', $this->fields);
        }

        // Add the table name
        $sql .= ' FROM ' . self::$table;

        // Add WHERE conditions if any
        if (!empty($this->conditions)) {
            $conditionStrings = array_map(fn ($condition) => "$condition[0] $condition[1] ?", $this->conditions);
            $sql .= ' WHERE ' . implode(' AND ', $conditionStrings);
        }

        // Add ORDER BY clause if any
        if (!empty($this->orderBy)) {
            $orderByStrings = array_map(fn ($order) => "$order[0] $order[1]", $this->orderBy);
            $sql .= ' ORDER BY ' . implode(', ', $orderByStrings);
        }

        // Add LIMIT clause if set
        if ($this->limit !== null) {
            $sql .= ' LIMIT ' . $this->limit;
        }

        // Add OFFSET clause if set
        if ($this->offset !== null) {
            $sql .= ' OFFSET ' . $this->offset;
        }

        return $sql;
    }

    // Execute the built SQL query
    public function get(): Collection
    {
        $stmt = $this->pdo->prepare($this->toSql());

        // Bind parameters for WHERE conditions
        foreach ($this->conditions as $index => $condition) {
            $stmt->bindValue($index + 1, $condition[2]);
        }

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return collect($data);
    }
}

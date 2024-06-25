<?php

$host = "localhost";
$database = "sem";
$username = "root";
$password = "";
$connection;

try {
    $connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function create($tableName, $data) // create c
{
    global $connection;

    try {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $stmt = $connection->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        // sql injection //pdo
        $stmt->execute();
        echo "Record created successfully";
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function read($tableName, $condition = '') // read R
{
    global $connection;

    try {
        $sql = "SELECT * FROM $tableName $condition";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}
function readUserById($user_id)
{
    global $connection;

    try {
        $sql = "SELECT * FROM users where id = $user_id";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}
function sql($query) // read R
{
    global $connection;

    try {
        $sql = $query;
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function readAll($tableName, $condition = '') // read R
{
    global $connection;

    try {
        $sql = "SELECT * FROM $tableName $condition";
        $stmt = $connection->prepare($sql);
        // var_dump($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function update($tableName, $data, $condition) //update U
{
    global $connection;

    try {
        $setClause = implode("=?, ", array_keys($data)) . "=?";
        $sql = "UPDATE $tableName SET $setClause $condition";
        $stmt = $connection->prepare($sql);
        $i = 1;
        foreach ($data as $value) {
            $stmt->bindValue($i++, $value);
        }
        $stmt->execute();
        return true; // Changed to true
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}




function delete($tableName, $condition) // Delete D
{
    global $connection;

    try {
        $sql = "DELETE FROM $tableName $condition";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// helper function 
function truncateText($text, $maxLength)
{
    // Check if the length of the text is greater than the maximum length
    if (strlen($text) > $maxLength) {
        // Truncate the text to the specified length and append an ellipsis
        $truncatedText = substr($text, 0, $maxLength) . '...';
        return $truncatedText;
    } else {
        // If the text is already within the limit, return it as is
        return $text;
    }
}

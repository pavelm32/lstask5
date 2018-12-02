<?php

function getConnection()
{
    try {
        $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        return $dbh;
    } catch (PDOException $e) {

        return false;
    }
}

/**
 * @param $db PDO
 * @param $user_id
 * @param $street
 * @param $home
 * @param $part
 * @param $appt
 * @param $floor
 * @param $comment
 * @param $payment
 * @param $callback
 * @return mixed
 */
function addOrder($db, $user_id, $street, $home, $part, $appt, $floor, $comment, $payment, $callback)
{
    $insert = $db->prepare('INSERT INTO orders (user_id, street, home, part, appt, floor, comments, payment, callback)'.
    'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $insert->execute([$user_id, $street, $home, $part, $appt, $floor, $comment, $payment, $callback]);

    if (!$insert->rowCount()) {
        return false;
    }

    return $db->lastInsertId();
}

function getOrderByUserId($db, $user_id) {
    $result = $db->prepare('SELECT COUNT(*) as count_order FROM orders WHERE user_id = :user');
    $result->execute([':user' => $user_id]);

    $orders = $result->fetch(PDO::FETCH_ASSOC);

    return $orders['count_order'];
}

/**
 * @param $db PDO
 * @return mixed
 */
function getOrders($db) {
    $result = $db->prepare('SELECT * FROM orders');
    $result->execute();

    $orders = $result->fetchAll(PDO::FETCH_ASSOC);

    return $orders;
}

/**
 * @param $db PDO
 * @return mixed
 */
function getUsers($db) {
    $result = $db->prepare('SELECT * FROM users');
    $result->execute();

    $users = $result->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

/**
 * @param $db PDO
 * @param $name
 * @param $email
 * @param $phone
 * @return bool
 */
function addUser($db, $name, $email, $phone)
{
    $result = $db->prepare('SELECT id FROM users WHERE email = :email');
    $result->execute([':email' => $email]);
    //$result->execute([':email' => $email]);
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if ($result->rowCount()) {
        return $user['id'];
    } else {
        $insert = $db->prepare('INSERT INTO users (name, email, phone) VALUES (?, ?, ?)');
        $insert->execute([$name, $email, $phone]);

        if (!$insert->rowCount()) {
            return false;
        }

        return $db->lastInsertId();
    }
}

function checkout($db, $params)
{
    $user_id = addUser($db, $params['name'], $params['email'], $params['phone']);

    if (!$user_id) {
        return false;
    }

    $order_id = addOrder($db, $user_id, $params['street'], $params['home'], $params['part'],
        $params['appt'], $params['floor'], $params['comment'], $params['payment'], $params['callback']);

    if (!$order_id) {
        return false;
    }

    $count_orders = getOrderByUserId($db, $user_id);

    return ['order_id' => $order_id, 'count' => $count_orders];
}
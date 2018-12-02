<?php
require_once('../config.php');
require_once('../model.php');

if (($pdo = getConnection()) === false) {
    echo 'Ошибка подключения к базе данных';
}

$users = getUsers($pdo);
$orders = getOrders($pdo);

?>

<p>Список зарегистрированных пользователей</p>

<table border="1">
    <tr><td>Номер счета</td><td>Имя</td><td>Емейл</td><td>Телефон</td></tr>
    <?php
    if (!empty($users)) {
        foreach ($users as $user) {
            ?><tr>
                <td><?=$user['id']?></td>
                <td><?=$user['name']?></td>
                <td><?=$user['email']?></td>
                <td><?=$user['phone']?></td>
            </tr><?php
        }
    }
    ?>
</table>
<p>Список заказов</p>

<table border="1">
    <tr><td>Номер заказа</td><td>Номер счета пользователя</td><td>Адрес</td><td>Оплата</td>
        <td>Перезвонить?</td><td>Комментарий</td></tr>
    <?php
    if (!empty($orders)) {
        foreach ($orders as $order) {
            ?><tr>
            <td><?=$order['id']?></td>
            <td><?=$order['user_id']?></td>
            <td>ул.<?=$order['street']?>, кор.<?=($order['part'] ?: '-')?>,
                кв.<?=$order['appt']?>, эт.<?=($order['floor'] ?: '-')?></td>
            <td><?=($order['payment'] == 'card' ? 'картой' : 'наличными')?></td>
            <td><?=($order['callback'] == 'yes' ? 'да' : 'нет')?></td>
            <td><?=$order['comments']?></td>
            </tr><?php
        }
    }
    ?>
</table>

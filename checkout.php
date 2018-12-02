<?php
require_once('config.php');
require_once('model.php');
require_once('vendor/autoload.php');


$twig = new Twig_Environment(new \Twig_Loader_Filesystem(getcwd().'/templates/'));

header("Content-type: application/json; charset=utf-8");

$errors = [];
if (($pdo = getConnection()) === false) {
    $errors[] = 'ошибка подключение к базе данных';
}

// получаем данные

$params['name'] = $_POST['name'] ?? '';
$params['phone'] = $_POST['phone'] ?? '';
$params['email'] = $_POST['email'] ?? '';

$params['street'] = $_POST['street'] ?? '';
$params['home'] = $_POST['home'] ?? '';
$params['part'] = $_POST['part'] ?: 0;
$params['floor'] = $_POST['floor'] ?: 0;
$params['appt'] = $_POST['appt'] ?? '';
$params['comment'] = $_POST['comment'] ?? '';

$params['payment'] = $_POST['payment'] ?: 'card';
$params['callback'] = $_POST['callback'] ?: 'yes';

if (!$params['name'] || !$params['phone'] || !$params['email'] || !$params['street'] || !$params['home'] || !$params['appt']) {
    $errors[] = 'заполнены не все данные';
}

if (!empty($errors)) {
    echo json_encode(['status' => false, 'errors' => $errors]);
    exit;
}

if (($order = checkout($pdo, $params)) !== false) {

    $mail = $twig->render('mail.twig', ['order' => $order, 'params' => $params]);

    $transport = (new Swift_SmtpTransport('smtp.yandex.ru', 465, 'ssl'))
        ->setUsername('test@yandex.ru')
        ->setPassword('qwerty');

    $mailer = new Swift_Mailer($transport);
    $message = (new Swift_Message('Заказ №' . $order['order_id']))
        ->setFrom(['test@yandex.ru' => 'Pavel M'])
        ->setTo(['test@yandex.ru' => 'name'])
        ->setBody($mail,'text/html');
    try {
        $result = $mailer->send($message);
    } catch (Exception $e) {
        echo json_encode(
            [
                'status' => true,
                'errors' => '',
                'order' => 'Заказ ' . $order['order_id'] . ' успешно создан, но возникли трудности с отправкой письма' .
                    $e->getMessage()
            ]
        );
        exit;
    }
    //print_r($result);
//    $mail = "Заказ № {$order['order_id']}" . PHP_EOL . "Ваш заказ будет доставлен по адресу:"
//        . " ул.{$params['street']}, д.{$params['home']}, " . ($params['part'] ? 'кор.' . $params['part'] . ', ' : '')
//        . "кв.{$params['appt']}" . ($params['floor'] ? ', эт.' . $params['floor'] : '') . PHP_EOL . PHP_EOL
//        . ($params['comment'] ? 'Комментарий: ' . $params['comment'] : '') . PHP_EOL
//        . "Оплата: " . ($params['payment'] == 'card' ? 'Картой' : 'Наличными') . PHP_EOL
//        . ($params['callback'] == 'yes' ? 'Я хочу чтобы мне перезвонили' : 'Не нужно мне перезванивать') . PHP_EOL
//        . "Вы заказали DarkBeefBurger за 500 рублей, 1 шт" . PHP_EOL . PHP_EOL
//        . ($order['count'] == 1 ? "Спасибо - это ваш первый заказ" : "Спасибо! Это уже {$order['count']} заказ");

    $directories = 'orders/orders_' . date('d_m_Y');
    if (!is_dir($directories)) {
        mkdir($directories);
    }
    $filename = $directories . '/order_from_' . date('H_i_s') . '.txt';
    if (!file_put_contents($filename, $mail)) {
        echo json_encode(
            [
                'status' => true,
                'errors' => '',
                'order' => 'Заказ ' . $order['order_id'] . ' успешно создан, но необходимо обратится в поддержку для подтверждения'
            ]
        );
        exit;
    }

    echo json_encode(['status' => true, 'errors' => '', 'order' => 'Заказ ' . $order['order_id'] . ' успешно создан']);
    exit;
} else {
    echo json_encode(['status' => false, 'errors' => ['Не удалось оформить заказ']]);
    exit;
}
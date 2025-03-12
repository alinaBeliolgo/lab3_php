<?php

declare(strict_types=1);

// require_once 'functions.php';


$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Payment for groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2024-02-15",
        "amount" => 115.50,
        "description" => "Dinner with friends",
        "merchant" => "Andys Pizza",
    ],

    [
        "id" => 3,
        "date" => "2025-01-01",
        "amount" => 8000.00,
        "description" => "Payment for electronics",
        "merchant" => "Phone shop",
    ],
    [
        "id" => 4,
        "date" => "2025-03-03",
        "amount" => 45000.55,
        "description" => "Kitchen set",
        "merchant" => "Furniture Shop",
    ],
];


/**
 * Добавляет новую транзакцию в список.
 *
 * @param int $id ID новой транзакции
 * @param string $date Дата в формате YYYY-MM-DD
 * @param float $amount Сумма транзакции
 * @param string $description Краткое описание
 * @param string $merchant Получатель (компанияи тд)
 * @return void
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant) : void {
    global $transactions;

    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant
    ];

}
//добавление новых транзакций
addTransaction(5, "2022-05-05", 2000.00, "Ferrari", "Ferrari Corp");
addTransaction(6, "2023-05-05", 2000.00, "Ferrari", "Ferrari Corp");



/**
 * Считает общую сумму всех транзакций
 *
 * @param array $transactions Список всех транзакций
 * @return float Сумма
 */
function calculateTotalAmount(array $transactions): float {
    $sum = 0;
    foreach ($transactions as $transaction){
        $sum += $transaction['amount'];
    }
    return $sum;
}



/**
 * Возвращает сколько дней прошло с даты транзакции
 *
 * @param string $date Дата транзакции
 * @return int Колво дней
 */
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $currentDate = new DateTime();
    $interval = $currentDate->diff($transactionDate);
    return $interval->days;
}



/**
 * Ищет транзакции по части описания
 *
 * @param string $descriptionPart название которое ищем
 * @return array найденные транзакции
 */
function findTransactionByDescription(string $descriptionPart) {
    global $transactions;
    return array_filter($transactions, function($transaction) use ($descriptionPart) {
        return strpos($transaction["description"], $descriptionPart) !== false;
    });
}

print_r(findTransactionByDescription("Ferrari"));



/**
 * Ищет транзакцию по ID
 *
 * @param int $id ID транзакции
 * @return array|null Найденная транзакция или null
 */
function findTransactionById(int $id){
    global $transactions;
    $result = array_filter($transactions, function($transaction) use ($id) {
    return $transaction["id"] === $id;
});
return $result ? reset($result) : null;
}

print_r(findTransactionById(5));




/**
 * Сортирует транзакции по дате (от ранних к поздним).
 *
 * @return void
 */
function sortTransactionsByDate() {
    global $transactions;
    usort($transactions, function($a, $b) {
        $dateA = new DateTime($a['date']);
        $dateB = new DateTime($b['date']);
        return $dateA <=> $dateB;
    });
}




/**
 * Сортирует транзакции по сумме (от больших к меньшим).
 *
 * @return void
 */
function sortTransactionsByAmount() {
    global $transactions;
    usort($transactions, function($a, $b) {
        return $b['amount'] <=> $a['amount'];
    });
}

//это для проверки сортировки
//sortTransactionsByDate();
//sortTransactionsByAmount();
echo "<pre>";
print_r($transactions);
echo "</pre>";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Список транзакций</title>
</head>
<body>

<table border='1'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Описание</th>
            <th>Получатель</th>
            <th>Дней с момента</th>
            <th>Сумма общих трат</th>
        </tr>
    </thead>
    <tbody>
        
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= $transaction['id'] ?></td>
                <td><?= $transaction['date'] ?></td>
                <td>$<?= $transaction['amount'] ?></td>
                <td><?= $transaction['description'] ?></td>
                <td><?= $transaction['merchant'] ?></td>
                <td><?= daysSinceTransaction($transaction['date'])?></td>
                <td>$<?= calculateTotalAmount($transactions) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>

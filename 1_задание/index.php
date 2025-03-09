<?php

declare(strict_types=1);

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

//эт функция для подсчета общей суммы для транзакций
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction){
        $total += $transaction['amount'];
    }
    return $total;
}



//функция для поиска транзакции по описанию с использованием array_filter
function findTransactionByDescription(string $descriptionPart) {
    global $transactions;
    return array_filter($transactions, function($transaction) use ($descriptionPart) {
        return strpos($transaction["description"], $descriptionPart) !== false;
    });
}

/*
function findTransactionById(int $id) {
    global $transactions;
    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            return $transaction;
        }
    }
    return null;
}
*/

//функция для поиска транзакции по айди c array_filter
function findTransactionById(int $id){
    global $transactions;
    $result = array_filter($transactions, function($transaction) use ($id) {
    return $transaction["id"] === $id;
});
return $result ? reset($result) : null;
}



//функция для количества дней с момента транзакции
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $currentDate = new DateTime();
    $interval = $currentDate->diff($transactionDate);
    return $interval->days;
}


// Функция для добавления новой транзакции
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;
    
    $newTransaction = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
    
    $transactions[] = $newTransaction;
}
//
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = count($transactions) + 1;
    $date = $_POST['date'] ?? '';
    $amount = isset($_POST['amount']) ? (float) $_POST['amount'] : 0;
    $description = $_POST['description'] ?? '';
    $merchant = $_POST['merchant'] ?? '';
    
    if ($date && $amount > 0 && $description && $merchant) {
        addTransaction($id, $date, $amount, $description, $merchant);
    }
}



//функция для сортировки транзакций по дате (по возрастанию)
function sortTransactionsByDate() {
    global $transactions;
    usort($transactions, function($a, $b) {
        $dateA = new DateTime($a['date']);
        $dateB = new DateTime($b['date']);
        return $dateA <=> $dateB;
    });
}



//функция для сортировки транзакций по сумме (по убыванию)
function sortTransactionsByAmount() {
    global $transactions;
    usort($transactions, function($a, $b) {
        return $b['amount'] <=> $a['amount'];
    });
}

//условие для функции сортировки 
if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == 'date') {
        sortTransactionsByDate(); 
    } elseif ($_GET['sort_by'] == 'amount') {
        sortTransactionsByAmount(); 
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Список транзакций</title>
</head>
<body>
<!--это ссылки как кнопки для сортировки функций по убыванию и по возрастанию -->
<div>
    <a href="?sort_by=date">Сортировать по дате</a>
    <a href="?sort_by=amount">Сортировать по сумме (по убыванию)</a>
</div>

<!--это для для реализации функции добавления транзакции-->
<form method="POST">
        <label>Дата: <input type="date" name="date" required></label><br>
        <label>Сумма: <input type="number" name="amount"  required></label><br>
        <label>Описание: <input type="text" name="description" required></label><br>
        <label>Получатель: <input type="text" name="merchant" required></label><br>
        <button type="submit">Добавить транзакцию</button>
    </form>




<table border='1'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Описание</th>
            <th>Получатель</th>
            <th>Сумма общих трат</th>
            <th>Дней с момента</th>
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
                <td>$<?= calculateTotalAmount($transactions) ?></td>
                <td><?= daysSinceTransaction($transaction['date'])?></td>
                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

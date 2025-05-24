<?php

define('MENU_EXIT', '0');
define('MENU_SELECT_PRODUCTS', '1');
define('MENU_GET_BILL', '2');
define('MENU_SETUP_PROFILE', '3');

define('MIN_AGE', 7);
define('MAX_AGE', 150);
define('MAX_PRODUCT_QUANTITY', 99);

define('STORE_TITLE', "################################\n# ПРОДОВОЛЬЧИЙ МАГАЗИН \"ВЕСНА\" #\n################################");

define('ERROR_INVALID_COMMAND', 'ПОМИЛКА! Введіть правильну команду');
define('ERROR_INVALID_PRODUCT', 'ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНИЙ НОМЕР ТОВАРУ');
define('ERROR_INVALID_QUANTITY', 'ПОМИЛКА! Введіть кількість від 0 до 99');
define('ERROR_EMPTY_NAME', 'ПОМИЛКА! Імʼя повинно містити хоча б одну літеру.');
define('ERROR_INVALID_AGE', 'ПОМИЛКА! Вік повинен бути від 7 до 150 років.');
define('ERROR_EMPTY_CART', 'КОШИК ПОРОЖНІЙ.uance Спочатку виберіть товари.');

define('CART_EMPTY', 'КОШИК ПОРОЖНІЙ');
define('REMOVING_FROM_CART', 'ВИДАЛЯЮ З КОШИКА');
define('GOODBYE_MESSAGE', 'Дякуємо за покупки! До побачення!');
define('PROFILE_UPDATED', 'Профіль успішно оновлено!');

require_once 'smp-pzpi-23-5-tkach-leonid-lab2_products.php';

$cart = [];
$profile = [
    "name" => "",
    "age" => 0
];

$mainMenuItems = [
    MENU_SELECT_PRODUCTS => "Вибрати товари",
    MENU_GET_BILL        => "Отримати підсумковий рахунок",
    MENU_SETUP_PROFILE   => "Налаштувати свій профіль",
    MENU_EXIT            => "Вийти з програми"
];

function clearScreen() {
    echo chr(27) . "[2J" . chr(27) . "[;H";
}

function showMainMenu() {
    global $mainMenuItems;

    echo "\n";
    echo STORE_TITLE . "\n";

    if (empty($mainMenuItems) || !is_array($mainMenuItems)) {
        echo "ПОМИЛКА: Пункти головного меню не визначені.\n";
        exit(1);
    }

    foreach ($mainMenuItems as $key => $menuItem) {
        echo "$key $menuItem\n";
    }

    echo "Введіть команду: ";
}

function handleMainMenu() {
    while (true) {
        showMainMenu();
        $command = trim(fgets(STDIN));

        switch ($command) {
            case MENU_EXIT:
                echo GOODBYE_MESSAGE . "\n";
                exit(0);
            case MENU_SELECT_PRODUCTS:
                selectProducts();
                break;
            case MENU_GET_BILL:
                showFinalBill();
                break;
            case MENU_SETUP_PROFILE:
                setupProfile();
                break;
            default:
                echo ERROR_INVALID_COMMAND . "\n";
                break;
        }
    }
}

function showProductList() {
    global $products;

    if (empty($products) || !is_array($products)) {
        echo "ПОМИЛКА: Список товарів не завантажено (перевірте smp-pzpi-23-5-tkach-leonid-lab2_products.php).\n";
        echo "Натисніть Enter для повернення...";
        fgets(STDIN);
        return;
    }

    echo "\n";
    echo "№  НАЗВА                 ЦІНА\n";
    foreach ($products as $id => $product) {
        if (!isset($product["name"]) || !isset($product["price"])) {
            echo "ПОМИЛКА: Некоректний формат товару ID $id в smp-pzpi-23-5-tkach-leonid-lab2_products.php.\n";
            continue;
        }
        $name = $product["name"];
        $price = $product["price"];
        
        preg_match_all('/./us', (string)$name, $matches);
        $nameLength = count($matches[0]);
        
        $paddingSize = max(22 - $nameLength, 0);
        $padding = str_repeat(" ", $paddingSize);
        
        printf("%-2d %s%s %s\n", $id, $name, $padding, $price);
    }
    echo "   -----------\n";
    echo MENU_EXIT . "  ПОВЕРНУТИСЯ\n";
    echo "Виберіть товар: ";
}

function showCart() {
    global $cart, $products;

    if (empty($cart)) {
        echo CART_EMPTY . "\n";
        return;
    }

    if (empty($products) || !is_array($products)) {
        echo "ПОМИЛКА: Список товарів не завантажено для відображення кошика (перевірте smp-pzpi-23-5-tkach-leonid-lab2_products.php).\n";
        return;
    }

    echo "У КОШИКУ:\n";
    echo "НАЗВА                  КІЛЬКІСТЬ\n";
    foreach ($cart as $productId => $quantity) {
        if (!isset($products[$productId]) || !isset($products[$productId]["name"])) {
             echo "ПОМИЛКА: Товар з ID $productId не знайдено в списку товарів (перевірте smp-pzpi-23-5-tkach-leonid-lab2_products.php).\n";
             continue;
        }
        $name = $products[$productId]["name"];
        preg_match_all('/./us', (string)$name, $matches);
        $nameLength = count($matches[0]);

        $paddingSize = max(22 - $nameLength, 0);
        $padding = str_repeat(" ", $paddingSize);

        printf("%s%s %-4d\n", $name, $padding, $quantity);
    }
}

function selectProducts() {
    global $products, $cart;

    while (true) {
        clearScreen();
        showCart();
        echo "\n";
        showProductList();
        
        $productIdInput = trim(fgets(STDIN));

        if ($productIdInput === MENU_EXIT) {
            return;
        }

        if (!is_numeric($productIdInput) || !isset($products[(int)$productIdInput])) {
            echo ERROR_INVALID_PRODUCT . "\n";
            echo "Натисніть Enter для продовження...";
            fgets(STDIN);
            continue;
        }
        $productId = (int)$productIdInput;

        $product = $products[$productId];
        echo "Вибрано: " . $product["name"] . "\n";
        echo "Введіть кількість (0 для видалення), штук: ";

        $quantityInput = trim(fgets(STDIN));
        if (!is_numeric($quantityInput)){
            echo ERROR_INVALID_QUANTITY . "\n";
            echo "Натисніть Enter для продовження...";
            fgets(STDIN);
            continue;
        }
        $quantity = (int)$quantityInput;

        if ($quantity < 0 || $quantity > MAX_PRODUCT_QUANTITY) {
            echo ERROR_INVALID_QUANTITY . "\n";
            echo "Натисніть Enter для продовження...";
            fgets(STDIN);
            continue;
        }

        if ($quantity === 0) {
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                echo REMOVING_FROM_CART . "\n";
            }
        } else {
            $cart[$productId] = $quantity;
        }
    }
}

function showFinalBill() {
    global $products, $cart;

    clearScreen();
    if (empty($cart)) {
        echo ERROR_EMPTY_CART . "\n";
        echo "Натисніть Enter для повернення в меню...";
        fgets(STDIN);
        return;
    }
    
    if (empty($products) || !is_array($products)) {
        echo "ПОМИЛКА: Список товарів не завантажено для розрахунку (перевірте smp-pzpi-23-5-tkach-leonid-lab2_products.php).\n";
        echo "Натисніть Enter для повернення...";
        fgets(STDIN);
        return;
    }

    echo "\n";
    echo "№  НАЗВА                  ЦІНА  КІЛ-СТЬ  ВАРТІСТЬ\n";

    $total = 0;
    $index = 1;

    foreach ($cart as $productId => $quantity) {
        if (!isset($products[$productId]) || !isset($products[$productId]["name"]) || !isset($products[$productId]["price"])) {
             echo "ПОМИЛКА: Дані для товару з ID $productId неповні або відсутні (перевірте smp-pzpi-23-5-tkach-leonid-lab2_products.php).\n";
             continue;
        }
        $product = $products[$productId];
        $cost = $product["price"] * $quantity;
        $total += $cost;

        $name = $product["name"];
        preg_match_all('/./us', (string)$name, $matches);
        $nameLength = count($matches[0]);

        $paddingSize = max(22 - $nameLength, 0);
        $padding = str_repeat(" ", $paddingSize);
        
        $nameStr = $name . $padding;

        printf("%-2d %s %-5s %-8d %-s\n",
            $index++,
            $nameStr,
            $product["price"],
            $quantity,
            $cost
        );
    }

    echo "\nРАЗОМ ДО CПЛАТИ: $total\n\n";
    echo "Натисніть Enter для повернення в меню...";
    fgets(STDIN);
}

function setupProfile() {
    global $profile;
    clearScreen();

    $validName = false;
    while (!$validName) {
        echo "Ваше імʼя (поточне: " . ($profile["name"] ?: "не вказано") . "): ";
        $name = trim(fgets(STDIN));

        if (empty($name)) {
            if (!empty($profile["name"])) {
                 $validName = true;
                 continue;
            } else {
                 echo ERROR_EMPTY_NAME . "\n";
                 continue;
            }
        }

        if (!preg_match('/[a-zA-Zа-яА-ЯіІїЇєЄґҐ]/u', $name)) {
            echo ERROR_EMPTY_NAME . "\n";
            continue;
        }

        $profile["name"] = $name;
        $validName = true;
    }

    $validAge = false;
    while (!$validAge) {
        echo "Ваш вік (поточний: " . ($profile["age"] > 0 ? $profile["age"] : "не вказано") . "): ";
        $ageInput = trim(fgets(STDIN));

        if (empty($ageInput)) {
            if ($profile["age"] > 0) {
                $validAge = true;
                continue;
            } else {
                 echo "Будь ласка, введіть ваш вік.\n";
                 continue;
            }
        }
        
        if (!is_numeric($ageInput)) {
            echo ERROR_INVALID_AGE . "\n";
            continue;
        }
        $age = (int)$ageInput;

        if ($age < MIN_AGE || $age > MAX_AGE) {
            echo ERROR_INVALID_AGE . "\n";
            continue;
        }

        $profile["age"] = $age;
        $validAge = true;
    }

    echo PROFILE_UPDATED . "\n";
    echo "Імʼя: " . $profile["name"] . "\n";
    echo "Вік: " . $profile["age"] . "\n\n";
    echo "Натисніть Enter для повернення в меню...";
    fgets(STDIN);
}

if (!isset($products)) {
    echo "ПОМИЛКА: Не вдалося завантажити дані про товари з smp-pzpi-23-5-tkach-leonid-lab2_products.php. Роботу програми припинено.\n";
    exit(1);
}
if (!isset($mainMenuItems)) {
    echo "ПОМИЛКА: Не визначено пункти головного меню. Роботу програми припинено.\n";
    exit(1);
}

clearScreen();
handleMainMenu();

?>
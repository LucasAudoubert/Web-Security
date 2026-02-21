<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style/cart.css">
    <title>Your Cart</title>
</head>
<body>

<div class="cart-page">

<a href="../index.php">Home page</a>

    <h1>Your Orders</h1>

    <?php
    require_once __DIR__ . '/../controller/cart/cart.php';
    $currentOrder = null;
    $orderTotal = 0;
    ?>

    <?php if (!empty($cartItems)): ?>

        <?php foreach ($cartItems as $item): ?>

            <?php if ($currentOrder !== $item['order_id']): ?>

                <?php if ($currentOrder !== null): ?>
                    <div class="cart-item">
                        <p class="total-price">Total Order Price: <?= number_format($orderTotal, 2) ?> €</p>
                    </div>
                    <hr>
                <?php endif; ?>

                <?php
                $currentOrder = $item['order_id'];
                $orderTotal = 0;
                ?>

                <div class="cart-item">
                    <div class="order-header">
                        <h3>Order #<?= htmlspecialchars($item['order_id']) ?></h3>
                        <p>Status: <?= htmlspecialchars($item['order_status']) ?></p>
                    </div>
                </div>

            <?php endif; ?>

            <?php
            $plantTotal = $item['price_at_purchase'] * $item['quantity'];
            $orderTotal += $plantTotal;
            ?>

            <div class="cart-item">
                <p>
                    <?= htmlspecialchars($item['plant_name']) ?> — 
                    <?= $item['quantity'] ?> × <?= number_format($item['price_at_purchase'], 2) ?> € 
                    = <?= number_format($plantTotal, 2) ?> €
                </p>
                <form class="remove-form" action="" method="post">
                    <input type="hidden" name="order_id" value="<?= $item['order_id'] ?>">
                    <button type="submit" name="remove_item" value="<?= $item['plant_id'] ?>">Remove</button>
                </form>
            </div>

        <?php endforeach; ?>

        <div class="cart-item">
            <p class="total-price">Total Order Price: <?= number_format($orderTotal, 2) ?> €</p>
        </div>

        <div class="delete-order-form">
            <form action="" method="post">
                <input type="hidden" name="order_id" value="<?= $currentOrder ?>">
                <button type="submit" name="delete_order">Delete Order</button>
            </form>
        </div>

    <?php else: ?>
        <div class="empty-cart">
            <p>Your cart is empty.</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
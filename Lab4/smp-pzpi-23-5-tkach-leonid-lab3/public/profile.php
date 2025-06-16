<?php
require_once __DIR__ . '/../includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
require_once __DIR__ . '/../config/db.php';

$stmt = $pdo->prepare("SELECT username, created_at, avatar, description FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user_info = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user_info) {
    header('Location: /logout.php');
    exit;
}

$avatar_placeholder = 'https://images.unsplash.com/photo-1634986666676-ec8fd927c23d?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
$user_avatar = $user_info['avatar'] ?? $avatar_placeholder;

// Fetch purchase history
$orders_stmt = $pdo->prepare("SELECT id, order_date, total_amount FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$orders_stmt->execute([$_SESSION['user_id']]);
$purchase_history = $orders_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">

    <div class="profile-header">
        <form action="/upload_avatar.php" method="post" enctype="multipart/form-data" class="profile-avatar-form">
            <label for="avatar-upload" class="profile-avatar-wrapper">
                <img src="<?= htmlspecialchars($user_avatar) ?>" alt="<?= t('profile_avatar') ?>" class="profile-avatar">
                <div class="profile-avatar-overlay">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                </div>
            </label>
            <input type="file" name="avatar" id="avatar-upload" accept="image/*" class="profile-avatar-input">
        </form>

        <div class="profile-info">
            <div class="editable-field" id="username-field" style="align-items: center; gap: 0.5rem;">
                <h1 class="profile-username" data-value="<?= htmlspecialchars($user_info['username']) ?>">
                    <?= htmlspecialchars($user_info['username']) ?>
                </h1>
                <button class="edit-btn" type="button" style="margin-top: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                </button>
            </div>
            <p class="profile-reg-date"><?= t('profile_reg_date') ?>: <?= date('d.m.Y', strtotime($user_info['created_at'])) ?></p>

            <div style="display: flex; gap: 1rem;">
                <a href="/logout.php" class="btn" style="width: content;" title="<?= t('logout') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                    <span><?= t('logout') ?></span>
                </a>
                <a href="/change_password.php" class="btn btn--outlin" style="width: content; " title="<?= t('change_password') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                    <span><?= t('change_password') ?></span>
                </a>
            </div>
        </div>
    </div>

    <div class="profile-card">
        <h2 class="profile-card-title"><?= t('description') ?></h2>
        <div class="editable-field" id="description-field">
            <p class="profile-description" data-value="<?= htmlspecialchars($user_info['description'] ?? '') ?>">
                <?= !empty($user_info['description']) ? htmlspecialchars($user_info['description']) : t('no_description') ?>
            </p>
            <button class="edit-btn" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
            </button>
        </div>
    </div>

    <div class="profile-card">
        <h2 class="profile-card-title"><?= t('purchase_history') ?></h2>
        <?php if (empty($purchase_history)): ?>
            <p><?= t('purchase_history_info') ?></p>
        <?php else: ?>
            <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;">Order ID</th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;">Date</th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;">Total</th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchase_history as $order): ?>
                        <tr>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= htmlspecialchars($order['id']) ?></td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= date('d.m.Y H:i', strtotime($order['order_date'])) ?></td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;">$<?= number_format($order['total_amount'], 2) ?></td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;">
                                <button type="button" class="btn btn--small view-order-details" data-order-id="<?= $order['id'] ?>">View Details</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="orderDetailsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
                <div style="background:#fff; padding:20px; border-radius:10px; max-width:600px; width:90%;">
                    <h3>Order Details for Order #<span id="modalOrderId"></span></h3>
                    <div id="modalOrderItems"></div>
                    <button onclick="document.getElementById('orderDetailsModal').style.display='none'">Close</button>
                </div>
            </div>

            <script>
                document.querySelectorAll('.view-order-details').forEach(button => {
                    button.addEventListener('click', function() {
                        const orderId = this.dataset.orderId;
                        document.getElementById('modalOrderId').textContent = orderId;
                        const modalOrderItems = document.getElementById('modalOrderItems');
                        modalOrderItems.innerHTML = '<p>Loading...</p>'; // Show loading

                        // Fetch order items via AJAX
                        fetch(`/fetch_order_details.php?order_id=${orderId}`)
                            .then(response => response.json())
                            .then(data => {
                                modalOrderItems.innerHTML = ''; // Clear loading
                                if (data.length > 0) {
                                    let tableHtml = '<table class="table" style="width:100%;">';
                                    tableHtml += '<thead><tr><th>Product</th><th>Qty</th><th>Price</th></tr></thead><tbody>';
                                    data.forEach(item => {
                                        tableHtml += `<tr><td>${item.product_name}</td><td>${item.quantity}</td><td>$${parseFloat(item.price_at_purchase).toFixed(2)}</td></tr>`;
                                    });
                                    tableHtml += '</tbody></table>';
                                    modalOrderItems.innerHTML = tableHtml;
                                } else {
                                    modalOrderItems.innerHTML = '<p>No items found for this order.</p>';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching order details:', error);
                                modalOrderItems.innerHTML = '<p>Error loading order details.</p>';
                            });

                        document.getElementById('orderDetailsModal').style.display = 'flex';
                    });
                });
            </script>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ... (existing JavaScript from profile.php) ...
    // This part stays the same as in your original file
    const avatarInput = document.getElementById('avatar-upload');
    if (avatarInput) {
        avatarInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file.');
                    this.value = '';
                    return;
                }
                if (file.size > 5 * 1024 * 1024) { // 5MB limit
                    alert('File size must be less than 5MB.');
                    this.value = '';
                    return;
                }
                this.closest('form').submit();
            }
        });
    }

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const fieldContainer = this.closest('.editable-field');
            const displayElement = fieldContainer.querySelector('h1, p');

            if (fieldContainer.querySelector('form')) {
                return;
            }

            const originalValue = displayElement.dataset.value;
            const isUsername = fieldContainer.id === 'username-field';
            const inputType = isUsername ? 'input' : 'textarea';
            const inputName = isUsername ? 'username' : 'description';

            const form = document.createElement('form');
            form.action = '/update_profile.php';
            form.method = 'post';
            form.style.width = '100%';

            const input = document.createElement(inputType);
            input.name = inputName;
            input.className = isUsername ? 'input profile-username-input' : 'textarea';
            input.value = originalValue;

            form.appendChild(input);

            if (isUsername) {
                input.placeholder = 'Username...';
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                    if (e.key === 'Escape') {
                        window.location.reload();
                    }
                });
                input.addEventListener('blur', function() {
                    setTimeout(() => { if (document.body.contains(form)) { window.location.reload(); } }, 200);
                });
            } else {
                input.rows = 4;
                input.placeholder = '<?= t('no_description') ?>';

                const buttonContainer = document.createElement('div');
                buttonContainer.style.marginTop = '12px';
                buttonContainer.style.display = 'flex';
                buttonContainer.style.gap = '8px';

                const saveButton = document.createElement('button');
                saveButton.type = 'submit';
                saveButton.className = "btn btn--outline";
                saveButton.innerText = '<?= t('save') ?>';

                const cancelButton = document.createElement('button');
                cancelButton.type = 'button';
                cancelButton.className = 'btn btn--outline';
                cancelButton.innerText = '<?= t('cancel') ?>';

                buttonContainer.appendChild(saveButton);
                buttonContainer.appendChild(cancelButton);
                form.appendChild(buttonContainer);

                cancelButton.addEventListener('click', function() {
                    window.location.reload();
                });
            }

            fieldContainer.innerHTML = '';
            fieldContainer.appendChild(form);
            input.focus();

            input.selectionStart = input.selectionEnd = input.value.length;
        });
    });
});
</script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
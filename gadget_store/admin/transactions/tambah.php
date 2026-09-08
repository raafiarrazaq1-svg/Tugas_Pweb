<?php

require_once "../../includes/admin_auth.php";
require_once "../../config/database.php";

$customer_query = "SELECT *
                   FROM customers
                   ORDER BY name ASC";

$customer_result = mysqli_query($conn, $customer_query);


$gadget_query = "SELECT
                    gadgets.id,
                    gadgets.name,
                    gadgets.brand,
                    gadgets.price,
                    gadgets.stock,
                    categories.name AS category_name
                 FROM gadgets
                 INNER JOIN categories
                    ON gadgets.category_id = categories.id
                 WHERE gadgets.stock > 0
                 ORDER BY gadgets.name ASC";

$gadget_result = mysqli_query($conn, $gadget_query);

$gadgets = [];

while ($gadget = mysqli_fetch_assoc($gadget_result)) {
    $gadgets[] = $gadget;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Transaksi - Gadget Store</title>

</head>

<body>

    <h1>Tambah Transaksi</h1>

    <form action="proses.php" method="POST">

        <input
            type="hidden"
            name="action"
            value="tambah"
        >

        <div>

            <label>Pelanggan</label>

            <br>

            <select name="customer_id" required>

                <option value="">
                    -- Pilih Pelanggan --
                </option>

                <?php while ($customer = mysqli_fetch_assoc($customer_result)): ?>

                    <option value="<?php echo $customer['id']; ?>">

                        <?php
                        echo htmlspecialchars($customer['name']);
                        ?>

                    </option>

                <?php endwhile; ?>

            </select>

        </div>

        <br>

        <h3>Daftar Gadget</h3>

        <table border="1" cellpadding="10" cellspacing="0">

            <thead>

                <tr>
                    <th>Gadget</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody id="items">

                <tr class="item-row">

                    <td>

                        <select
                            name="gadget_id[]"
                            class="gadget-select"
                            required
                        >

                            <option value="">
                                -- Pilih Gadget --
                            </option>

                            <?php foreach ($gadgets as $gadget): ?>

                                <option
                                    value="<?php echo $gadget['id']; ?>"
                                    data-price="<?php echo $gadget['price']; ?>"
                                    data-stock="<?php echo $gadget['stock']; ?>"
                                >

                                    <?php
                                    echo htmlspecialchars(
                                        $gadget['brand']
                                        . ' - '
                                        . $gadget['name']
                                    );
                                    ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </td>

                    <td class="price">
                        Rp 0
                    </td>

                    <td class="stock">
                        0
                    </td>

                    <td>

                        <input
                            type="number"
                            name="quantity[]"
                            class="quantity"
                            min="1"
                            value="1"
                            required
                        >

                    </td>

                    <td>

                        <button
                            type="button"
                            class="remove-row"
                        >
                            Hapus
                        </button>

                    </td>

                </tr>

            </tbody>

        </table>

        <br>

        <button
            type="button"
            id="add-item"
        >
            Tambah Gadget
        </button>

        <br><br>

        <h3>
            Total:
            <span id="total">Rp 0</span>
        </h3>

        <button type="submit">
            Simpan Transaksi
        </button>

        <a href="index.php">
            Kembali
        </a>

    </form>


<script>

const gadgetOptions = <?php echo json_encode($gadgets); ?>;

const items = document.getElementById('items');

const totalElement = document.getElementById('total');

const addItemButton = document.getElementById('add-item');


function formatRupiah(number) {

    return new Intl.NumberFormat('id-ID').format(number);

}


function createGadgetOptions() {

    let options = `
        <option value="">
            -- Pilih Gadget --
        </option>
    `;

    gadgetOptions.forEach(function(gadget) {

        options += `
            <option
                value="${gadget.id}"
                data-price="${gadget.price}"
                data-stock="${gadget.stock}"
            >
                ${gadget.brand} - ${gadget.name}
            </option>
        `;

    });

    return options;

}


function calculateTotal() {

    let total = 0;

    const rows = document.querySelectorAll('.item-row');

    rows.forEach(function(row) {

        const select = row.querySelector('.gadget-select');

        const quantity = row.querySelector('.quantity');

        if (!select.value) {
            return;
        }

        const selectedOption =
            select.options[select.selectedIndex];

        const price =
            Number(selectedOption.dataset.price);

        const qty =
            Number(quantity.value);

        total += price * qty;

    });

    totalElement.textContent =
        'Rp ' + formatRupiah(total);

}


function updateRow(row) {

    const select =
        row.querySelector('.gadget-select');

    const priceElement =
        row.querySelector('.price');

    const stockElement =
        row.querySelector('.stock');

    const quantity =
        row.querySelector('.quantity');


    if (!select.value) {

        priceElement.textContent = 'Rp 0';

        stockElement.textContent = '0';

        quantity.max = '';

        calculateTotal();

        return;
    }


    const selectedOption =
        select.options[select.selectedIndex];


    const price =
        Number(selectedOption.dataset.price);

    const stock =
        Number(selectedOption.dataset.stock);


    priceElement.textContent =
        'Rp ' + formatRupiah(price);

    stockElement.textContent =
        stock;

    quantity.max = stock;


    if (Number(quantity.value) > stock) {
        quantity.value = stock;
    }


    calculateTotal();

}


function attachRowEvents(row) {

    const select =
        row.querySelector('.gadget-select');

    const quantity =
        row.querySelector('.quantity');

    const removeButton =
        row.querySelector('.remove-row');


    select.addEventListener(
        'change',
        function() {
            updateRow(row);
        }
    );


    quantity.addEventListener(
        'input',
        function() {
            updateRow(row);
        }
    );


    removeButton.addEventListener(
        'click',
        function() {

            const rows =
                document.querySelectorAll('.item-row');

            if (rows.length === 1) {
                return;
            }

            row.remove();

            calculateTotal();

        }
    );

}


attachRowEvents(
    document.querySelector('.item-row')
);


addItemButton.addEventListener(
    'click',
    function() {

        const row =
            document.createElement('tr');

        row.className = 'item-row';

        row.innerHTML = `

            <td>

                <select
                    name="gadget_id[]"
                    class="gadget-select"
                    required
                >

                    ${createGadgetOptions()}

                </select>

            </td>

            <td class="price">
                Rp 0
            </td>

            <td class="stock">
                0
            </td>

            <td>

                <input
                    type="number"
                    name="quantity[]"
                    class="quantity"
                    min="1"
                    value="1"
                    required
                >

            </td>

            <td>

                <button
                    type="button"
                    class="remove-row"
                >
                    Hapus
                </button>

            </td>

        `;

        items.appendChild(row);

        attachRowEvents(row);

    }
);

</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    a:hover {
        color: white;
        text-decoration: none;
    }
    .card{
        width: 22%;
        margin: 10px;
    }
    .container {
        flex-wrap: wrap;

   }
</style>

<body>
    <div class="d-flex justify-content-around m-1">
        <h5 class="m-1">Product List</h5>
        <div>
            <button type="button" class="btn btn-outline-primary" id="delete-product-button">MASS DELETE</button>
            <button type="button" class="btn btn-outline-primary"><a href="/addProduct">ADD</a></button>

        </div>
    </div>
    <hr>
    <div class="d-flex container ">
        <?php foreach ($products ?? [] as $product) { ?>
            <div class="card border border-secondary p-3" style="background-color: #eee;">
                <input type="checkbox" class="delete-checkbox" value=<?= $product['sku'] ?>>
                <p>SKU: <?= $product['sku'] ?></p>
                <p>name: <?= $product['name'] ?></p>
                <p>price: <?= $product['price'] ?></p>
                <p>Attribute: <?= $product['attribute'] ?></p>
            </div>
        <?php } ?>
    </div>

    <form action="/deleteBulkProducts" method="post" id="form">
        <input type="hidden" name="products[]" id="js_input_product_ids">
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {

        $('#delete-product-button').click(function() {
            var checkedValues = [];

            $('.delete-checkbox:checked').each(function() {
                checkedValues.push($(this).val());
                $('#js_input_product_ids').val(checkedValues)

            });

            if (checkedValues.length > 0) {
                console.log('hola');
                $('#form').submit();
            } else {
                alert('No checkboxes are checked.');
            }
        });
    });
</script>

</html>
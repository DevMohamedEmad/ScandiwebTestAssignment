<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        a:hover {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-around m-1">
        <h6 class="m-1">Product Add</h6>
        <div>
            <button type="button" onclick="validateForm()" class="btn btn-outline-primary">Save</button>
            <button type="button" class="btn btn-outline-primary"> <a href="/">Cancel</a></button>
        </div>
    </div>
    <hr>
    <form id="product_form" class="container" method="POST" action="/addproduct">
        <?php foreach ($errors as $error) { ?>
            <div  class="alert alert-danger" role="alert">
                <?= $error  ?>
            </div>
        <?php }?>
        <div id="notification" class="alert alert-danger d-none" role="alert">
        </div>
        <div class="form-group row">
            <label for="sku" class="col-sm-2 col-form-label col-form-label-sm">SKU</label>
            <div class="col-sm-10">
                <input type="string" name="sku" class="form-control form-control-sm" id="sku" placeholder="SKU">
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="string" name="name" class="form-control" id="name" placeholder="Product name">
            </div>
        </div>
        <div class="form-group row">
            <label for="price" class="col-sm-2 col-form-label col-form-label-lg">Price</label>
            <div class="col-sm-10">
                <input type="string" name="price" class="form-control form-control-lg" id="price" placeholder="Price">
            </div>
        </div>
        <div class="form-group row">
            <label for="productType" class="col-sm-2 col-form-label col-form-label-lg">product Type</label>
            <div class="col-sm-10">
                <select id="productType" name="product_type" class="form-control form-control-lg" aria-label="Default select example">
                    <option value selected>Open this select menu</option>
                    <?php foreach ($product_types as $product_type) { ?>
                        <option id=<?= $product_type['name'] ?> value=<?= $product_type['name'] ?>> <?= $product_type['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row" id="productAttributeInput"></div>
        <input type="hidden" id="sku-is-not-exist">
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>

    function validateForm() {

        sku_value = $('#sku').val();
        name_value = $('#name').val();
        price_value = $('#price').val();
        type_value = $('#productType').val();

        if (!sku_value || !name_value || !price_value || !type_value) {
       
            $('#notification').removeClass('d-none');
            $('#notification').text('Please, submit required data');

        } else {

            selectedOptionId = $('#productType').find('option:selected').attr('id');

            if (selectedOptionId == "DVD") {
                attributeFlag = $('#size').val();
            }

            if (selectedOptionId == "Book") {
                attributeFlag = $('#weight').val();
            }

            if (selectedOptionId == "Furniture") {
                attributeFlag = $('#height').val();
                attributeFlag = $('#length').val();
                attributeFlag = $('#width').val();
            }

            if (!attributeFlag) {
                $('#notification').removeClass('d-none');
                $('#notification').text('Please, submit required data');
            } else {
                $('#notification').addClass('d-none');

                checkSkuNotExist(sku_value)
                    .then(function(response) {
                        if (response == true) {
                            $('#product_form').submit();
                        } else {
                            $('#notification').removeClass('d-none');
                            $('#notification').text('Sku is exist already');
                        }
                    })
                    .catch(function(error) {
                        //
                    });
            }

        }
    }

    function checkSkuNotExist(sku) {

        return new Promise(function(resolve, reject) {

            $.ajax({
                data: {
                    sku: sku
                },
                url: '/checkSkuIsExist',
                type: 'POST',
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });

        });
    }

    $(document).ready(function() {

        $('#productType').change(function() {

            var selectedOptionId = $(this).find('option:selected').attr('id');
            var container = $('#productAttributeInput');
            container.empty();

            if (selectedOptionId == "DVD") {

                var label = $('<label>')
                    .addClass('col-sm-2 col-form-label col-form-label-lg')
                    .text('Size (MB)');

                var input = $('<input>')
                    .attr('type', 'text')
                    .attr('id', 'size')
                    .attr('name', 'size')
                    .addClass('form-control form-control-lg');

                var description = $('<p>')
                    .text('*Please provide size in MB*');
                 

                container.append(label);
                container.append(input);
                container.append(description);

            }
            if (selectedOptionId == "Book") {
                var label = $('<label>')
                    .addClass('col-sm-2 col-form-label col-form-label-lg')
                    .text('Weight (KG)');

                var input = $('<input>')
                    .attr('type', 'number')
                    .attr('id', 'weight')
                    .attr('name', 'weight')
                    .addClass('form-control form-control-lg');

                var description = $('<p>')
                    .text('*Please provide Weight in KG*');
                   

                container.append(label);
                container.append(input);
                container.append(description);

            }
            if (selectedOptionId == "Furniture") {

                var label_for_height = $('<label>')
                    .addClass('col-sm-2 col-form-label col-form-label-lg')
                    .text('Height (CM))');

                var input_for_height = $('<input>')
                    .attr('type', 'number')
                    .attr('id', 'height')
                    .attr('name', 'height')
                    .addClass('form-control form-control-lg');

                container.append(label_for_height);
                container.append(input_for_height);

                var label_for_width = $('<label>')
                    .addClass('col-sm-2 col-form-label col-form-label-lg')
                    .text('Width (CM))');

                var input_for_width = $('<input>')
                    .attr('type', 'number')
                    .attr('id', 'width')
                    .attr('name', 'width')
                    .addClass('form-control form-control-lg');

                container.append(label_for_width);
                container.append(input_for_width);

                var label_for_length = $('<label>')
                    .addClass('col-sm-2 col-form-label col-form-label-lg')
                    .text('length (CM))');

                var input_for_length = $('<input>')
                    .attr('type', 'number')
                    .attr('id', 'length')
                    .attr('name', 'length')
                    .addClass('form-control form-control-lg');

                container.append(label_for_length);
                container.append(input_for_length);

                var description = $('<p>')
                    .text('*Please provide dimension in H*W*L format*');     
                container.append(description);   
            }
        });
    });
</script>
</script>

</html>
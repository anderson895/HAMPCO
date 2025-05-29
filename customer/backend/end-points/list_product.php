<h1 class="text-2xl font-semibold mb-6">All Products</h1>

<!-- Search Input -->
<input type="text" id="search" class="w-full p-2 mb-4 border rounded" placeholder="Search Products...">

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="product-grid">
    <?php 
    $fetch_all_product = $db->fetch_all_product();  // Fetch all products

    // Check if the result has rows
    if ($fetch_all_product->num_rows > 0):
        // Fetch all rows as an associative array
        $products = $fetch_all_product->fetch_all(MYSQLI_ASSOC);

        foreach ($products as $product):
            $prod_price = $product['prod_price'];
    ?>
        <!-- Product Card -->
        <div class="bg-white p-4 rounded shadow-lg transition-transform transform hover:scale-105 hover:shadow-2xl product-card" data-category-id="<?=$product['prod_category_id']?>" data-price="<?=$product['prod_currprice']?>">
            <a href="view_product.php?product_id=<?=$product['prod_id']?>">

                <!-- Product Image -->
                <img src="../upload/<?=$product['prod_image']?>" alt="Product Image" class="w-full rounded mb-4 transition-transform hover:scale-105">

                <!-- Product Name -->
                <h2 class="font-semibold text-lg transition-colors hover:text-blue-500 product-name"><?=$product['prod_name']?></h2>

                <!-- Product Description -->
                <p class="text-gray-600 transition-colors hover:text-gray-800"><?= substr($product['prod_description'], 0, 20) . (strlen($product['prod_description']) > 20 ? '...' : '') ?></p>

              
                <p class="text-lg font-bold text-red-600">PHP <?=number_format($product['prod_price'], 2);?></p>
                
            </a>
        </div>

    <?php
        endforeach;
    else:
    ?>
        <p class="text-gray-600 col-span-full text-center">No products found.</p>
    <?php endif; ?>
</div>



<script>
    $(document).ready(function() {
    // Bind the keyup event on the search input field
    $('#search').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase(); // Get the value of the search field

        // Loop through the product cards and show/hide based on the search term
        $('#product-grid .product-card').each(function() {
            var productName = $(this).find('.product-name').text().toLowerCase(); // Get the product name text

            // If the product name contains the search term, show the product card
            if (productName.indexOf(searchTerm) !== -1) {
                $(this).show(); // Show matching product
            } else {
                $(this).hide(); // Hide non-matching product
            }
        });
    });
});

</script>
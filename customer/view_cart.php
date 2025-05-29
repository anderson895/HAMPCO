<?php
include "component/header.php";
$userID = $_SESSION['customer_id'];
?>

<!-- Cart Container -->
<div class="max-w-4xl mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold mb-6 text-gray-800">Your Shopping Cart</h2>

  <!-- Cart items wrapper -->
  <div class="cart-items space-y-6">
    <!-- Cart items will be dynamically loaded here -->
  </div>

  <!-- Summary Section -->
  <div class="mt-8 border-t pt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center">
    <div class="mb-4 sm:mb-0">
      <span class="text-lg font-medium text-gray-700">Total:</span>
      <span class="text-2xl font-extrabold text-gray-900 total-price ml-2">₱ 0.00</span>
    </div>
    <button class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-300 font-semibold shadow-md">
      Proceed to Checkout
    </button>
  </div>
</div>

<script>
$(document).ready(function () {
  $.ajax({
    url: "backend/end-points/get_cart.php",
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      const cartContainer = $('.cart-items');
      let total = 0;

      cartContainer.empty();

      if(data.length === 0){
        cartContainer.append(`
          <p class="text-center text-gray-500">Your cart is currently empty.</p>
        `);
        $('.total-price').text('₱ 0.00');
        return;
      }

      data.forEach(item => {
        const qty = parseInt(item.cart_Qty);
        const price = parseFloat(item.prod_price);
        const itemTotal = qty * price;
        total += itemTotal;

        cartContainer.append(`
          <div class="flex flex-col sm:flex-row sm:items-center justify-between border rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 bg-white">
            <div class="flex items-center gap-4 flex-1">
              <img src="../upload/${item.prod_image}" alt="${item.prod_name}" class="w-24 h-24 rounded-md object-cover border" />
              <div>
                <h3 class="text-lg font-semibold text-gray-800">${item.prod_name}</h3>
                <p class="text-sm text-gray-500 mt-1">${item.prod_description || ''}</p>
              </div>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center gap-6">
              <div class="flex items-center border rounded-md overflow-hidden">
                <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition duration-150">−</button>
                <input type="text" value="${qty}" class="w-12 text-center border-x outline-none bg-gray-50" readonly />
                <button class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition duration-150">+</button>
              </div>
              <div class="text-right min-w-[100px]">
                <p class="text-lg font-bold text-gray-700">₱ ${itemTotal.toLocaleString(undefined, { minimumFractionDigits: 2 })}</p>
              </div>
            </div>
          </div>
        `);
      });

      $('.total-price').text(`₱ ${total.toLocaleString(undefined, { minimumFractionDigits: 2 })}`);
    },
    error: function (xhr, status, error) {
      console.error('AJAX error:', error);
      $('.cart-items').html('<p class="text-red-600 text-center">Failed to load cart items. Please try again.</p>');
    }
  });
});
</script>

<?php include "component/footer.php"; ?>

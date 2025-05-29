


<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Dashboard</h2>
    <div class="w-10 h-10 ">
       
    </div>
</div>

<!-- Dashboard Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
   
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="../assets/image/customer.png" alt="customers icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">Total Customer</h3>
        <p class="text-blue-500 text-2xl font-bold totalUser">0</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="../assets/image/management.png" alt="members icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">Total Member</h3>
        <p class="text-blue-500 text-2xl font-bold totalBranches">0</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
        <img src="../assets/image/products.png" alt="products icon" class="mb-4 w-12 max-w-full" />
        <h3 class="text-gray-700 font-semibold text-lg">Total Products</h3>
        <p class="text-blue-500 text-2xl font-bold numOrders totalProduct">0</p>
    </div>
</div>


<div class="bg-white mt-6 p-6 rounded-lg shadow-md">
    <!-- <h3 class="text-lg font-semibold text-gray-700 mb-4">Sales Overview</h3> -->

    <!-- Sales Filter -->
   
</div>










</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<?php include "components/footer.php";?>
<script src="assets/js/app.js"></script>
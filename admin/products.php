<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Manage Product</h2>
    <div class="w-10 h-10 ">
    </div>
</div>

<button id="AddRawMaterials" class="mb-3 bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition flex items-center gap-2">
        <span class="material-icons">add</span>
        Add Products
    </button>
<!-- Table of members -->
<div class="overflow-x-auto bg-white rounded-md shadow-md p-4">
    <!-- Search bar -->
    <div class="mb-4">
    <input type="text" id="searchInput" placeholder="Search ..." class="w-64 p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
</div>

    <table class="min-w-full table-auto" id="productionTable">
        <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Raw Materials</th>
                <th class="py-3 px-6 text-left">Description</th>
                <th class="py-3 px-6 text-left">Quantity</th>
                <th class="py-3 px-6 text-left">Status</th>
                <th class="py-3 px-6 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
           <?php include "backend/end-points/list_raw_material.php";?>
        </tbody>
    </table>
</div>

<?php include "components/footer.php";?>

<script src="assets/js/app.js"></script>






<!-- Modal -->
<div id="RawMaterialsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Add Raw Materials</h2>
        <form id="AddRawMaterialsForm">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="rm_name" class="w-full border rounded p-2" placeholder="" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Description</label>
                <input type="text" name="rm_description" id="rm_description" class="w-full border rounded p-2" placeholder="" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Quantity</label>
                <input type="text" name="rm_qty" id="rm_qty" class="w-full border rounded p-2" placeholder="" required>
            </div>
           
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="rm_status" id="rm_status" class="w-full border rounded p-2" required>
                    <option value="" disabled selected>Select status</option>
                    <option value="Available">Available</option>
                    <option value="Not Available">Not Available</option>
                </select>
            </div>



            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" id="submitAddRawMaterials" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#AddRawMaterials').on('click', function(){
            $('#RawMaterialsModal').removeClass('hidden');
        });

        $('#closeModal').on('click', function(){
            $('#RawMaterialsModal').addClass('hidden');
        });

        $('#AddRawMaterialsForm').on('submit', function(e){
            e.preventDefault();
           // All validations passed
            var formData = $(this).serializeArray(); 
            formData.push({ name: 'requestType', value: 'AddRawMaterials' });
            var serializedData = $.param(formData);

            $.ajax({
                type: "POST",
                url: "backend/end-points/controller.php",
                data: serializedData,
                dataType: "json", 
                success: function (response) {
                    if (response.status === 'success') {
                        alertify.success(response.message);  
                        setTimeout(function () {
                            window.location.href = "inventory"; 
                        }, 1000);
                    } else {
                        alertify.error(response.message); 
                        $('.spinner').hide();
                    }
                }
            });
        });
    });
</script>








<script>
// jQuery search functionality
$(document).ready(function() {
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#productionTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>

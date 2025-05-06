<?php 
include "components/header.php";
?>


    <!-- Top bar with user profile -->
    <div class="max-w-12xl mx-auto flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
        <h2 class="text-lg font-semibold text-gray-700">Production</h2>
        <div class="w-10 h-10 ">
           
        </div>
    </div>
    <?php 
    if($On_Session[0]['status']==1){ 
    ?>
   







   <button id="createProgressBtn" class="mb-3 bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition flex items-center gap-2">
        <span class="material-icons">add</span>
        Create Progress
    </button>


<!-- Table of members -->
<div class="overflow-x-auto bg-white rounded-md shadow-md p-4">
    <!-- Top bar with button and search -->
    <div class="mb-4 flex justify-between items-center">
        
        <input type="text" id="searchInput" placeholder="Search ..." class="w-64 p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <table class="min-w-full table-auto" id="weaverTable">
        <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Category</th>
                <th class="py-3 px-6 text-left">Product</th>
                <th class="py-3 px-6 text-left">Status</th>
                <th class="py-3 px-6 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="py-3 px-6 text-left">Raw Materials</td>
                <td class="py-3 px-6 text-left">Natural Fibers</td>
                <td class="py-3 px-6 text-left">On Progress</td>
                <td class="py-3 px-6 flex space-x-2">
                <!-- View Details Button -->
                <button 
                    class="verifyBtn bg-indigo-500 hover:bg-indigo-600 text-white py-1.5 px-4 rounded-full text-xs flex items-center gap-2 shadow transition"
                >
                    <span class="material-icons text-base">info</span>
                    View Details
                </button>

                <!-- Done Button -->
                <button 
                    class="declineBtn bg-emerald-500 hover:bg-emerald-600 text-white py-1.5 px-4 rounded-full text-xs flex items-center gap-2 shadow transition"
                >
                    <span class="material-icons text-base">check</span>
                    Done
                </button>
                </td>
            </tr>



            

        </tbody>
    </table>
</div>


















    <?php 
    }else{
    ?>
    <div class="w-full flex items-center p-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded-2xl shadow-lg">
        <img src="https://cdn-icons-png.flaticon.com/512/564/564619.png" alt="Warning Icon" class="w-12 h-12 mr-4">
        <div>
            <p class="font-bold text-xl mb-1">Account Not Verified</p>
            <p class="text-base">Please wait for Administrator Verification.</p>
        </div>
    </div>

    <?php 
    }
    ?>



<?php include "components/footer.php"; ?>
<script src="assets/js/app.js"></script>







<!-- Modal -->
<div id="progressModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Create Progress</h2>
        <form id="progressForm">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Raw Material Used</label>
                <input type="text" class="w-full border rounded p-2" placeholder="" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">How many meters</label>
                <input type="number" class="w-full border rounded p-2" placeholder="" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Status</label>
                <select class="w-full border rounded p-2" required>
                    <option value="" disabled selected>Select status</option>
                    <option value="On Progress">On Progress</option>
                    <option value="Done">Done</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#createProgressBtn').on('click', function(){
            $('#progressModal').removeClass('hidden');
        });

        $('#closeModal').on('click', function(){
            $('#progressModal').addClass('hidden');
        });

        $('#progressForm').on('submit', function(e){
            e.preventDefault();
            // You can handle form submission here (e.g., AJAX post)
            alert('Progress saved!');
            $('#progressModal').addClass('hidden');
        });
    });
</script>









<script>
// jQuery search functionality
$(document).ready(function() {
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#weaverTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>


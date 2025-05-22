<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Production Line</h2>
    <div class="w-10 h-10 ">
    </div>
</div>


<!-- Table of members -->
<div class="overflow-x-auto bg-white rounded-md shadow-md p-4">
    <!-- Search bar -->
    <div class="mb-4">
    <input type="text" id="searchInput" placeholder="Search..." class="w-64 p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
</div>

    <table class="min-w-full table-auto" id="weaverTable">
        <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID Number</th>
                <th class="py-3 px-6 text-left">Task ID</th>
                <th class="py-3 px-6 text-left">Member Name</th>
                <th class="py-3 px-6 text-left">Role</th>
                <th class="py-3 px-6 text-left">Task Name</th>
                <th class="py-3 px-6 text-left">Material</th>
                <th class="py-3 px-6 text-left">Category</th>
                <th class="py-3 px-6 text-left">
                <div>
                    Production Date<br>
                    <i class="text-sm italic text-gray-500">Start Date - End - Date</i>
                </div>
                </th>

                <th class="py-3 px-6 text-left">Status</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            <?php 
            include "backend/end-points/list_task.php";
            ?>
        </tbody>
    </table>
</div>

<?php include "components/footer.php";?>

<script src="assets/js/app.js"></script>

<script>
// jQuery search functionality
$(document).ready(function() {
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#membersTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>

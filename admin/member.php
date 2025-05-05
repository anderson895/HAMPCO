<?php include "components/header.php";?>

<!-- Top bar with user profile -->
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">List Member</h2>
    <div class="w-10 h-10 ">
        <!-- You can put a profile icon or button here if needed -->
    </div>
</div>


<!-- Table of members -->
<div class="overflow-x-auto bg-white rounded-md shadow-md p-4">
    <!-- Search bar -->
    <div class="mb-4">
    <input type="text" id="searchInput" placeholder="Search members..." class="w-64 p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
</div>

    <table class="min-w-full table-auto" id="membersTable">
        <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID Number</th>
                <th class="py-3 px-6 text-left">Full Name</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-left">Phone</th>
                <th class="py-3 px-6 text-left">Role</th>
                <th class="py-3 px-6 text-left">Sex</th>
                <th class="py-3 px-6 text-left">Status</th>
                <th class="py-3 px-6 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
           <?php include "backend/end-points/list_member.php";?>
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

<?php 
$fetch_all_materials = $db->fetch_all_materials();

if ($fetch_all_materials->num_rows > 0) {
    while ($row = $fetch_all_materials->fetch_assoc()) {
?>
    <tr class="border-b border-gray-200 hover:bg-gray-50">
        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['rm_name']); ?></td>
        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['rm_description']); ?></td>
        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['rm_quantity']); ?></td>
        <td class="py-3 px-6 text-left" style="color: 
            <?php 
                if (strtolower($row['rm_status']) == 'available') echo 'green';
                else if (strtolower($row['rm_status']) == 'not available') echo 'red';
                else if (strtolower($row['rm_status']) == 'out of stocks') echo 'orange';
                else echo 'black';
            ?>;">
            <?php echo htmlspecialchars(ucfirst($row['rm_status'])); ?>
        </td>

        <td class="py-3 px-6 flex space-x-2">
            <button 
                class="updateRmBtn bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-full text-xs flex items-center shadow"
                data-id="<?php echo htmlspecialchars($row['rmid']); ?>" 
                data-rm_name="<?php echo htmlspecialchars($row['rm_name']); ?>"
                data-rm_description="<?php echo htmlspecialchars($row['rm_description']); ?>"
                data-rm_quantity="<?php echo htmlspecialchars($row['rm_quantity']); ?>"
                data-rm_status="<?php echo htmlspecialchars($row['rm_status']); ?>"
                >
                <span class="material-icons text-sm mr-1">edit</span> Update
            </button>
            <button 
                class="deleteRmBtn bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-full text-xs flex items-center shadow"
                data-id="<?php echo htmlspecialchars($row['rmid']); ?>" 
                data-rm_name="<?php echo htmlspecialchars($row['rm_name']); ?>">
                <span class="material-icons text-sm mr-1">delete</span> Remove
            </button>
        </td>
    </tr>
<?php
    }
} else {
?>
    <tr>
        <td colspan="8" class="py-3 px-6 text-center">No unverified members found.</td>
    </tr>
<?php
}
?>

<!-- Modal Structure -->
<div id="UpdateRawMaterialsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center " style="display:none;">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4">Update Raw Material</h2>
        
        <!-- Modal Content for Update (hidden on Delete action) -->
        <div id="updateForm">
            <form id="UpdateRawMaterialsForm">
                <input type="hidden" name="rmid" id="rmid">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="rm_name" id="rm_name" class="w-full border rounded p-2" placeholder="Enter material name" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <input type="text" name="rm_description" id="rm_description" class="w-full border rounded p-2" placeholder="Enter description" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Quantity</label>
                    <input type="text" name="rm_quantity" id="rm_quantity" class="w-full border rounded p-2" placeholder="Enter quantity" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="rm_status" id="rm_status" class="w-full border rounded p-2" required>
                        <option value="" disabled>Select status</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                        <option value="Out of Stocks">Out of Stocks</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2">
                        <button type="button" id="closeModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" id="submitUpdateRawMaterials" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>

        <!-- Modal Content for Delete Confirmation (hidden on Update action) -->
        <div id="modalContent" style="display:none;">
            <p>Are you sure you want to delete this raw material?</p>
            <div class="flex justify-end gap-2">
                <form id="DeleteRawMaterialsForm">
                    <button type="button" id="modalCancel" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" id="modalConfirm" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
    let actionType = "";
    let selectedId = "";

    $('.updateRmBtn').click(function () {
        actionType = "update";
        selectedId = $(this).data('id');
        let name = $(this).data('rm_name');
        let description = $(this).data('rm_description');
        let quantity = $(this).data('rm_quantity');
        let status = $(this).data('rm_status');

        // Show update form and hide delete confirmation
        $('#modalTitle').text('Update Raw Material');
        $('#modalContent').hide();  // Hide delete content
        $('#updateForm').show();    // Show update form

        // Fill the form with data
        $('#rmid').val(selectedId);
        $('#rm_name').val(name);
        $('#rm_description').val(description);
        $('#rm_quantity').val(quantity);
        $('#rm_status').val(status);

        $('#UpdateRawMaterialsModal').fadeIn();
    });

    // Close the modal
    $("#closeModal").click(function (e) { 
        e.preventDefault();
        $('#UpdateRawMaterialsModal').fadeOut();
    });

    $('.deleteRmBtn').click(function () {
        actionType = "delete";
        selectedId = $(this).data('id');
        let name = $(this).data('rm_name');

        // Show delete confirmation and hide update form
        $('#modalTitle').text('Delete Raw Material');
        $('#modalContent').show();  
        $('#updateForm').hide();

        $('#UpdateRawMaterialsModal').fadeIn();
    });

    // Handle modal cancel
    $('#modalCancel').click(function () {
        $('#UpdateRawMaterialsModal').fadeOut();
    });


    $('#UpdateRawMaterialsForm').submit(function (e) { 
        e.preventDefault();
            $.ajax({
                type: "POST",
                url: "backend/end-points/controller.php",
                data: {
                    requestType: "updateRawMaterial",
                    rmid: $('#rmid').val(),
                    rm_name: $('#rm_name').val(),
                    rm_description: $('#rm_description').val(),
                    rm_quantity: $('#rm_quantity').val(),
                    rm_status: $('#rm_status').val()
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        alertify.success(response.message);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alertify.error(response.message);
                    }
                }
            });
       
            $.ajax({
                type: "POST",
                url: "backend/end-points/controller.php",
                data: {
                    requestType: "deleteRawMaterial",
                    rmid: selectedId
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        alertify.success(response.message);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alertify.error(response.message);
                    }
                }
            });
        $('#UpdateRawMaterialsModal').fadeOut();
    });


    $('#DeleteRawMaterialsForm').submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "backend/end-points/controller.php",
            data: {
                requestType: "deleteRawMaterial",
                rmid: selectedId
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    alertify.success(response.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alertify.error(response.message);
                }
            }
    });
$('#UpdateRawMaterialsModal').fadeOut();
});
});

</script>

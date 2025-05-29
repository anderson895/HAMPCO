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


           <!-- Stock In Button -->
            <button 
                class="stockInRmBtn bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-full text-xs flex items-center shadow"
                data-id="<?php echo htmlspecialchars($row['rmid']); ?>" 
                data-rm_name="<?php echo htmlspecialchars($row['rm_name']); ?>">
                <span class="material-icons text-sm mr-1">arrow_upward</span> Stock In
            </button>

          


        </td>
    </tr>
<?php
    }
} else {
?>
    <tr>
        <td colspan="8" class="py-3 px-6 text-center">No raw materials found.</td>
    </tr>
<?php
}
?>

<!-- Modal Structure -->
<div id="UpdateRawMaterialsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4">Update Raw Material</h2>
        
        <!-- Update Form -->
        <div id="updateForm">
            <input type="hidden" name="rmid" id="rmid">
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="rm_name" id="rm_name" class="w-full border rounded p-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Description</label>
                <input type="text" name="rm_description" id="rm_description" class="w-full border rounded p-2" >
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Quantity</label>
                <input type="text" name="rm_quantity" id="rm_quantity" class="w-full border rounded p-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="rm_status" id="rm_status" class="w-full border rounded p-2" required>
                    <option value="">Select status</option>
                    <option value="Available">Available</option>
                    <option value="Not Available">Not Available</option>
                    <option value="Out of Stocks">Out of Stocks</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="button" id="submitUpdateRawMaterials" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
            </div>
        </div>

        <!-- Delete Confirmation -->
        <div id="modalContent" style="display:none;">
            <p class="mb-4">Are you sure you want to delete this raw material?</p>
            <div class="flex justify-end gap-2">
                <button type="button" class="modalCancel bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="button" id="submitDeleteRawMaterials" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
            </div>
        </div>
    </div>
</div>















<!-- Modal Structure -->
<div id="stockInRmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 " style="display:none;">
    <div class="relative bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4 sm:mx-0 max-h-[90vh] overflow-y-auto">
        <!-- Spinner -->
        <div id="spinner" class="absolute inset-0 bg-white bg-opacity-80 flex items-center justify-center rounded-2xl z-50 " style="display:none;">
            <div class="w-10 h-10 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
        </div>

        <h2 id="modalTitle" class="text-2xl font-bold text-gray-800 mb-6 text-center">Stock In</h2>

        <form id="frmRawStockin" method="POST" class="space-y-4">
            <div>
                <label for="rm_quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                <input 
                    type="number" 
                    name="rm_quantity" 
                    id="rm_quantity" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Enter quantity"
                    required
                >
                <input hidden type="text" id="raw_id" name="raw_id">
            </div>

            <div class="flex justify-end pt-4 space-x-3">
                <button type="button" class="closeStockInRmModal px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button id="btnRawStockin" type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>








<script>
$(document).ready(function () {
    let selectedId = "";

    $('.stockInRmBtn').click(function () {
        selectedId = $(this).data('id');
        console.log(selectedId);
        
        $("#raw_id").val(selectedId);
        $('#stockInRmModal').fadeIn();
    });


     $('.closeStockInRmModal').click(function () {
        selectedId = $(this).data('id');
        $('#stockInRmModal').fadeOut();
    });

    


    $("#frmRawStockin").submit(function (e) {
            e.preventDefault();

            $('.spinner').show();
            $('#btnRawStockin').prop('disabled', true);
        
            var formData = new FormData(this); 
            formData.append('requestType', 'RawStockin');
            $.ajax({
                type: "POST",
                url: "backend/end-points/controller.php",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json", // Expect JSON response
                beforeSend: function () {
                    $("#btnRawStockin").prop("disabled", true).text("Processing...");
                },
                success: function (response) {
                    console.log(response); // Debugging
                    
                    if (response.status ==="success") {
                        alertify.success(response.message);
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        $('.spinner').hide();
                        $('#btnRawStockin').prop('disabled', false);
                        alertify.error(response.message);
                    }
                },
                complete: function () {
                    $("#btnRawStockin").prop("disabled", false).text("Submit");
                }
            });
        });





    $('.updateRmBtn').click(function () {
        selectedId = $(this).data('id');
        $('#modalTitle').text('Update Raw Material');
        $('#updateForm').show();
        $('#modalContent').hide();

        $('#rmid').val(selectedId);
        $('#rm_name').val($(this).data('rm_name'));
        $('#rm_description').val($(this).data('rm_description'));
        $('#rm_quantity').val($(this).data('rm_quantity'));
        $('#rm_status').val($(this).data('rm_status'));
        $('#UpdateRawMaterialsModal').fadeIn();
    });

    $('.deleteRmBtn').click(function () {
        selectedId = $(this).data('id');
        $('#modalTitle').text('Delete Raw Material');
        $('#updateForm').hide();
        $('#modalContent').show();
        $('#UpdateRawMaterialsModal').fadeIn();
    });

    $('#closeModal, .modalCancel').click(function () {
        $('#UpdateRawMaterialsModal').fadeOut();
    });

    $('#submitUpdateRawMaterials').click(function () {
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

        $('#UpdateRawMaterialsModal').fadeOut();
    });

    $('#submitDeleteRawMaterials').click(function () {
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

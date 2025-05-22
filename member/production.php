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
        ADD TASK
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
                <th class="py-3 px-6 text-left">Task ID</th>
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
                <th class="py-3 px-6 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            <?php 
            include "backend/end-points/list_task.php";
            ?>
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
<div id="progressModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
<div class="bg-white rounded-lg p-6 w-full max-w-3xl shadow-xl">

        <h2 class="text-xl font-semibold mb-4">+ ADD TASK</h2>

        <form id="frmCreateProgress" class="space-y-4">
            <!-- Material Name -->
            <div>
                <label for="material_name" class="block text-sm font-medium text-gray-700">Task Name</label>
                <input type="text" id="material_name" name="material_name" class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:outline-none" required>
            </div>


            <!-- Category -->
            <div>
                <label for="material_category" class="block text-sm font-medium text-gray-700">Category</label>
                <input type="text" id="material_category" name="material_category" class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:outline-none" required>
            
            </div>


            <!-- First Raw Material -->
            <div class="previous-work-entry bg-white p-6 rounded-2xl shadow-lg border border-gray-300 mb-4">
                <div class="mb-5 text-center">
                    <h6 class="text-lg font-semibold text-gray-800">Raw Material 1</h6>
                    <hr class="mt-2 border-gray-300">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Raw Material Used</label>
                        <select name="raw_used[]" id="raw_used_0" class="raw-used-select w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:outline-none" required>
                            <option value="">Select raw material</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity Used</label>
                        <div class="relative">
                        <input type="number" name="raw_qty[]" 
                                class="w-full mt-1 px-4 py-2 pr-16 border border-gray-300 rounded-lg focus:ring-green-500 focus:outline-none" 
                                required>
                        <span class="quantity-unit-label absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500"></span>
                        <input hidden type="text" class="unit_value" name="unit_value[]">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Raw Materials -->
            <div id="otherRawMaterialsContainer" class="space-y-4"></div>
            <button type="button" id="addOtherWorkMaterials" class="w-full px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">Add Raw</button>

            
            <!-- Status Dropdown -->
            <div>
                <label for="rm_status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="rm_status" id="rm_status" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:outline-none" required>
                    <option value="">Select status</option>
                    <option value="On Progress">On Progress</option>
                    <option value="Done">Done</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" id="submitAddRawMaterials" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create</button>
            </div>
        </form>
    </div>
</div>


<!-- JavaScript -->
<script>
function loadRawMaterials($select) {
    $.ajax({
        url: 'backend/end-points/get_raw_materials.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $select.empty();
            $select.append('<option value="">Select raw material</option>');
            data.forEach(function (item) {
                $select.append('<option value="' + item.id + '" data-unit="' + item.quantity_unit + '">' + item.name + ' (Available: ' + item['quantity_unit'] + ')</option>');
            });
            updateDisabledOptions();
        },
        error: function () {
            console.error("Failed to fetch raw materials.");
        }
    });
}

$(document).ready(function () {
    loadRawMaterials($('#raw_used_0'));

    $('#addOtherWorkMaterials').on('click', addOtherWorkMaterials);

    $('#closeModal').on('click', function () {
        $('#progressModal').addClass('hidden');
    });

    $('#otherRawMaterialsContainer').on('click', '.removeWork', function () {
        $(this).closest('.previous-work-entry').remove();
        updateDisabledOptions();
    });

    // Trigger update when any dropdown changes
   $(document).on('change', '.raw-used-select', function () {
        updateDisabledOptions();

        // Get selected option's unit
        const selectedOption = $(this).find('option:selected');
        const fullUnit = selectedOption.data('unit') || '';
        const unitParts = fullUnit.toString().split(' ');
        const shortUnit = unitParts[unitParts.length - 1] || '—';

        // Find the current raw material row
        const rawMaterialRow = $(this).closest('.grid');

        // Update corresponding unit label
        const unitLabel = rawMaterialRow.find('span.quantity-unit-label');
        if (unitLabel.length) {
            unitLabel.text(shortUnit);
        }

        // Set the corresponding hidden unit_value input
        const unitValueInput = rawMaterialRow.find('input.unit_value');
        if (unitValueInput.length) {
            unitValueInput.val(shortUnit);
        }
    });

});

let workCount = 1;
function addOtherWorkMaterials() {
    const workNumber = workCount++;

    const entry = $(`
        <div class="previous-work-entry bg-white p-6 rounded-2xl shadow-lg border border-gray-300 mb-4">
            <div class="mb-5 text-center">
                <h6 class="text-lg font-semibold text-gray-800">Raw Material ${workNumber + 1}</h6>
                <hr class="mt-2 border-gray-300">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Raw Material Used</label>
                    <select name="raw_used[]" id="raw_used_${workNumber}" class="raw-used-select w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:outline-none" required>
                        <option value="">Select raw material</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantity Used</label>
                    <div class="relative">
                        <input type="number" name="raw_qty[]" 
                            class="w-full mt-1 px-4 py-2 pr-16 border border-gray-300 rounded-lg focus:ring-green-500 focus:outline-none" 
                            required>
                        <span class="quantity-unit-label absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500"></span>
                        <input hidden type="text" class="unit_value" name="unit_value[]">
                    </div>
                </div>
            </div>
            <button type="button" class="removeWork mt-4 w-full px-4 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600">Remove</button>
        </div>
    `);

    $('#otherRawMaterialsContainer').append(entry);
    const newSelect = entry.find('select');
    loadRawMaterials(newSelect);
}

// Disable already selected options in all selects
function updateDisabledOptions() {
    let selectedValues = [];
    $('.raw-used-select').each(function () {
        const val = $(this).val();
        if (val) selectedValues.push(val);
    });

    $('.raw-used-select').each(function () {
        const currentSelect = $(this);
        const currentValue = currentSelect.val();

        currentSelect.find('option').each(function () {
            const option = $(this);
            if (option.val() && option.val() !== currentValue && selectedValues.includes(option.val())) {
                option.prop('disabled', true);
            } else {
                option.prop('disabled', false);
            }
        });
    });
}





$(document).ready(function () {
    
    $('#closeModal').click(function () {
        $('#progressModal').addClass('hidden');
    });




   $('#frmCreateProgress').submit(function (event) {
    event.preventDefault();

    // Collect form data
    const formData = new FormData(this);
    formData.append('requestType', 'CreateProgress');

    $.ajax({
        url: 'backend/end-points/controller.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#submitAddRawMaterials')
                .prop('disabled', true)
                .text('Submitting...');
        },
        success: function (response) {
            try {
                const res = JSON.parse(response);

                // Correct condition (check for 'status' key, not 'success')
                if (res.status === 'success') {
                    alertify.success(res.message || 'Progress submitted successfully!');
                    $('#frmCreateProgress')[0].reset();
                    $('#otherRawMaterialsContainer').empty();
                    workCount = 1;
                    $('#progressModal').addClass('hidden');
                    setTimeout(function () { location.reload(); }, 1000);
                } else {
                    console.error('Error:', res.message || 'Unknown error');
                    alertify.error('Error: ' + (res.message || 'Something went wrong.'));
                }
            } catch (e) {
                console.error('Invalid JSON:', response);
            }
        },
        error: function (xhr, status, error) {
            alert('Failed to submit. Please try again.');
            console.error('AJAX error:', status, error);
        },
        complete: function () {
            $('#submitAddRawMaterials')
                .prop('disabled', false)
                .text('Create');
        }
    });
});

});
</script>




<script>
    $(document).ready(function(){
        $('#createProgressBtn').on('click', function(){
            $('#progressModal').removeClass('hidden');
        });

        $('#closeModal').on('click', function(){
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


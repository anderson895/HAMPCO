<?php 
$fetch_all_materials = $db->fetch_all_product();

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


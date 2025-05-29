<?php 
$fetch_all_materials = $db->fetch_all_product();

if ($fetch_all_materials->num_rows > 0) {
    while ($row = $fetch_all_materials->fetch_assoc()) {
?>
   <tr class="border-b border-gray-200 hover:bg-gray-50">
    <td class="py-3 px-6 text-left">
        <img src="../upload/<?=$row['prod_image']?>" class="w-16 h-16 object-cover rounded">
    </td>
    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['prod_id']); ?></td>
    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['prod_name']); ?></td>
    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['prod_stocks']); ?></td>
    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['prod_price']); ?></td>
    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['category_name']); ?></td>
    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($row['prod_description']); ?></td>
    <td class="py-3 px-6 flex space-x-2">
        <!-- Update Button -->
        <button class="updateRmBtn bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-full text-xs flex items-center shadow"
            data-id="<?php echo htmlspecialchars($row['prod_id']); ?>" 
            data-prod_name="<?php echo htmlspecialchars($row['prod_name']); ?>"
            data-prod_description="<?php echo htmlspecialchars($row['prod_description']); ?>"
            data-prod_category_id="<?php echo htmlspecialchars($row['prod_category_id']); ?>">
            <span class="material-icons text-sm mr-1">edit</span> Update
        </button>

        <!-- Delete Button -->
        <button class="deleteRmBtn bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-full text-xs flex items-center shadow"
            data-id="<?php echo htmlspecialchars($row['prod_id']); ?>" 
            data-prod_name="<?php echo htmlspecialchars($row['prod_name']); ?>">
            <span class="material-icons text-sm mr-1">delete</span> Remove
        </button>

        <!-- Stock In Button -->
        <button class="stockInRmBtn bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-full text-xs flex items-center shadow"
            data-id="<?php echo htmlspecialchars($row['prod_id']); ?>" 
            data-prod_name="<?php echo htmlspecialchars($row['prod_name']); ?>">
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


<?php 

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";



$user_id=$_SESSION['id'];

$list_task = $db->get_list_task();




if ($list_task && $list_task->num_rows > 0): ?>
    <?php while ($task = $list_task->fetch_assoc()): ?>


       



        <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($task['task_id']); ?></td>
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars(ucfirst($task['fullname'])); ?></td>
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars(ucfirst($task['role'])); ?></td>
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($task['task_name']); ?></td>
            <td class="py-3 px-6 text-left">
                <?php 
                $materials = json_decode($task['task_material'], true);
                if ($materials && is_array($materials)) {
                    foreach ($materials as $material) {
                        $details = $db->get_raw_materials_details($material['raw_id']);

                       if ($details) {
                            echo '<i>' . htmlspecialchars(ucfirst($details['rm_name'])) . '</i>, ' . 
                                htmlspecialchars("{$material['quantity']} {$material['unit']}") . "<br>";
                        } else {
                            echo htmlspecialchars("Unknown material, {$material['quantity']} {$material['unit']}") . "<br>";
                        }


                    }
                } else {
                    echo "--";
                }
            
                ?>
            </td>
            <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($task['task_category']); ?></td>
            <td class="py-3 px-6 text-left">
                <div>
                    <i class="text-sm italic text-gray-500">
                        Start: 
                        <?php
                        echo !empty($task['date_start']) ? date("F j, Y", strtotime($task['date_start'])) : '--';
                        ?> 
                        - 
                        <?php
                        echo !empty($task['date_end']) ? date("F j, Y", strtotime($task['date_end'])) : '--, ----';
                        ?>
                    </i>
                </div>

            </td>
            <td class="py-3 px-6 text-left"><?= $task['task_status'] ?></td>
            

        </tr>
                  
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="7" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>


<script>
      $(document).on('click', '.doneBtn', function(e) {
        e.preventDefault();
        var task_id = $(this).data('task_id');
        console.log(task_id);
    
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Mark As Done!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "backend/end-points/controller.php",
                    type: 'POST',
                    data: { task_id: task_id, requestType: 'MarkAsDone' },
                    dataType: 'json',  // Expect a JSON response
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire(
                                'Marked As Done!',
                                response.message,  // Show the success message from the response
                                'success'
                            ).then(() => {
                                setTimeout(function () { location.reload(); }, 1000);
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,  // Show the error message from the response
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was a problem with the request.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
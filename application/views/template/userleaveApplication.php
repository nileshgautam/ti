<div class="container">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Apply Date</th>
                <th scope="col">Description</th>
                <th scope="col">Days</th>
                <th scope="col">Leave Type</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)) {
                for ($i = 0; $i < count($users); $i++) {
            ?>
                    <tr>
                        <th scope="col"><?php echo $users[$i]['start_date']; ?></th>
                        <th scope="col"><?php echo $users[$i]['description']; ?></th>
                        <th scope="col"><?php echo $users[$i]['days']; ?></th>
                        <th scope="col"><?php echo $users[$i]['leave_type']; ?></th>
                        <th scope="col"><?php echo $users[$i]['status']; ?></th>
                        <th scope="col">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-success" id="approve" empid='<?php echo $users[$i]['emp_id']; ?>'>Approve</button>
                                <button type="button" class="btn btn-danger" id="reject" empid='<?php echo $users[$i]['emp_id']; ?>'> Reject</button>
                            </div>
                        </th>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $("#approve").click(function() {
            let empid = $('#approve').attr('empid');
            let formdata = {
                status: 'Approve',
                emp_id: empid
            };
            // console.log(aprv);
            $.ajax({
                type: "POST",
                url: baseURL + 'Manager/LeaveAction',
                data: formdata,
                success: function(data, textStatus, jqXHR) {
                    // data - response from server
                    console.log('succrss')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('fail')
                }
            });

        });
    });
</script>
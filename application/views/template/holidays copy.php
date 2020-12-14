<div class="py-2">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Description</th>
                <th scope="col">Holidays Type</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($holidays); $i++) {
            ?>
                <tr>
                    <th scope="row"><?php echo $i + 1; ?></th>
                    <td><?php echo $holidays[$i]['date'] ?></td>
                    <td><?php echo $holidays[$i]['description'] ?></td>
                    <td><?php echo $holidays[$i]['type'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
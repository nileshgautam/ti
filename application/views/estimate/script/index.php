<script>
    $(function() {

        // Show estimate
        $('#tableData .show-estimate').click(function(e) {
            e.preventDefault();
            let quotaion = JSON.parse($(this).attr('q-data'));
            quotaion = JSON.parse(quotaion);
            $('#estimate-view').removeClass('hide');
            $('#client-tbl').addClass('hide');
            showReport(quotaion);
        });
        // Function for back button
        $('.btn-back').click((e) => {
            e.preventDefault();
            $('#estimate-view').addClass('hide');
            $('#client-tbl').removeClass('hide');
        });
        // Function for Print button
        $('#print').click(function() {
            window.print();
        });

    });
</script>
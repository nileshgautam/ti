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
        
        $('.btn-back').click((e) => {
            e.preventDefault();
            $('#estimate-view').addClass('hide');
            $('#client-tbl').removeClass('hide');
        });

    });
</script>
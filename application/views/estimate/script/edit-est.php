<script>
    $(document).ready(function() {

        let estimateData = <?php echo $quotation ?>;
        let quotationData = JSON.parse(estimateData.data);

        // console.log(estimateData)

        showReport1(estimateData);
        $('.btn-back').click(goBack);
        $('#print').click(print);

    });
</script>
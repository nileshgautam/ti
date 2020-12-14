<script>
    $(function() {

        $('#assignForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            if (formData) {
                let URL = BASEURL + 'Admin/assignProjectPost';
                $.post(URL, formData, function(respose) {
                    if (respose != false) {
                        res = JSON.parse(respose);
                        // console.log(res);
                        $('#assignModal').modal('hide');
                        (res.type === 'success') ? successAlert(res.msg): errorAlert(res.msg);
                        // swal('Done!', res.msg, res.type);
                        setTimeout(()=>{window.location.reload()},1000);
                    }

                });
            }
        });

    });
</script>
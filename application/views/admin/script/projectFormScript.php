<script>
    $(function() {


        $('#project-form').submit(function(e) {
            e.preventDefault();
            let pid = $('#project-id').val();
            let formData = $(this).serialize();
            let url;
            if (pid != '') {
                url = BASEURL + 'Admin/edit_projectPost';
                $.post(url, formData, function(res) {
                    res = JSON.parse(res);
                    res.type == 'success' ? successAlert(res.message) : errorAlert(res.message);
                    setTimeout(() => {
                          window.location.href=BASEURL+'Admin/project';
                        }, 1000);
                });
            } else {
                url = BASEURL + 'Admin/projectPost';
                $.post(url, formData, function(res) {
                    // console.log(res);
                    res = JSON.parse(res);
                    if (res.data) {
                        $('#modal-assign-project').modal('show');
                        $('#project').val(btoa(res.data));
                    } else {
                        setTimeout(() => {
                            swal('Done!', res.msg, res.type);
                        }, 1000);
                    }


                });
            }
        });

        $('#assignProjectToManager').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            let url = BASEURL + 'Admin/assignProjectPost';
            $.post(url, formData, function(res) {
                res = JSON.parse(res)
                if (typeof res.type === "error") {
                    errorAlert(res.msg);
                } else {
                    $('#modal-assign-project').modal('hide');
                    successAlert(res.msg);
                    setTimeout(() => {
                        window.location.href = BASEURL + 'Admin/project'
                    }, 3000);
                }

            });

        });

        $('.add-new-client').click(function() {
            $('#create-clients-modal').modal('show');
        });

        $('#create-clients-form').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            if (formData) {
                let url = BASEURL + 'Admin/addnewClient';
                $.post(url, formData, function(res) {
                    res = JSON.parse(res);
                    if (res.type == 'success') {
                        successAlert(res.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 4000);
                    } else {
                        errorAlert(res.message);
                    }
                });
            }

        });


        $('.project-tbody .del-project').click(function(){
            let url = BASEURL + 'Admin/project_delete';
            let id=$(this).attr('data-id');
            deleteRow(id, 'project', url);
        });
        
     $('.project-tbody .assign-project').click(function(){
         $('#modal-assign-project').modal('show');
         $('#project').val($(this).attr('data-id'));
            // let url = BASEURL + 'Admin/project_delete';
            // let id=$(this).attr('data-id');
        //    deleteRow(id, 'project', url);
        });



    });
</script>
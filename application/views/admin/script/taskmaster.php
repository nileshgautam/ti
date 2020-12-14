<script>
    $(function() {

        let table = $('#masterTaskTbl');
        let obj = table.attr('data');
        obj = obj !== undefined ? atob(obj) : undefined;
        obj = obj !== undefined ? JSON.parse(obj) : undefined;
        console.log(obj);
        let loadTable = (obj) => {
            if (obj !== undefined) {
                // console.log(obj);
                let rows = obj.map((ob, index) => {
                    // console.log(ob);
                    let action = `<div class="tbl-btn">
                    <i class="fas fa-edit edit-task" data-id="${ob.id}" data-toggle="modal" data-target="#modal-master"></i>
                    <i class="fas fa-trash-alt delete" data-id="${ob.id}"></i></div>`;
                    let row = [(index + 1), ob.title, ob.description, ob.category, action];
                    return row;
                });

                table.DataTable({
                    data: rows,
                });

            }
        }

        loadTable(obj);


        $('.edit-task').click(function() {
            let id = $(this).attr('data-id');
            let flage = $('#flage').val();
            const URL = BASEURL + 'Admin/edit_row';
            $.post(URL, {
                flage: flage,
                id: id
            }, function(data) {
                response = JSON.parse(data);
                console.log(response);
                $('#title').val(response.title);
                $('#description').val(response.description);
                $('#row_id').val(response.id);
                $("#categories").val(response.category).change();
            });


        });
    });
</script>
$(function() {
    // Function For loading datatable using Ajax
    let table = $('#masterTempDataTable');
    let obj = table.attr('data');
    obj = obj !== undefined ? atob(obj) : undefined;
    obj = obj !== undefined ? JSON.parse(obj) : undefined;
    // console.log(obj);
    let loadTable = (obj) => {
        if (obj !== undefined) {
            // console.log(obj);
            let rows = obj.map((ob, index) => {
                // console.log(ob);
                let action = `<div class="tbl-btn">
                    <i class="fas fa-edit edit" data-id="${ob.id}" data-toggle="modal" data-target="#modal-master"></i>
                    <i class="fas fa-trash-alt delete" data-id="${ob.id}"></i></div>`;
                let row = [(index + 1), ob.title, ob.description, action];
                return row;
            });
            $('#masterTempDataTable').DataTable({
                data: rows,
            });

        }
    }

    // Calling function to load table datarows
    loadTable(obj);
    // Function to add data into the database
    $('.form-data').submit(function(e) {
        e.preventDefault();
        let form_data = $(this).serialize();
        let row_id = $('#row_id').val();

        console.log(row_id);

        let URL = '';
        row_id === '' ? URL = BASEURL + 'Admin/postFormData' : URL = BASEURL + 'Admin/edit_FormData';
        insertRow(URL, form_data);
    }); // Function to add data into the database

    $('.desi-form-data').submit(function(e) {
        e.preventDefault();
        let form_data = $(this).serialize();
        let row_id = $('#row_id').val();

        // console.log(row_id);

        let URL = '';
        row_id === '' ? URL = BASEURL + 'Admin/postFormData' : URL = BASEURL + 'Admin/edit_designation_form';
        insertRow(URL, form_data);
    });

    // Function to load data into the edit form 
    $('#tableData .edit').click(function() {
        // alert('hi')
        let id = $(this).attr('data-id');
        let flage = $('#flage').val();
        const URL = BASEURL + 'Admin/edit_row';
        $.post(URL, { flage: flage, id: id }, function(data) {
            response = JSON.parse(data);
            // console.log(response);
            $('#title').val(response.title);
            $('#description').val(response.description);
            $('#row_id').val(response.id);
            $('#deg').val(response.dept_id);
        });
    });

    // Function to delete data from databse
    $('#tableData').on('click', '.delete', function() {
        let id = $(this).attr('data-id');
        if (id) {
            let table = $('#flage').val();
            let url = BASEURL + 'Admin/deleteRowData';
            deleteRow(id, table, url);
        }
    });
});
// Function for Document owners
$(function() {
    // do-form-data
    $('#document-owner-dataTable').DataTable();
    //   
    $('#do-form-data').submit(function(e) {
        e.preventDefault();
        let row_id = $('#row_id').val();
        let URL = '';
        row_id === '' ? URL = BASEURL + 'Admin/post_doc_owner' : URL = BASEURL + 'Admin/edit_doc_ow';
        let form_data = $(this).serialize();
        // alert('HI');
        insertRow(URL, form_data);
    });

    // Function to delete
    $('#do-tbody').on('click', '.delete', function() {
        let id = $(this).attr('data-id');
        const URL = BASEURL + 'Admin/deleteRowData';
        let table = $('#flage').val();
        deleteRow(id, table, URL);
    });

    // Function For open form in edit mode
    $('#do-tbody .edit').click(function() {
        let id = $(this).attr('data-id');
        let flage = $('#flage').val();
        const URL = BASEURL + 'Admin/edit_row';
        $.post(URL, { flage: flage, id: id }, function(data) {
            response = JSON.parse(data);
            console.log(response);
            $('#title').val(response.title);
            $('#description').val(response.description);
            $('#location').val(response.location);
            $('#row_id').val(response.id);
        });
    });

});
// Function for confidential owners
$(function() {
    // do-form-data
    $('#conf-dataTable').DataTable();
    //   
    $('#cnf-form-data').submit(function(e) {
        e.preventDefault();
        $('#modal-default').modal('hide');
        let row_id = $('#row_id').val();
        let URL = '';
        row_id === '' ? URL = BASEURL + 'Admin/postFormData' : URL = BASEURL + 'Admin/edit_conf';
        let form_data = $(this).serialize();
        insertRow(URL, form_data);
    });

    // Function to delete
    $('#conf-tbody').on('click', '.delete', function() {
        let id = $(this).attr('data-id');
        let table = $('#flage').val();
        const URL = BASEURL + 'Admin/deleteRowData';
        deleteRow(id, table, URL);
    });

    // Function For open form in edit mode
    $('#conf-tbody .edit').click(function() {
        let id = $(this).attr('data-id');
        let flage = $('#flage').val();
        const URL = BASEURL + 'Admin/edit_row';
        $.post(URL, { flage: flage, id: id }, function(data) {
            $('#modal-default').modal('hide');
            response = JSON.parse(data);
            // console.log(response);
            $('#title').val(response.title);
            $('#description').val(response.description);
            $(`#visibility-level option[value='${response.visibility_level}']`).prop('selected', true);
            // $('#visibility_level').val(response.visibility_level);
            $('#row_id').val(response.id);
        });
    });

});
// Function for Deleting rows data from database table
function deleteRow(id, table, url) {
    swal("Are you sure!", " Wants to delete this entry? It will delete permanently.", "warning", {
            buttons: {
                Yes: true,
                No: true,
            },
        })
        .then((value) => {
            switch (value) {
                case "Yes":
                    let form_data = { row_id: id, table_name: table };
                    if (id !== undefined) {
                        $.post(url, form_data, function(data) {
                            response = JSON.parse(data);
                            (response.type === 'success') ? successAlert(response.message): errorAlert(res.message);
                            setTimeout(() => { window.location.reload(); }, 4000);
                        });
                    }
                    break;
                case "No":
                    swal('Confirmation', 'Data safe', 'success');
                default:
                    break;
            }
        });
}
// Function for Deleting rows data from database table
function insertRow(url, form_data) {
    $.post(url, form_data, function(data) {
        response = JSON.parse(data);
        $('#modal-master').modal('hide');
        (response.type === 'success') ? successAlert(response.message): errorAlert(response.message);
        setTimeout(() => { window.location.reload(); }, 4000);
    });
}
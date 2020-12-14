<script>
    $(function() {

        // console.log('hi');
        let counter = 0; //Global variable for rowid

        function loadDocumentRow() {
            let option = '';
            // let opdata = $('#nav-document').attr('data-select');
            let opdata = '<?php echo json_encode($document, true) ?>';
            // console.log(opdata);
            let ob = JSON.parse(opdata);
            // console.log(ob);
            if (ob != null) {
                for (let i = 0; i < ob.length; i++) {
                    option += `<option value="${ob[i]['title']}">${ob[i]['title']}</option>`;
                }
                loadRow(option, counter);
            }
        }
        // Calling loadDocumentRow for load first row
        loadDocumentRow();

        // Add More button for create multiple document rows
        $('#addmore').click(function(e) {
            e.preventDefault();
            counter = counter + 1;
            loadDocumentRow();
        });

        $('#document-row').on('click', '.remove', function() {
            $(this).parent().remove();
        });

        // Function for RowDesign
        function loadRow(option, id) {
            let row = `<div class="row docrid" data-id="${id}">
                            <div class="form-group col-sm-3">
                                <label for="Document">Document</label>
                                <select id="document${id}" name="document${id}" class="select2 form-control  document-opt">
                                ${option}
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="document_no${id}" name="" >Number</label>
                                <input type="text" class="form-control docNumber" id="document_no${id}" name="documentNo${id}" placeholder="Enter number">
                            </div>
                            <div class="form-group col-sm-2 date">
                                <label for="exp-date${id}">Expire date(if any)</label>
                                <input type="text"  class="form-control datepicker exp-date" id="exp-date${id}" name="exp-date${id}" placeholder="DD/MM/YYYY">
                            </div>
                            <div class="form-group col-sm-3 actions">
                                <label for="document_no">Upload file</label>
                                <input type="file" class="form-control file" name="file${id}" id="file${id}"placeholder="" accept="image/*">
                                
                            </div>
                            <div class="form-group col-sm-1 remove">
                            <i class="fas fa-minus-circle text-danger remove-btn" title="Remove row"></i>
                            </div>
                        </div>`;
            $('#document-row').append(row);
        }

        // Uploading file
        let documentArr = [];

        $('#document-row').on('change', '.file', function() {
            let file = $(this).prop('files')[0];
            let rowid = $(this).parent().parent().attr('data-id');
            let documentTile = $(this).parent().parent().find('.document-opt').val();
            let documentNumber = $(this).parent().parent().find('.docNumber').val();
            let documentExpDate = $(this).parent().parent().find('.exp-date').val();
            let formData = new FormData();
            formData.append('files', file);
            let clientId = JSON.parse(retriveLsData('client_id'));
            clientId = clientId != null ? clientId : $('#client-id').val();
            // console.log(clientId);
            if (clientId) {
                formData.append('clinetId', clientId);
                let fileUpload = $(this).attr('id')
                let url = BASEURL + 'Admin/upload_image';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        if (data) {
                            let filepath = JSON.parse(data);
                            // console.log(filepath);
                            let docArr = {
                                rowId: rowid,
                                docTitle: documentTile,
                                docNumber: documentNumber,
                                docExpDate: documentExpDate,
                                filePath: filepath
                            }

                            documentArr.push(docArr);

                            let localData = hasLsData('docArr');

                            if (localData) {
                                removeLsData('docArr');
                                saveLsData('docArr', documentArr);
                            } else {
                                saveLsData('docArr', documentArr);
                            }

                            let html = `<div class="doc row m-0">
                                    <div class="col-sm-4">
                                    <a href="${BASEURL+'/'+filepath}">
                                     <img src="${BASEURL+'/'+filepath}" height="30">
                                     </a>
                                     </div>
                                    <div class="col-sm-4"><i class="fa fa-times delete" aria-hidden="true" title="remove"></i><div>
                                </div>`;
                            // console.log(fileUpload);

                            $(`#${fileUpload}`).parent().append(html);
                            $(`#${fileUpload}`).remove();
                            // $(this).css('display', 'none');
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {}
        });
        // Function for updating document

        $('#document-form').submit(function(e) {
            e.preventDefault();
            let localData = hasLsData('docArr');
            if (localData) {
                let doc = retriveLsData('docArr');
                removeLsData('docArr');
                let peopleId = JSON.parse(retriveLsData('client_id'));
                peopleId = peopleId != null ? peopleId : $('#client-id').val();
                // console.log(peopleId);

                if (peopleId) {
                    formData = {
                        id: peopleId,
                        data: doc,
                        docid: $("#doc-id").val()
                    }
                    console.log(formData);

                    if (doc) {
                        let url = BASEURL + 'Admin/documentPost';
                        $.post(url, formData, function(data) {
                            let res = JSON.parse(data);
                            res.type === 'success' ? successAlert(res.message) : errorAlert(res.message);
                            removeLsData('client_id');
                            setTimeout(() => {
                                window.location.href = BASEURL + 'people-dashboard';
                            }, 4000);
                        });
                    }
                }
            }else {
                errorAlert('Go back and Fill Client details first.');
                return false;
                // console.log('no-data-available');
            }
        });
        // Function for external people
        $('#ext-people-form').submit(function(e) {
            e.preventDefault();
            // console.log('Hellow')
            let url;
            let formData = $(this).serialize();

            let clid = $('#client-id').val();

            console.log(clid);

            if (clid != '') {
                url = BASEURL + 'Admin/update_people_post';
                $.post(url, formData, function(res) {

                    if (res.clientid) {
                        let clientId = res.clientid;
                        if (hasLsData('client_id')) {
                            removeLsData('client_id');
                            saveLsData('client_id', clientId);
                        } else {
                            saveLsData('client_id', clientId);
                        }
                    }
                    if (typeof res.type === "error") {
                        errorAlert(res.message);
                    } else {
                        successAlert(res.message);
                        $('#nav-documents-tab').click();
                    }
                });
            } else {
                if (formData) {
                    url = BASEURL + 'Admin/ext_people_post';
                    let clientInfo = [];
                    clientInfo.push(formData);
                    let check = hasLsData('ClientInfo');
                    if (check) {
                        removeLsData();
                    }
                    $.post(url, formData, function(res) {
                        // console.log(res);
                        res = JSON.parse(res);
                        if (res.clientid) {
                            let clientId = res.clientid;
                            if (hasLsData('client_id')) {
                                removeLsData('client_id');
                                saveLsData('client_id', clientId);
                            } else {
                                saveLsData('client_id', clientId);
                            }
                        }
                        if (typeof res.type === "error") {
                            errorAlert(res.message);
                        } else {
                            successAlert(res.message);
                            $('#nav-documents-tab').click();
                        }
                    });
                }
            }

        });
    });
    // function for shwoing option
    function showOption(ob = null) {
        // console.log(ob);
        let options = undefined;
        if (ob != null) {
            for (let i = 0; i < ob.length; i++) {
                options += `<option value="${ob[i]['name']}" id="${ob[i]['id']}" >${ob[i]['name']}</option>`;
            }
            return options;
        } else {
            return options;
        }

    }
</script>
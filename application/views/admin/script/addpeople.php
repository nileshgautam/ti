<script>
    $(function() {

        const loadData = (url, formdata, id) => {

            $.post(url, formdata, function(respose) {
                if (respose != false) {
                    res = JSON.parse(respose);
                    let option = showOption(res.data);
                    $(`#${id}`).html(option);
                } else {
                    let option = `<option value="">No data</option>`;
                    $(`#${id}`).html(option);
                }

            });
        }

        let userInfo = [];
        // Funation for submitting the form
        $('#people-form').submit(function(e) {
            e.preventDefault();
            let data = [];
            let URL = BASEURL + 'Admin/people_post';
            let gender = undefined;
            var ele = document.getElementsByName('gender');
            // console.log(ele);
            for (i = 0; i < ele.length; i++) {
                if (ele[i].checked)
                    gender = ele[i].value;
            }

            $('#skill').val();
            let user = {
                first_name: $('#first-name').val(),
                last_name: $('#last-name').val(),
                gender: gender,
                dob: $('#dob').val(),
                mobile: $('#mobile').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                country: $('#country').val(),
                state: $('#state').val(),
                city: $('#city').val(),
                pin_zip: $('#pin-zip').val(),
                join_date: $('#join-date').val(),
                department: $('#department').val(),
                designation: $('#designation').val(),
                manager: $('#manager').val(),
                role: $('#role').val(),
                skills: $('#skill').val(),
            }
            userInfo.push(user);
            saveLsData('userInfo', userInfo);
            $('#nav-document-tab').click();
        });

        let counter = 0; //Global variable for rowid
        function loadDocumentRow() {
            let option = '';

            let opdata = $('#nav-document').attr('data-select');

            if (opdata) {
                let ob = JSON.parse(opdata);
                // console.log(ob);
                if (ob != null) {
                    for (let i = 0; i < ob.length; i++) {
                        option += `<option value="${ob[i]['title']}">${ob[i]['title']}</option>`;
                    }

                    loadRow(option, counter);
                }
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
            // alert('hi');
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
                                <label for="document_no${id}">Number</label>
                                <input type="text" class="form-control docNumber" id="document_no${id}" name="documentNo${id}" placeholder="Document number">
                            </div>
                            <div class="form-group col-sm-2 date">
                                <label for="exp-date${id}">Expire date(if any)</label>
                                <input type="text" class="form-control exp-date datepicker" id="exp-date${id}" name="exp-date${id}" placeholder="DD/MM/YYYY">
                            </div>
                            <div class="form-group col-sm-3 actions">
                                <label for="document_no">Upload file</label>
                                <input type="file" class="form-control file" name="file${id}" id="file${id}"placeholder="upload" accept="image/*">
                                
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

            let fileUpload = $(this).attr('id');

            let url = BASEURL + 'Admin/upload_employee_document';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(data) {
                    if (data) {
                        let filepath = JSON.parse(data);
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

                        console.log(filepath)

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

        });

        // Function for updating document

        $('#document-form').submit(function(e) {
            e.preventDefault();
            // let localData = ;
            if (hasLsData('docArr')) {
                let doc = retriveLsData('docArr');
                removeLsData('docArr');
                let peopleData = hasLsData('userInfo');
                // console.log(peopleData);
                let document = {};
                document.doc = peopleData == true ? doc : '';
                userInfo.push(document);
                saveLsData('userInfo', userInfo);
                // console.log(userInfo);

                $('#nav-contact-tab').click();
            } else {
                let document = $('#document-available').val();
                // console.log(document);
                if (document != '') {
                    document = JSON.parse(document);
                    userInfo.push(document);
                    saveLsData('userInfo', userInfo);
                    $('#nav-contact-tab').click();
                } else if (document === '') {
                    let document = {
                        doc: ''
                    };
                    userInfo.push(document);
                    saveLsData('userInfo', userInfo);
                    $('#nav-contact-tab').click();
                }
            }
        });

        // Function for Emergency Contact
        $('#emer-form').submit(function(e) {
            e.preventDefault();
            let user = hasLsData('userInfo');
            // formData = $(this).serialize();
            if (user) {
                let emContact = {
                    f_name: $('#em-first-name').val(),
                    // l_name: $('#em-last-name').val(),
                    mobile: $('#em-mobile').val(),
                    email: $('#em-email').val(),
                    address: $('#em-address').val(),
                    country: $('#em-country').val(),
                    state: $('#em-state').val(),
                    city: $('#em-city').val(),
                    pin: $('#em-pin-zip').val()
                };
                userInfo.push(emContact);
                saveLsData('userInfo', userInfo);
                $('#nav-cost-tab').click();
            } else {
                errorAlert("Fill Previous Details first");
            }
        });

        $('#cost-data').submit(function(e) {
            e.preventDefault();

            let user = hasLsData('userInfo');
            if (user) {

                let cost = {
                    working_hrs: $('#working-hours').val(),
                    cost_per_hrs: $('#cost-per-hours').val(),
                    rate_per_hrs: $('#rate-per-hours').val(),
                };
                userInfo.push(cost);
                let empid = $('#empid').val()
                let url = empid == '' ? BASEURL + 'Admin/saveUserdata' : BASEURL + 'Admin/updateUserdata';
                empdetails = retriveLsData('userInfo');
                // console.log(userInfo);
                $.post(url, {
                    userData: userInfo,
                    empid: empid,
                    docid: $('#doc_id').val()
                }, function(data) {
                    res = JSON.parse(data)
                    console.log(res);
                    (res.type === 'success') ? successAlert(res.message): errorAlert(res.message);
                    setTimeout(() => {
                        window.location.href = BASEURL + 'people-dashboard';
                    }, 4000);
                });
            } else {
                errorAlert('Fill Previous from First');
                return false;
            }
        });


        $('#country').change(function() {
            // swal('hi','hellow');
            let countryCode = $(this).children("option:selected").attr('id');
            if (countryCode) {
                let URL = BASEURL + 'Admin/state';
                let formdata = {
                    id: countryCode,
                };
                $.post(URL, formdata, function(respose) {
                    if (respose != false) {
                        res = JSON.parse(respose);
                        let selected = $('#state').attr('data-val');
                        let option = showOption(res.data, selected);
                        $('#state').html(option);
                        $('#state').change();
                    } else {
                        let option = `<option value="">No data</option>`;
                        $('#state').html(option);
                    }

                });
            }
        });

        $("#country").change();

        $('#state').change(function() {
            // swal('hi','hellow');
            let statecode = $(this).children("option:selected").attr('id');
            // console.log('sc', statecode);
            if (statecode) {
                let URL = BASEURL + 'Admin/city';
                if (statecode) {
                    let formData = {
                        id: statecode
                    }
                    $.post(URL, {
                        id: statecode
                    }, function(respose) {
                        if (respose != false) {
                            let selected = $('#city').attr('data-val');
                            res = JSON.parse(respose);
                            let option = showOption(res.data, selected);
                            // console.log(option);
                            if (option === '') {
                                let option = `<option value="">No city</option>`;
                                $('#city').html(option);
                            } else {
                                $('#city').html(option);
                            }
                        }

                    });
                } else {
                    return false;
                }
            }
        });

        // $('#state').change();


        $('#em-country').change(function() {
            let contrycode = $(this).children("option:selected").attr('id');
            console.log(contrycode);
            if (contrycode) {
                let URL = BASEURL + 'Admin/state';
                let formdata = {
                    id: contrycode,
                };

                $.post(URL, formdata, function(respose) {
                    if (respose != false) {
                        res = JSON.parse(respose);
                        let selected = $('#em-state').attr('data-val');
                        let option = showOption(res.data, selected);
                        // console.log(option);
                        if (option === undefined) {
                            let option = `<option value="">No city</option>`;
                            $('#em-state').html(option);
                        } else {
                            $('#em-state').html(option);
                            $('#em-state').change();
                        }
                    }

                });
            } else {
                return false;
            }

        });

        $('#em-country').change();

        $('#em-state').change(function() {
            // swal('hi','hellow');
            let countryCode = $(this).children("option:selected").attr('id');
            // console.log(countryCode);
            if (countryCode) {
                let URL = BASEURL + 'Admin/city';
                let formdata = {
                    id: countryCode,
                };
                $.post(URL, formdata, function(respose) {
                    if (respose != false) {
                        res = JSON.parse(respose);
                        let selected = $('#em-city').attr('data-val');
                        let option = showOption(res.data, selected);
                        $('#em-city').html(option);

                    } else {
                        // console.log(respose);
                        let option = `<option value="">No data</option>`;
                        $('#em-city').html(option);
                    }

                });
            }
        });

        $('#em-state').change();

        // Client delete

        $('.client-t-body .del-client').click(function() {

            let url = BASEURL + 'Admin/client_delete';
            let id = $(this).attr('data-id');
            // alert('hi')
            deleteRow($(this).attr('data-id'), 'client', url)
        });

        $('.emp-t-body .del-employee').click(function() {

            // console.log('hi')
            let url = BASEURL + 'Admin/employee_delete';
            let id = $(this).attr('data-id');
            deleteRow($(this).attr('data-id'), 'people', url)
        });

        // $('#pills-clients-tab').click(function(){
        //     let p='#pills-clients';
        //     saveLsData('clinets-pill', p);
        // });

        const slectedTabs = () => {
            let selectedTabs = JSON.parse(retriveLsData('sl'));
            console.log(selectedTabs);
        }


        // $('#department').change(function() {
        //     let id = $(this).children(':selected').attr('data-id');
        //     console.log(id);
        //     let url = BASEURL + 'Admin/get_designation';
        //     $.post(url, {
        //         depid: id
        //     }, function(res) {
        //         res = JSON.parse(res);
        //         //    console.log(res);
        //         let option = '';

        //         for (let i = 0; i < res.length; i++) {
        //             option += `<option value="${res[i]['title']}">${res[i]['title']}</option>`;
        //         }
        //         $('#designation').empty();
        //         $('#designation').html(option);


        //     });
        // });

        // $('#nav-document-tab').click(function() {
        //     $('#people-form').submit();
        // });
        // $('#nav-contact-tab').click(function() {
        //     $('#document-form').submit();
        // });

        // $('#nav-cost').click(function() {
        //     $('#document-form').submit();
        // });

    });

    // function for shwoing option
    function showOption(ob = null, selected = null) {
        // console.log('selected',selected);
        let options = '';
        if (ob != null) {
            for (let i = 0; i < ob.length; i++) {
                options += `<option ${selected==ob[i]['name']?'selected':''} value="${ob[i]['name']}" 
                id="${ob[i]['id']}">${ob[i]['name']}</option>`;
            }
            return options;
        } else {
            return options;
        }

    }
</script>
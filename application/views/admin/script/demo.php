let documentTbl = $('#document-row');
    let objarr = [];
    let rowid = 1;
    obj = {
        row_id: rowid,
        title: '',
        docNumber: '',
        docExpDate: '',
        file: ''
    }

    objarr.push(obj)

    loadTable(objarr);

    function loadTable(list) {
        let len = list.length;
        console.log(list);
        documentTbl.empty();

        for (let i = 0; i < list.length; i++) {
            let rowTemplate = $(` <div class="row">
                            <div class="form-group col-sm-3">
                                <label for="Document${list[i].row_id}">Document</label>
                                <select id="document${list[i].row_id}" name="${list[i].title}" class="select2 form-control document-title">
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="document_no${list[i].row_id}">Number</label>
                                <input type="text" class="form-control document_no" id="document_no${list[i].row_id}" placeholder="Enter number">
                            </div>
                            <div class="form-group col-sm-2 date">
                                <label for="exp-date${list[i].row_id}">Expire date(if any)</label>
                                <input type="date" class="form-control" id="exp-date${list[i].row_id}" placeholder="Choose date">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="file${list[i].row_id}">Upload file</label>
                                <input type="file" class="form-control file" name="file" id="file${list[i].row_id}" placeholder="upload">
                            </div>
                            <div class="form-group col-sm-3><a class="delete_row" id="${list[i].row_id}">Delete</a></div>
                        </div>`);

            documentTbl.append(rowTemplate);

            let delete_row = rowTemplate.find('.delete_row');
            delete_row.data("id", list[i].row_id);
            delete_row.click(deleterow_click);

            // code for fetch availble batches from database

            let documentTitle = rowTemplate.find('.document-title');
            documentTitle.data("id", list[i].row_id);
            documentTitle.data("item-key", 'documentTitle');
            let URL = BASEURL + 'Admin/documetArray';
            $.post(URL, function(data, status) {
                let docTitle = JSON.parse(data);
                console.log(docTitle);
                // let options = docTitle.map((dt) => {
                //     let optionTemplate = $(`<option value="${dt.title}">${dt.title}</option>`);
                //     console.log(optionTemplate);
                //     return optionTemplate;
                // });
                // documentTitle.append(options);
            });
            documentTitle.change(InputOption_keyup);

            let documentNo = rowTemplate.find('.document_no');
            documentNo.data("id", list[i].row_id);
            documentNo.data("item-key", 'documentNo');
            documentNo.keyup(InputText_keyup);

            let expDate = rowTemplate.find('.exp-date');
            expDate.data("id", list[i].row_id);
            expDate.data("item-key", 'expDate');
            expDate.keyup(InputText_keyup);

            let file = rowTemplate.find('.file');
            file.data("id", list[i].row_id);
            file.data("item-key", 'file');
            file.change(updateFile);
        }

        // function load_data() {
        //     let Input = $(this);
        //     let description = $(this).children("option:selected").attr('data-description');
        //     let stock = $(this).children("option:selected").attr('stock');
        //     console.log(stock);
        //     let row_id = Input.data('id');
        //     let product_details = $(`#product-details${row_id}`);
        //     let stock_data = $(`#closing${row_id}`);

        //     let item_key = Input.data('item-key');
        //     let item_key1 = Input.data('item-key1');
        //     let item_key2 = Input.data('item-key2');

        //     let item = objarr.find((item) => item.row_id == row_id);
        //     item[item_key] = Input.val();
        //     item[item_key1] = description;
        //     item[item_key2] = stock;

        //     stock_data.val(stock);
        //     product_details.val(description);
        //     // console.log(inv);

        // }
       function updateFile(){

        }
        function InputOption_keyup() {
            let Input = $(this);
            let inv = $(this).children("option:selected").attr('invoice-no');
            let row_id = Input.data('id');
            let item_key = Input.data('item-key');
            let item_key2 = Input.data('item-key2');
            let item_key3 = Input.data('item-key3');
            let item_key4 = Input.data('item-key4');
            let item_key5 = Input.data('item-key5');


            in_data = {
                inv: inv,
                batch: Input.val()
            }

            let code_id = $(`#product-code${row_id}`);
            let product_details = $(`#product-details${row_id}`);
            let closing_stock = $(`#closing${row_id}`);
            let items = objarr.find((item) => item.row_id == row_id);
            items[item_key] = Input.val();

            $.post(
                BaseUrl + "LondonControl/get_item_code",
                in_data,
                function(data, status) {
                    let item = JSON.parse(data);
                    console.log(item);
                    let options = item.map((p) => {
                        let optionTemplate = $(
                            `<option 
                        data-description="${p.item_description}" 
                        value="${p.item_code}" 
                        item-code="${p.item_code}"
                        stock="${p.closing_stock}"
                        >${p.item_code}</option>`);
                        return optionTemplate;
                    });

                    code_id.removeAttr('disabled');

                    code_id.html(options);

                    let codeValue = $(`#product-code${row_id}`).children("option:selected").val();
                    let code_description = $(`#product-code${row_id}`).children("option:selected").attr('data-description');

                    let stock = $(`#product-code${row_id}`).children("option:selected").attr('stock');

                    closing_stock.val(stock);
                    product_details.val(code_description);

                    items[item_key2] = codeValue;
                    items[item_key3] = code_description;
                    items[item_key4] = inv;
                    items[item_key5] = stock;
                    // appending option into the select box in batch
                });

        }

        function InputText_keyup() {
            let Input = $(this);
            let row_id = Input.data('id');
            let item_key = Input.data('item-key');
            let item = objarr.find((item) => item.row_id == row_id);
            item[item_key] = Input.val();
        }

        function deleterow_click() {
            let delete_row = $(this);
            let row_id = delete_row.data('id');
            let itemIndex = objarr.findIndex((item) => item.row_id == row_id);
            objarr.splice(itemIndex, 1);
            loadTable(objarr)
        }

    }
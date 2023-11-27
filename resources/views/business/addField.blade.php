function GetSelectedTextValue(select_template) {
        var selectedText = select_template.options[select_template.selectedIndex].innerHTML;
        var selectedValue = select_template.value;
        if(selectedValue == 'custom_field'){
            var html = `
              <div class="row">
                <div class="col-12">
                    <label class="form-control-label">Label</label>
                    <input class="form-control" type="text" name="${selectedValue}_label">
                </div>
                <div class="col-12">
                    <label class="form-control-label">custom field</label>
                    <input class="form-control" type="text" name="${selectedValue}">
                </div>  
              </div>
          `;
        }
        else{
            var html = `
              <div class="row">
                <div class="col-12">
                    <label class="form-control-label">${selectedValue}</label>
                    <input class="form-control" type="text" name="${selectedValue}">
                </div>  
              </div>
          `;
        }
        
        document.getElementById('addnewfield').html=html;
      }
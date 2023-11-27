function checkcount(type) {
    if (type == "hide") {
        var count = document.querySelectorAll('.inputFormRow').length;
        if (count == 3) {
            $('.hideelement').hide();
        }
    } else {
        var count = document.querySelectorAll('.inputFormRow').length;
        if (count <= 3) {
            $('.hideelement').show();
        }
    }
}
var image_count = 0;
var testimonial_image_count = 0;
var testimonial_rating_count = 0;
var radio_count = 1;

function repeaterInput(element, element_type, rowno, divid, path, theme_type, color, assets) {
    // alert(color);
    var html = '';
    var preview_html = '';
    var social_preview_html = '';

    if (element_type == "contact") {
        html = `<tr id="inputFormRow" class="inputFormRow">
                <td>
                  <div class="form-icon-user">

                      `;
                      if(element == "Address"){
                        html += `
                            <div class="input-group">
                            <span class="input-group-text"><img  src="${assets}/${element.toLowerCase()}.svg" ></span>
                            <input type="text" id="${element}_${rowno}" name="contact[${rowno}][${element}][${element}]" class="keyupinpu form-control" placeholder="Enter Address" required/>
                            </div>
                            <div class="input-group">
                            <input type="text"  name="contact[${rowno}][${element}][${element}_url]" class="keyupinpu form-control mt-2" placeholder="Enter Address Url" required/>
                            </div>`;

                      }
                      else
                      {
                        html += `
                        <div class="input-group">
                        <span class="input-group-text"><img  src="${assets}/${element.toLowerCase()}.svg" ></span>
                        <input type="text" id="${element}_${rowno}" name="contact[${rowno}][${element}]" class="keyupinpu form-control" required/>
                        </div>`;
                      }

            html += `<input type="hidden" name="contact[${rowno}][id]" value=${rowno}>
                  </div>
                </td>
                <td class="text-right">
                    <div class="action-btn bg-danger ms-2">
                    <button class="btn btn-sm d-inline-flex align-items-center contact_${rowno}" id="removeRow_contact" data-id="contact_${rowno}"><i class="ti ti-trash text-white"></i></button>
                    </div>
                </td>
              </tr>`;
        if (theme_type == 'theme1' || theme_type == 'theme8') {
           
            preview_html = `<li class="d-flex align-items-center justify-content-center" id="contact_${rowno}">
                                 <a href=""
                                            target="_blank">

                                <div class="contact-svg">
                                    <img src="${path}/${color}/${element.toLowerCase()}.svg"
                                        class="img-fluid" height="35px"
                                        width="35px">
                                </div>

                                <span id="${element}_${rowno}_preview"></span>
                                </a>
                        </li>`;
        }

        if (theme_type == 'theme2') {
            /*preview_html = `<li class="d-flex align-items-center justify-content-start"  id="contact_${rowno}">
                        <div class="image-icon">
                            <img src="${path}/${color}/contact/${element.toLowerCase()}.svg"  class="img-fluid">
                        </div>
                        <div class="contact-text">
                            <h4 id="${element}_${rowno}_preview"></h4>
                        </div>
                    </li>`;*/

            preview_html = `<div class="calllink contactlink" id="contact_${rowno}">
                                    <a href="" target="_blank">
                                        <img src="${path}/${color}/contact/${element.toLowerCase()}.svg"  class="img-fluid">
                                            <span id="${element}_${rowno}_preview"></span>
                                    </a>
                            </div>`;
        }
        if (theme_type == 'theme3') {
                    preview_html = `<li class="d-flex align-items-center" id="contact_${rowno}">
                                 <a href=""
                                            target="_blank">

                                <div class="contact-svg">
                                    <img src="${path}/${color}/${element.toLowerCase()}.svg"
                                        class="img-fluid">
                                </div>

                                <span id="${element}_${rowno}_preview"></span>
                                </a>
                        </li>`;

        }

        if (theme_type == 'theme4') {
                preview_html = `<div class="calllink contactlink" id="contact_${rowno}">
                                    <a href="" target="_blank">
                                        <div class="contact-svg">
                                            <img src="${path}/${color}/${element.toLowerCase()}.svg"  class="img-fluid">
                                        </div>
                                        <span id="${element}_${rowno}_preview"></span>
                                    </a>
                            </div>`;
        }
        if ( theme_type == 'theme5') {
            preview_html = `<li class="d-flex align-items-center" id="contact_${rowno}">
                         <a href="" target="_blank">

                        <div class="contact-svg">
                             <img src="${path}/${color}/contact/${element.toLowerCase()}.svg"  class="img-fluid">
                        </div>

                        <span id="${element}_${rowno}_preview"></span>
                        </a>
                </li>`;

        }
        if (theme_type == 'theme6') {

            preview_html = `<li class="d-flex align-items-center justify-content-start" id="contact_${rowno}">
                    <div class="contact-text">
                        <span>${element}</span>

                        <a href="#">
                            <h4 id="${element}_${rowno}_preview"></h4>
                        </a>
                    </div>
                </li>`;
        }
        if (theme_type == 'theme7') {
            preview_html = `<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" id="contact_${rowno}">
                <div class="image-icon">
                    <img src="${path}/${color}/contact/${element.toLowerCase()}.svg" alt="${element}" class="img-fluid">
                </div>
                <div class="contact-text">
                    <a href="#">
                        <h4 id="${element}_${rowno}_preview"></h4>
                    </a>
                </div>
            </li>`;
        }
        if (theme_type == 'theme8') {

            preview_html = `<li class=""  id="contact_${rowno}">
                        <a href="ssss">
                            <img src="${path}/${color}/contact/${element.toLowerCase()}.svg"  class="img-fluid">
                            <span>`;
            if(element = 'Web_url'){
                preview_html += `Web Url</span>
                        </a>
                    </li>`;
            }
            else{
                preview_html += `${element}</span>
                        </a>
                    </li>`;
            }

        }
        if (theme_type == 'theme9') {

            preview_html = `<li  id="contact_${rowno}">
            <div class="d-flex align-items-center justify-content-start">
                <div class="contact-text">
                    <span>
                    ${element}
                    </span>
                    <a href="#">
                        <h4 id="${element}_${rowno}_preview"></h4>
                    </a>
                </div>
            </div>
        </li>`;
        }
        // if (theme_type == 'theme10') {

        //     preview_html = `<div class="col-3 socials_${rowno}" id="socials_${rowno}">
        //     <div class="social-image-icon">
        //         <a href="#"  class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">
        //             <img src="${path}/${color}/social/${element.toLowerCase()}.svg" alt="${element}" class="img-fluid">
        //         </a>
        //     </div>
        // </div>`;


        //     $(".inputrow_socials_preview").append(preview_html);
        // }
        if (theme_type == 'theme10') {
            preview_html = `<li class="col-3 contact_${rowno}"  id="contact_${rowno}">
                <a href="#">
                    <div class="social-image-icon">
                    <img src="${path}/${color}/contact/${element.toLowerCase()}.svg" alt="${element}" class="img-fluid">
                </a>
                    </div>
                        </div>`;
        }

        rowno++;
        $("#fieldModal").modal('hide');
    }

    if (element_type == "appointment") {
        var class_radio = '';
        if(radio_count % 2 == 0){
            class_radio = 'radio-left';
        }
        html = `<tr id="inputFormRow1">
                <td>
                    <input type="time"  class="form-control timepicker" name="hours[${rowno}][start]" id="appoinment_start_${rowno}" value="" onchange="changeTime(this.id)">
                </td>
                <td>
                  <input type="time" class="form-control timepicker" name="hours[${rowno}][end]" id="appoinment_end_${rowno}" value="" onchange="changeTime(this.id)">
                </td>
                <td class="text-right">
                    <div class="action-btn bg-danger ms-2 float-end">
                        <a class="btn btn-sm d-inline-flex align-items-center appointment_${rowno}" id="removeRow_appointment" data-id="appointment_${rowno}"><i class="ti ti-trash text-white"></i></a>
                    </div>
                </td>
            </tr>`;
        preview_html = `<div class="radio ${class_radio} " id="appointment_${rowno}">
                        <input id="radio-${radio_count}" name="time" type="radio"   class="app_time">
                        <label for="radio-${radio_count}" class="radio-label"><span id="appoinment_start_${rowno}_preview">00:00 </span> - <span id="appoinment_end_${rowno}_preview">00:00</span></label>
                </div>`;
        if (theme_type == 'theme4') {
            // preview_html = `<option id="appointment_${rowno}"><span id="appoinment_start_${rowno}_preview">00:00</span> - <span id="appoinment_end_${rowno}_preview">00:00</span></option>`;
            preview_html = `<option"><span id="appoinment_start_${rowno}_preview">00:00</span> - <span id="appoinment_end_${rowno}_preview">00:00</span></option>`;
        }
        if (theme_type == 'theme5' || theme_type == 'theme7' || theme_type == 'theme8' || theme_type == 'theme9') {
            preview_html = `  <li id="appointment_${rowno}"><span id="appoinment_start_${rowno}_preview">00:00</span> - <span id="appoinment_end_${rowno}_preview">00:00</span></li>`;
        }
        radio_count++;
        rowno++;
    }

    if (element_type == "service") {

        html = `<div class="col-6" id="inputFormRow2">
              <div class="card min-393 border-primary border-2 border-bottom-0 border-start-0 border-end-0">
                  <div class="card-body text-center">
                    <div class="float-end action-btn bg-danger ms-2">
                      <a class="btn btn-sm d-inline-flex align-items-center hover-none" id="removeRow_services" data-id="services_${rowno}" data-id="services" id="removeRow"><i class="ti ti-trash"></i></a>
                    </div>
                    <div class="position-relative ml-2 d-inline-flex">
                      <img alt="Image placeholder" src="${path}/placeholder-image.jpg" id="service_image${image_count}" class="imagepreview">
                      <div class="position-absolute top-50 start-100 translate-middle">
                        <input type="file" id="file-1"  class="custom-input-file d-none custom-input-file-link service_image${image_count}  data-multiple-caption="{count} files selected " multiple="" name="services[${rowno}][image]" >
                          <span class="btn btn-sm btn-info btn-icon" >

                            <i class="ti ti-pencil" onclick="selectFile('service_image${image_count}')"></i>


                          </span>
                      </div>
                    </div>
                    <h5 class="mt-4 font-weight-bold mb-0 input-h4">
                      <input type="text" id="title_${rowno}"  name="services[${rowno}][title]" class="h5 textboxhover border-0 " placeholder="Enter title">

                    </h5>
                      <div class="mt-2 text-dark textarea-adjust">
                        <textarea class="border-0 textboxhover input-text-location text-center" id="description_${rowno}" name="services[${rowno}][description]"   placeholder="Enter Description"></textarea>
                      </div>
                    <h5 class="mt-2 font-weight-bold mb-0 input-h4">
                      <input type="text" id="purchase_link_${rowno}"  name="services[${rowno}][purchase_link]" class="h5 textboxhover border-0 " placeholder="Purchase Link">

                    </h5>
                    <div class="mt-2 text-dark textarea-adjust">
                    <textarea class="border-0 textboxhover input-text-location text-center" id="link_title_${rowno}" name="services[${rowno}][link_title]"   placeholder="Enter Link Title"></textarea>
                  </div>
                  </div>
                </div>

              </div> `;
        var sclass = '';
        preview_html = `<div class="col-lg-6" id="services_${rowno}">`;
        var desc = `<p id="description_${rowno}_preview"></p>`
        if (theme_type == 'theme5' || theme_type == 'theme9' || theme_type == 'theme10') {
            preview_html = `<div class="col-lg-4" id="services_${rowno}">`;
            desc = '';
        } else if (theme_type == 'theme6' || theme_type == 'theme7') {
            preview_html = `<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="services_${rowno}">`;
        }

        if (theme_type == 'theme7') {
            sclass = ' card-contact-shadow mt-2';
        }
        

        preview_html += `<div class="service-card ${sclass}">
                            <div class="service-card-img">
                                <img id="service_image${image_count}_preview"  src="${path}/image.svg" alt="image" class="img-fluid">
                            </div>
                            <div class="service-card-heading">
                                <h3 id="title_${rowno}_preview">
                                </h3>
                                ${desc}
                                </p>
                            </div>
                        </div>
                    </div>`;
        if(theme_type == 'theme1' || theme_type == 'theme3'){
            preview_html = `<div class="service-card" id="services_${rowno}">
                                 <div class="service-card-inner">
                                        <div class="service-icon testimonials_image">
                                             <img id="service_image${image_count}_preview"  src="${path}/image.svg" alt="image" class="img-fluid">
                                        </div>
                                        <h5 id="title_${rowno}_preview"></h5>

                                        ${desc} 

                                    </div>
                            </div>`;
        }         
        if(theme_type == 'theme4' || theme_type == 'theme5'){
            desc = `<p style="color:white" id="description_${rowno}_preview"></p>`;
        }
        if(theme_type == 'theme4'|| theme_type == 'theme5' ){
            preview_html = `<div class="service-card" id="services_${rowno}">
                                 <div class="service-card-inner">
                                        <div class="service-icon testimonials_image">
                                             <img id="service_image${image_count}_preview"  src="${path}/image.svg" alt="image" class="img-fluid">
                                        </div>
                                        <h5 id="title_${rowno}_preview"></h5>
                        
                                        ${desc}
                                    </div>
                            </div>`;
        }            
        if(theme_type == 'theme2'){
            preview_html = `<div class="service-card" id="services_${rowno}">
                            <div class="service-card-inner">
                                <div class="service-icon testimonials_image">
                                    <img id="service_image${image_count}_preview"  src="${path}/image.svg" alt="image" class="img-fluid">
                                </div>
                                <h5 id="title_${rowno}_preview"></h5>
                                ${desc}
                            </div>
                        </div>`;
        }
        image_count++;
        rowno++;
    }

    if (element_type == "testimonial") {

        html = `<div class="col-6" id="inputFormRow3">
                <div class="card min-393 border-primary border-2 border-bottom-0 border-start-0 border-end-0">
                    <div class="card-body text-center">
                      <div class="float-end action-btn bg-danger ms-2">
                        <a class="btn btn-sm d-inline-flex align-items-center hover-none"  id="removeRow_testimonials" data-id="testimonials_${rowno}"><i class="ti ti-trash"></i></a>
                      </div>
                      <div class="position-relative ml-2 d-inline-flex">
                        <img alt="Image placeholder" src="${path}" id="testimonial_image${testimonial_image_count}" class="imagepreview">
                        <div class="position-absolute top-50 start-100 translate-middle" >
                            <input type="file" id="file-1"  class="custom-input-file d-none custom-input-file-link testimonial_image${testimonial_image_count}"  data-multiple-caption="{count} files selected" multiple="" name="testimonials[${rowno}][image]" >
                         <span class="btn btn-sm btn-info btn-icon" onclick="selectFile('testimonial_image${testimonial_image_count}')"> <i class="fas fa-pen"></i></span>


                        </div>
                      </div>
                      <h5 class="mt-4 font-weight-bold mb-0 input-h4">
                        <span class="stars${rowno}">0</span>/5

                      </h5>
                      <div class="text-center testimonial-ratings mt-2">
                      <fieldset id='demo1' class="rating">
                            <input class="stars${rowno}" type="radio" id="testimonials-5-${testimonial_rating_count}" name="testimonials[${rowno}][rating]"  value="5" onclick="getRadio(this)"/>
                            <label class="full" for="testimonials-5-${testimonial_rating_count}" title="Awesome - 5 stars"></label>
                            <input class="stars${rowno}" type="radio" id="testimonials-4-${testimonial_rating_count}" name="testimonials[${rowno}][rating]" value="4" onclick="getRadio(this)"/>
                            <label class="full" for="testimonials-4-${testimonial_rating_count}" title="Pretty good - 4 stars"></label>
                            <input class="stars${rowno}" type="radio" id="testimonials-3-${testimonial_rating_count}" name="testimonials[${rowno}][rating]" value="3" onclick="getRadio(this)"/>
                            <label class="full" for="testimonials-3-${testimonial_rating_count}" title="Meh - 3 stars"></label>
                            <input class="stars${rowno}" type="radio" id="testimonials-2-${testimonial_rating_count}" name="testimonials[${rowno}][rating]" value="2" onclick="getRadio(this)"/>
                            <label class="full" for="testimonials-2-${testimonial_rating_count}" title="Kinda bad - 2 stars"></label>
                            <input class="stars${rowno}" type="radio" id="testimonials-1-${testimonial_rating_count}" name="testimonials[${rowno}][rating]" value="1" onclick="getRadio(this)"/>
                            <label class="full" for="testimonials-1-${testimonial_rating_count}" title="Sucks big time - 1 star"></label>
                        </fieldset>
                        </div>
                        <div class="mt-2 text-dark textarea-adjust">
                          <textarea class="border-0 textboxhover input-text-location text-center" id="testimonial_description_${rowno}" name="testimonials[${rowno}][description]"   placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                  </div>

                </div> `;

        preview_html = `<div class="col-lg-6 pr-8 pl-0 res-pr-0" id="testimonials_${rowno}">
                          <div class="service-card testimonials-card">
                              <div class="service-card-img ">
                                  <img id="testimonial_image${testimonial_image_count}_preview" src="${path}" alt="user" class="img-fluid">
                              </div>
                              <div class="service-card-heading">
                                  <h3>
                                      <span class="stars${rowno}">0</span>/5
                                  </h3>
                                  <span id="stars${rowno}_star" class="star-section d-flex align-items-center justify-content-center">
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  <i class="fa fa-star"></i>
                                  </span>
                                  <p id="testimonial_description_${rowno}_preview">

                                  </p>
                              </div>
                          </div>
                      </div>`;
                      if(theme_type == 'theme1' || theme_type == 'theme3' ||theme_type == 'theme5'){
                        preview_html = `<div class="testimonial-itm" id="testimonials_${rowno}">
                               <div class="testimonial-itm-inner">
                                   <div class="testi-client-img">
                                       <img id="testimonial_image${testimonial_image_count}_preview" src="${path}" class="img-fluid" alt="image" width="200px" height="200px">
                                   </div>
                                   <h5 class="rating-number"><span class="stars${rowno}">0</span>/5</h5>

                                   <div id="stars${rowno}_star" class="rating-star star-section">
                                         <i class="fa fa-star"></i>
                                         <i class="fa fa-star"></i>
                                         <i class="fa fa-star"></i>
                                         <i class="fa fa-star"></i>
                                         <i class="fa fa-star"></i>
                                   </div>
                                   <p id="testimonial_description_${rowno}_preview"></p>
                               </div>
                           </div>`;

                   }
                    if(theme_type == 'theme2' ||theme_type == 'theme4'){
                         preview_html = `<div class="testimonial-itm" id="testimonials_${rowno}">
                                <div class="testimonial-itm-inner">
                                    <div class="testi-client-img">
                                        <img id="testimonial_image${testimonial_image_count}_preview" src="${path}" class="img-fluid" alt="image">
                                    </div>
                                    <h5 class="rating-number"><span class="stars${rowno}">0</span>/5</h5>

                                    <div id="stars${rowno}_star" class="rating-star star-section">
                                          <i class="fa fa-star"></i>
                                          <i class="fa fa-star"></i>
                                          <i class="fa fa-star"></i>
                                          <i class="fa fa-star"></i>
                                          <i class="fa fa-star"></i>
                                    </div>
                                    <p id="testimonial_description_${rowno}_preview"></p>
                                </div>
                            </div>`;
                    }
        testimonial_rating_count++;
        testimonial_image_count++;
        rowno++;
    }

    if (element_type == "social_links") {
        html = `<tr id="inputFormRow4" class="inputFormRow">
                <td>
                  <div class="input-group">
                      <span class="input-group-text"><img src="${assets}/black/${element.toLowerCase()}.svg"></span>
                      <input type="text" id="social_link_${rowno}" name="socials[${rowno}][${element}]" placeholder="Enter link" class="form-control social_href" required/>
                      <input type="hidden" name="socials[${rowno}][id]" value=${rowno}><br>

                  </div>
                  <h6 class="text-danger text-xs" id="social_link_${rowno}_error_href"></h6>
                </td>
                <td class="text-right float-end">
                <div class="action-btn bg-danger ms-2">
                    <button class="btn btn-sm d-inline-flex align-items-center" id="removeRow_socials" data-id="socials_${rowno}"><i class="ti ti-trash text-white"></i></button>
                </div>
                </td>
              </tr>`;

        if (theme_type == 'theme1') {
            preview_html = `<li class="socials_${rowno} social-image-icon" id="socials_${rowno}">
                                <a href="#" class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">
                                    <img src="${path}/${color}/${element.toLowerCase()}.svg" alt="${element.toLowerCase()}"
                                         class="img-fluid">
                                </a>
                            </li>`;
            social_preview_html = `<div class="col-2 socials_${rowno}" id="socials_${rowno}">
                                <span>
                                  <a href="#" id="social_link_${rowno}_href_preview" class="social_link_${rowno}_href_preview"  target="_blank">
                                      <div class="image-icon">
                                          <img src="${path}/black/${element}.svg" alt="${element}" class="img-fluid">
                                      </div>
                                  </a>
                                </span>
                              </div>
                                `;
            $(".inputrow_socials_preview").append(preview_html);                       
        }
        if (theme_type == 'theme2') {
            /*preview_html = `<div class="col-3 social-image-icon socials_${rowno}" id="socials_${rowno}">
                                <a href="#" id="social_link_${rowno}_href_preview" class="social_link_${rowno}_href_preview"  target="_blank">
                                    <img src="${path}/${color}/social/${element.toLowerCase()}.svg" alt="${element.toLowerCase()}"
                                        class="img-fluid hover-hide">
                                    <img src="${path}/${color}/social/${element.toLowerCase()}.svg" alt="${element.toLowerCase()}"
                                        class="img-fluid hover-show">
                                </a>
                        </div>`;*/

            preview_html = `<li class="socials_${rowno} social-image-icon" id="socials_${rowno}">
                                <a href="#" class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">

                                    <img src="${path}/${color}/social/${element.toLowerCase()}.svg" alt="${element.toLowerCase()}"
                                         class="img-fluid hover-hide">
                                    <img src="${path}/${color}/social/${element.toLowerCase()}.svg" alt="${element.toLowerCase()}"
                                         class="img-fluid hover-show">
                                </a>
                            </li>`;
            social_preview_html = `<div class="col-2 socials_${rowno}" id="socials_${rowno}">
                                <span>
                                  <a href="#" id="social_link_${rowno}_href_preview" class="social_link_${rowno}_href_preview"  target="_blank">
                                      <div class="image-icon">
                                          <img src="${path}/black/${element}.svg" alt="${element}" class="img-fluid">
                                      </div>
                                  </a>
                                </span>
                              </div>
                                `;
            $(".inputrow_socials_preview").append(social_preview_html);
        }

        if (theme_type == 'theme3') {
            preview_html = `<div class="social-image-icon socials_${rowno}">
                          <a href="#" class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">
                              <img src="${path}/social/${element.toLowerCase()}.svg" alt="${element}"
                                  class="img-fluid">
                          </a>
                      </div>`;
            $(".inputrow_socials_preview").append(preview_html);
        }
        if (theme_type == 'theme4') {

            preview_html = `<li class="socials_${rowno} social-image-icon" id="socials_${rowno}">
                                <a href="#" class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">
                                    <img src="${path}/${color}/${element.toLowerCase()}.svg" alt="${element.toLowerCase()}"
                                         class="img-fluid">
                                </a>
                            </li>`;
            social_preview_html = `<div class="col-2 socials_${rowno}" id="socials_${rowno}">
                                <span>
                                  <a href="#" id="social_link_${rowno}_href_preview" class="social_link_${rowno}_href_preview"  target="_blank">
                                      <div class="image-icon">
                                          <img src="${path}/black/${element}.svg" alt="${element}" class="img-fluid">
                                      </div>
                                  </a>
                                </span>
                              </div>
                                `;
            $(".inputrow_socials_preview").append(preview_html);      
        }
        if (theme_type == 'theme5') {


        //     preview_html = `<div class="col-3 socials_${rowno}" id="socials_${rowno}">
        //       <div class="social-image-icon">
        //           <a href="#" class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">
        //               <img src="${path}/${color}/social/${element.toLowerCase()}.svg" class="img-fluid">
        //           </a>
        //       </div>
        //   </div>`;

          preview_html = `<li>
          <div class="socials_${rowno}" id="socials_${rowno}">
              <a href="#" id="social_link_${rowno}_href_preview" class="social_link_${rowno}_href_preview" target="_blank">
                  <img src="${path}/${color}/social/${element.toLowerCase()}.svg" class="img-fluid">
              </a>
          </div>
      </li>`;

            $(".inputrow_socials_preview").append(preview_html);
        }
        if (theme_type == 'theme6') {

            preview_html = `<div class="col-3 socials_${rowno}" id="socials_${rowno}">
              <div class="social-image-icon">
                  <a href="#" class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">
                      <img src="${path}/${color}/social/${element.toLowerCase()}.svg" alt="${element}" class="img-fluid">
                  </a>
              </div>
          </div>`;

            $(".inputrow_socials_preview").append(preview_html);
        }
        if (theme_type == 'theme7') {
            preview_html = `<div class="col-2 socials_${rowno}" id="socials_${rowno}">
                <div class="social-image-icon">
                    <a href="#"  class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">
                        <img src="${path}/${color}/social/${element.toLowerCase()}.svg" alt="${element}" class="img-fluid">
                    </a>
                </div>
            </div>`;
            $(".inputrow_socials_preview").append(preview_html);
        }
        if (theme_type == 'theme8') {


            preview_html = `<li class="d-flex align-items-center justify-content-start  socials_${rowno}" id="socials_${rowno}">
                <div class="left-section">
                    <div class="left-images">
                        <img src="${path}/${color}/social/${element.toLowerCase()}.svg" alt="${element}" class="img-fluid">
                    </div>
                </div>
                <div class="contact-text">
                    <h4  class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview">https://demo.rajodiya.com/</h4>
                    <span>${element}</span>
                </div>
            </li>`;

            $(".inputrow_socials_preview").append(preview_html);
        }
        if (theme_type == 'theme9') {

            preview_html = `<div class="col-2 socials_${rowno}" id="socials_${rowno}">
            <div class="social-image-icon">
                <a href="#"  class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">
                    <img src="${path}/social/${element.toLowerCase()}.svg" alt="${element}" class="img-fluid">
                </a>
            </div>
        </div>`;


            $(".inputrow_socials_preview").append(preview_html);
        }
        if (theme_type == 'theme10') {

            preview_html = `<div class="col-3 socials_${rowno}" id="socials_${rowno}">
            <div class="social-image-icon">
                <a href="#"  class="social_link_${rowno}_href_preview" id="social_link_${rowno}_href_preview" target="_blank">
                    <img src="${path}/${color}/social/${element.toLowerCase()}.svg" alt="${element}" class="img-fluid">
                </a>
            </div>
        </div>`;


            $(".inputrow_socials_preview").append(preview_html);
        }
        rowno++;

        $("#socialsModal").modal('hide');

    }

    $(`#${divid}`).append(html);
    console.log(preview_html);
    $(`#${divid}_preview`).append(preview_html);
    if (element_type == "contact") {
        checkcount('hide');
    }
    $("input").keyup(function() {
        var id = $(this).attr('id');
        //console.log(id);
        var preview = $(`#${id}`).val();
        $(`#${id}_preview`).text(preview);
    });

    $("textarea").keyup(function() {
        var id = $(this).attr('id');
        //console.log(id);
        var preview = $(`#${id}`).val();
        $(`#${id}_preview`).text(preview);
    });
    $(".social_href").keyup(function() {
        var id = $(this).attr('id');
        //console.log(id);
        var preview = $(`#${id}`).val();
        var h_preview = validURL(preview);
        //console.log(h_preview);
        if (h_preview == true) {
            $(`#${id}_error_href`).text("");
            $(`.${id}_href_preview`).attr("href", preview);
        } else {
            $(`#${id}_error_href`).text("Please enter valid link");
            $(`#${id}_href_preview`).attr("href", "#");
        }
        //var h_preview = `{{ url("") }}/${preview}`;

    });
    $( ".textboxhover" ).mouseover(function() {
        $( this ).removeClass( "border-0" );
    }).mouseout(function() {
        $( this ).addClass("border-0");
    });



    return rowno;
}

/*$(document).on('click', '#removeRow', function () {

    if($(this).data('id') == "testimonials"){
      $(this).closest('#inputFormRow3').remove();
    }
    if($(this).data('id') == "socials"){
      $(this).closest('#inputFormRow4').remove();
    }
});*/

function validURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return !!pattern.test(str);
}
$(document).on('click', '#removeRow_contact', function() {
    var this_id = $(this).data('id');
    $(`#${this_id}`).remove();
    $(this).closest('#inputFormRow').remove();
    checkcount('show');

});

$(document).on('click', '#removeRow_appointment', function() {
    var this_id = $(this).data('id');
    $(`#${this_id}`).remove();
    $(this).closest('#inputFormRow1').remove();

});

$(document).on('click', '#removeRow_services', function() {
    var this_id = $(this).data('id');
    $(`#${this_id}`).remove();
    $(this).closest('#inputFormRow2').remove();

});

$(document).on('click', '#removeRow_testimonials', function() {
    var this_id = $(this).data('id');
    $(`#${this_id}`).remove();
    $(this).closest('#inputFormRow3').remove();

});

$(document).on('click', '#removeRow_socials', function() {
    var this_id = $(this).data('id');
    $(`.${this_id}`).remove();
    $(this).closest('#inputFormRow4').remove();

});

$(".input-text-location").each(function () {
    var textarea = $(this);
    var text = textarea.text();
    var div = $('<div id="temp"></div>');
    div.css({
       "width":"530px"
    });
    div.text(text);
    $('body').append(div);
    var divHeight = $('#temp').height();
    div.remove();
    divHeight += 32;
    this.setAttribute("style", "height:" + divHeight + "px;overflow-y:hidden;");
  }).on("input", function () {
    this.style.height = "auto";
    this.style.height = (this.scrollHeight) + "px";
  });


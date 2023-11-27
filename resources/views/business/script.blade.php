<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    $(window).on('load', function () {
        changeToImg();
    });
function changeToImg() {
  const toImgArea = document.getElementById('boxes');
  
  // To avoid the image will be cut by scroll, we need to scroll top before html2canvas.
  window.pageYOffset = 0;
  document.documentElement.scrollTop = 0
  document.body.scrollTop = 0

  // transform to canvas
  html2canvas(toImgArea, {
    allowTaint: true,
    taintTest: false,
    type: "view",
  }).then(function (canvas) {
    const sreenshot = document.getElementById('previewImage');
    const downloadIcon = document.getElementById('download');
    const filename='{{$business->slug}}'; 
    canvas.style.width = "100%";
    sreenshot.appendChild(canvas);
    downloadIcon.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
    downloadIcon.download = filename+'.jpg';
    downloadIcon.click();
    document.getElementById('previewImage').innerHTML = "";
    setTimeout(function () {
            window.open(window.location, '_self').close();
        }, 2000);   
  });
}


</script>
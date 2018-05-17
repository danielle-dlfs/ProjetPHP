var canvas;
var context;
var imageObj = new Image();

function initCanvas() {
  // Get the canvas and the drawing context.
  canvas = document.getElementById("drawingCanvas");
  context = canvas.getContext("2d");

  // Attach the events that you need for drawing.
  canvas.onmousedown = startDrawing;
  canvas.onmouseup = stopDrawing;
  canvas.onmouseout = stopDrawing;
  canvas.onmousemove = draw;

  imageObj.onload = function() {
    context.drawImage(imageObj, 0, 0);
  };
}

var isDrawing = false;

function startDrawing(e) {
  // Start drawing.
  isDrawing = true;

  // Create a new path (with the current stroke color and stroke thickness).
  context.beginPath();

  // Put the pen down where the mouse is positioned.
  context.moveTo(e.pageX - canvas.offsetLeft, e.pageY - canvas.offsetTop);
}

function stopDrawing() {
  isDrawing = false;
}

function draw(e) {
  if (isDrawing == true) {
    // Find the new position of the mouse.
    var x = e.pageX - canvas.offsetLeft;
    var y = e.pageY - canvas.offsetTop;

    // Draw a line to the new position.
    context.lineTo(x, y);
    context.stroke();	
  }
}

// Keep track of the previous clicked <img> element for color.
var previousColorElement;

function changeColor(color, imgElement) {
  // Change the current drawing color.
  context.strokeStyle = color;

  // Give the newly clicked <img> element a new style.
  imgElement.className = "Selected";

  // Return the previously clicked <img> element to its normal state.
  if (previousColorElement != null) previousColorElement.className = "";
  previousColorElement = imgElement;
}

// Keep track of the previous clicked <img> element for thickness.
var previousThicknessElement;

function changeThickness(thickness, imgElement) {
  // Change the current drawing thickness.
  context.lineWidth = thickness;

  // Give the newly clicked <img> element a new style.
  imgElement.className = "Selected";

  // Return the previously clicked <img> element to its normal state.
  if (previousThicknessElement != null) previousThicknessElement.className = "";
  previousThicknessElement = imgElement;
}

function clearCanvas() {
  context.clearRect(0, 0, canvas.width, canvas.height);
}

function saveCanvas() { 
  // Find the <img> element.
  var imageCopy = document.getElementById("savedImageCopy");

  // Show the canvas data in the image.
  imageCopy.src = canvas.toDataURL();  

  // Unhide the <div> that holds the <img>, so the picture is now visible.
  var imageContainer = document.getElementById("savedCopyContainer");
  imageContainer.style.display = "block";
}

function callAjax(dataURL){
    // make ajax call to get image data url
    var request = new XMLHttpRequest();
    request.open('GET', dataURL, true);
    request.onreadystatechange = function() {
        // Makes sure the document is ready to parse.
        if(request.readyState == 4) {
            // Makes sure it's found the file.
            if(request.status == 200) {
                imageObj.src = request.responseText;
            }
        }
    };
    request.send(null);
}

function handleImage(e){
    var reader = new FileReader();
    var ctx = canvas.getContext('2d');
    reader.onload = function(event){
        var img = new Image();
        img.onload = function(){
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img,0,0);
        }
        img.src = event.target.result;
        // img.src = "http://www.leaders.com.tn/uploads/content/thumbnails/143324392872_content.jpg";
    }
    reader.readAsDataURL(e.target.files[0]);
}

$(document).ready(function(){
  initCanvas();

  $('.accordeon').accordion({
      animate: 250,
      heightStyle: "content"
  });

  $('#menuUpload').dialog({
      position: {
          my: "left top",
          at : "center bottom",
          of : $("body div:first")
      },
      closeOnEscape : true,
      autoOpen: false,
      show: {
          effect: "slide",
          duration: 250
      },
      hide: {
          effect: "drop",
          duration: 500
      }
  });

  $("div:first").click(function(evnt){
      evnt.preventDefault();
      $("#menuUpload").dialog('open');
  }).css({cursor: 'pointer'});

  $("#formWeb").submit(function(evnt){
      evnt.preventDefault();
      // imageObj.src = $('#formWeb [name=iWeb]').val();
      imageObj.src = $(this)[0].iWeb.value;
      $("#menuUpload").dialog("close");
  });

    $("#formAjax").submit(function(evnt){
        evnt.preventDefault();
        callAjax($(this)[0].iAjax.value);
        $("#menuUpload").dialog("close");
    });

  $("#imageLoader").change(function(evnt){
      handleImage(evnt);
      $('#menuUpload').dialog('close');
  });

  // COLORPICKER
  $('#colorSelector').ColorPicker({
      color: '#0000ff',
      onShow: function (colpkr) {
          $(colpkr).fadeIn(500);
          return false;
          },
      onHide: function (colpkr) {
          $(colpkr).fadeOut(500);
          return false;
      },
      onChange: function (hsb, hex, rgb) {
          $('#colorSelector div').css('backgroundColor', '#' + hex);
      }
  });
});
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Generador de Código de Barras Simple</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
  <script src="html2canvas.js"></script>
</head>
<style>
  @media screen{

  body{
    height: calc(100%);
    width: calc(100%);
  }
  }
  .container-fluid{
    height: calc(100%);

  }
  div#display {
    display: flex;
    height: 100%;
    width: 100%;
    align-items: center;
}
@media print{
  div#display {
    display: flex;
    height: auto;
    width: 100%;
    align-items: center;
}
}
#display #field,#display center {
    margin: auto;
}
#field img{
    height: 9vh;
    max-width: 100%
}
div#code {
    font-weight: 700;
    font-size: 17px;
    text-align: justify;
    text-align-last: justify;
}
</style>
<body class="alert-info text-dark">

<div class="container-fluid">
  <div class="col-md-12">
    <div class="row">
      <div class="card col-md-4 offset-md-4 mt-5">
        <div class="card-body text-center">
        <h4>Generador de Código de Barras Simple</h4>
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="card col-md-6 mt-5 mr-5">
        <div class="card-body">
          <div class="form-group">
            <label for="" class="control-label ">Código</label>
            <input type="text" id="code" class="form-control">
          </div>
           <div class="form-group">
            <label for="" class="control-label">Etiqueta</label>
            <input type="text" id="label" class="form-control">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Tipo de Código de Barras</label>
            <select class="browser-default custom-select" id="type">
              <option value="C128">Code 128</option>
              <option value="C128A">Code 128 A</option>
              <option value="C128B">Code 128 B</option>
              <option value="C39">Code 39</option>
              <option value="C39E">Code 39 E</option>
              <option value="C93">Code 93</option>
            </select>
          </div>
          <button type="button" class="col-md-2 btn-block float-right btn btn-primary btn-sm" id="generate">Generar</button>
        </div>
      </div>
      <div class=" card col-md-5 ml-5 mt-5" id='bcode-card'>
            <div class="card-body">
              <div id="display">
                <center>Código de Barras ConfiguroWeb</center>
              </div>
               
            </div>
            <div class="card-footer" style="display:none">
              <center>
                <button type="button" class=" btn-block btn btn-success btn-sm" id="print">Imprimir</button>
              <button type="button" class=" btn-block btn btn-primary btn-sm" id="save">Descargar</button>  
              </center>
              
            </div>
      </div>

    </div>
  </div>
  
</div>

</body>
</html>

<script>
  $('#generate').on('click',function(){
    if($('#code').val() != ''){
      $.ajax({
        url:'barcode.php',
        method:"POST",
        data:{code:$('#code').val(),type:$('#type').val(),label:$('#label').val()},
        error:err=>{
          console.log(err)
        },
        success:function(resp){
          $('#display').html(resp)
          $('#bcode-card .card-footer').show('slideUp')
        }
      })
    }
  })

    $('#save').click(function(){
    html2canvas($('#field'), {
    onrendered: function(canvas) {                    
      var img = canvas.toDataURL("image/png");
      
      var uri = img.replace(/^data:image\/[^;]/, 'data:application/octet-stream');
      
      var link = document.createElement('a');
          if (typeof link.download === 'string') {
              document.body.appendChild(link); 
              link.download = 'barcode_'+$('#code').val()+'.png';
              link.href = uri;
              link.click();
              document.body.removeChild(link);
          } else {
              location.replace(uri);
          }
      
    }
  }); 
  })
    $('#print').click(function(){
      var openWindow = window.open("", "", "_blank");
      openWindow.document.write($('#display').parent().html());
      openWindow.document.write('<style>'+$('style').html()+'</style>');
      openWindow.document.close();
      openWindow.focus();
      openWindow.print();
      // openWindow.close();
      setTimeout(function(){
      openWindow.close();
      },1000)
    })
</script>

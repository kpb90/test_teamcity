<html>

<head>

<title></title>

</head>

<body>

<script language=javascript type=text/javascript src="pages/dnk_editor_src.js"></script>

<script language=javascript type=text/javascript src="pages/config.js"></script>

<textarea id=elm1 name=elm1 style="width:100%;"></textarea>

<script language=JavaScript>

function GetById(id){if(document.getElementById){return document.getElementById(id);}else if(document.all){return document.all[id];}else if(document.layers){return document.layers[id];};return null;} 



d=window.opener.document;

id=<?php echo $_GET['id']; ?>;

n='attribute_' + id;

c=d.getElementById(n);

GetById('elm1').value=c.value;



function save()

{

  result=DNKEditor.getContent(DNKEditor.getWindowArg('editor_id'));

  d=window.opener.document;

  id=<?php echo $_GET['id']; ?>;

  n='attribute_' + id;

  c=d.getElementById(n);

  c.value=result;

  window.close();

}





</script>

<button onclick="javascript:save();">Сохранить изменения</button>

</body>

</html>
<?php



class class_template

{

	var $content;



  function LoadTemplate($id)

  {

    $a=afetchrowset(mysql_query("SELECT * FROM cms2_templates WHERE template_id = '".$id."'"));

    $this->content=$a[0]['content'];

  }



  function Replace($marker,$string)

  {

    if (is_array($marker) || is_array($string))

    {

      for($i=0;$i<sizeof($marker);$i++)

        $this->ReplaceS($marker[$i],$string[$i]);

    }

    else

    {

      $this->ReplaceS($marker,$string);

    }

  }



  function ReplaceS($marker,$string)

  {

    $this->content=str_replace($marker,$string,$this->content);

  }



  function Get()

  {

    return $this->$content;

  }

};



?>
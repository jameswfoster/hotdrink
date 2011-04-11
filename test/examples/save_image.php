<?php
$sheet = <<<EOS
sheet save_image_file {

  interface: {
    file_name : "";
    file_type : "bmp";
    compression_ratio : 100;
    image_quality : 100;
  }

  logic: {
    relate {
      compression_ratio <== 100 - 4 * (100 - image_quality);
      image_quality <== 100 - (100 - compression_ratio) / 4;
    }
  }

  output: {
    result <== (file_type == "jpeg") ?
      { type: file_type, name: file_name, ratio: compression_ratio } :
      { type: file_type, name: file_name }; 
  }

  invariant: {
    check_name <== file_name != "";
  }

}
EOS;

$html = <<<EOS
<style type="text/css">
#SaveImage { border: 1px solid black; padding: 1em; margin: 1em; }
#SaveImage fieldset label { display: block; margin: .5em; }
</style>

<form id="SaveImage">

<fieldset><legend>Save Image</legend>
<label>File name : <input type="text" id="file_name" /></label>
<label>Save as type :
<select id="file_type">
  <option value="bmp">Bitmap (*.bmp)</option>
  <option value="jpeg">JPEG (*.jpg,*.jpeg)</option>
</select>
</label>
<label>Compression ratio (%) : <input type="text" id="compression_ratio" /></label>
<label>Image quality (%) : <input type="text" id="image_quality" /></label>
</fieldset>

<button type="button" id="result" command="save_image" >Save</button>
</form>
EOS;

$layout = <<<EOS
view {
  text (label : "File name", value : file_name);
  dropdown (
    label : "Save as type", 
    items : [
      { name : "Bitmap (.bmp)", value : "bmp" },
      { name : "JPEG (.jpeg)", value : "jpeg" }
    ],
    value : file_type
  );
  number (   
    label : "Compression ratio",
    units : "%",
    value : compression_ratio
  );
  number (
    label : "Image quality",
    units : "%",
    value : image_quality
  );
  commandButton (   
    label : "Save",
    value : result
  );
}
EOS;

?>


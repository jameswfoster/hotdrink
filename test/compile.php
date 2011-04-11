<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Hotdrink - Test</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<link type="text/css" rel="stylesheet" href="css/index.css" />
<link type="text/css" rel="stylesheet" href="css/eve.css" />
<script type="text/javascript" src="js/flapjax.js"></script>
<script type="text/javascript" src="js/flapjax_ext.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/hotdrink.js"></script>
<script type="text/javascript">
/* <![CDATA[ */

function loader() {
  /* Sources. */
  var treesB = $B("trees").calmB(1000);

  var factory = new hotdrink.controller.Factory();
  hotdrink.controller.view.html.registerWidgetsForCompile(factory);

  liftB(function (trees) {
    try {
      trees = trees.evalJSON(true);
    } catch (e) {
      trees = [];
    }
    $("html").update(factory.compile(trees));
  }, treesB);
}

var selectPage = function (elt) {
  //assert(elt.tagName.toLowerCase() === "select");
  var url = elt.options[elt.selectedIndex].readAttribute("value");
  if (url != null) {
    /* Redirect. */
    window.location=url;
  }
}

/* ]]> */
</script>
</head>
<body onload="loader();">
<script type="text/javascript" src="js/context_menu.js"></script>
<!--script type="text/javascript">enableDebug();</script-->
<?php
$examples = array(
    "addressform" => "Address form",
    "alert" => "Alert",
    "calculator" => "Calculator",
    "debug" => "Debug",
    "grouped_options" => "Grouped options",
    "hello" => "Hello",
    "minmax" => "Min-max",
    "enforced_minmax" => "Enforced min-max",
    "multi_view" => "Multi-element widgets",
    "preset" => "Preset",
    "radio" => "Radio buttons",
    "resize_image" => "Resize image",
    "save_image" => "Save image",
    "screen" => "Screen",
    "surveyform" => "Survey form",
    "temperature" => "Temperature"
  );

$eg = null;
$trees = "";

if (array_key_exists("eg", $_GET)) {
  $eg = $_GET["eg"];
  $eg_file = "examples/".$eg.".php";
  if (array_key_exists($eg, $examples)) {
    include $eg_file;
    $eg_display_name = $examples[$eg];
    //echo "Loaded \"".$eg_display_name."\" example.<br />";
  } elseif (file_exists($eg_file)) {
    include $eg_file;
    $eg_display_name = $eg;
  } else {
    //echo "\"".$eg."\" example not found.<br />";
  }
} else {
  //echo "No example requested.<br />";
}

?>
<div id="menu">
<label>Choose example: 
  <select onchange="selectPage(this);">
    <option value="compile.php" <?php echo ($eg == null) ? ("selected=\"selected\"") : ("") ?> >
    (none)
    </option>
<?php
foreach ($examples as $key => $value) {
  echo "<option value=\"compile.php?eg=$key\"";
  if ($eg == $key) echo " selected=\"selected\"";
  echo ">\n";
  echo "$value\n";
  echo "</option>\n";
}
?>
  </select>
</label>
</div>

<label>HTML
<div id="html"></div>
</label>
<div id="sources">
  <label>Eve
    <textarea id="trees" rows="24" cols="80"><?php echo htmlspecialchars($trees);?></textarea>
  </label>
</div>
</body>
</html>

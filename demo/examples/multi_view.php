<?php

$sheet = <<<EOS
sheet test {
  interface : {
    x : true;
    a : false; // single checkbox
    b : []; // multiple checkbox
    c : "yes"; // radio
    d : true; // radio
  }
  
  logic : {
    xgroup <== x ? {a: a, b: b, c: c} : {};
  }
  
  output : {
    result <== {xgroup: xgroup, d: d};
  }
}
EOS;

$html = <<<EOS
<style type="text/css">
#form { border: 1px solid black; padding: 1em; margin: 1em; }
#form label { display: block; }
</style>

<form id="form">
<label>X : <input type="checkbox" id="x"> Enable/Disable all below</input></label>
<label>A : <input type="checkbox" id="a"></input></label>
<label>B-1 : <input type="checkbox" id="b" name="b" value="1" /></label>
<label>B-2 : <input type="checkbox" name="b" value="2" /></label>
<label>B-3 : <input type="checkbox" name="b" value="3" /></label>
<div>C : <input type="radio" id="c" name="c" value="yes" />Yes <input type="radio" name="c" value="no" />No</div>

<button type="button" id="result">OK</button>
</form>
EOS;

$trees = <<<EOS
[
  {
    "type" : "checkbox",
    "options" : {
      "label" : "X",
      "id" : "x",
      "bindValue" : "x"
    }
  },

  {
    "type" : "checkbox",
    "options" : {
      "label" : "A",
      "id" : "a",
      "bindValue" : "a"
    }
  },

  {
    "type" : "checkboxGroup",
    "options" : {
      "label" : "B",
      "items" : [
        { "name" : "B-1", "value" : "1" },
        { "name" : "B-2", "value" : "2" },
        { "name" : "B-3", "value" : "3" }
      ],
      "id" : "b",
      "bindValue" : "b"
    }
  },

  {
    "type" : "radioGroup",
    "options" : {
      "label" : "C",
      "items" : [
        { "name" : "Yes", "value" : "yes" },
        { "name" : "No", "value" : "no" }
      ],
      "id" : "c",
      "bindValue" : "c"
    }
  },

  {
    "type" : "commandButton",
    "options" : {
      "label" : "OK",
      "id" : "result",
      "bindValue" : "result"
    }
  }
]
EOS;

$layout = <<<EOS
view {
  checkbox (label : "X", value : x);
  
  checkbox (label : "A", value : a);
  
  checkboxGroup (
    label : "B",
    items : [
      { name : "B-1", value : "1" },
      { name : "B-2", value : "2" },
      { name : "B-3", value : "3" }
    ],
    value : b
  );
  
  radioGroup (
    label : "C",
    items : [
      { name : "Yes", value : "yes" },
      { name : "No", value : "no" }
    ],
    value : c
  );
  
  radioGroup (
    label : "D",
    items : [
      { name : "True", value : true },
      { name : "False", value : false }
    ],
    value : d
  );
  
  commandButton (label : "OK", value : result);
}
EOS;

?>
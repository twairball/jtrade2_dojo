<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr">
    
    <head>
        <style type="text/css">
            body, html { font-family:helvetica,arial,sans-serif; font-size:90%; }
        </style>
		<script type="text/javascript" src="/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
        <!--
		<script src="http://ajax.googleapis.com/ajax/libs/dojo/1.6/dojo/dojo.xd.js"
        djConfig="parseOnLoad: true">
        </script>
        -->
		<script type="text/javascript">
            dojo.require("dijit.form.Button");
            dojo.require("dijit.Dialog");
	dojo.require("dojo.data.ItemFileReadStore");
	dojo.require("dijit.form.Form");
	dojo.require("dijit.form.Select");	
	dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.Button");
	dojo.require("dijit.Menu");
    dojo.require("dijit.form.FilteringSelect");
	dojo.require("dijit.Dialog");
	
	
            dojo.addOnLoad(function() {
                // create the dialog:
                var dialogColor = dijit.byId("dialogColor");

                // connect t the button so we display the dialog onclick:
                dojo.connect(dijit.byId("button4"), "onClick", dialogColor, "show");
            });
        </script>
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/dojo/1.6/dijit/themes/claro/claro.css"
        />
    </head>
    
    <body class=" claro ">
        <style type="text/css">
            #dialogColor_underlay { background-color:green; }
        </style>
        <div id="dialogColor" title="Colorful" dojoType="dijit.Dialog">
            My background color is Green
        </div>
        <p>
            When pressing this button the dialog will popup:
        </p>
        <button id="button4" data-dojo-type="dijit.form.Button" type="button">
            Show me!
        </button>

    </body>

</html>
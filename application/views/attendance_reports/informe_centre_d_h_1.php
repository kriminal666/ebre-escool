<!-- Date Picker -->
<script>
$(function() {
$( "#data_informe" ).datepicker({ dateFormat: 'dd-mm-yy' });
});
</script>

<!-- ComboBox -->
 <style>
.custom-combobox {
position: relative;
display: inline-block;
}
.custom-combobox-toggle {
position: absolute;
top: 0;
bottom: 0;
margin-left: -1px;
padding: 0;
/* support: IE7 */
*height: 1.7em;
*top: 0.1em;
}
.custom-combobox-input {
margin: 0;
padding: 0.3em;
}
</style>

 <script>
(function( $ ) {
$.widget( "custom.combobox", {
_create: function() {
this.wrapper = $( "<span>" )
.addClass( "custom-combobox" )
.insertAfter( this.element );
this.element.hide();
this._createAutocomplete();
this._createShowAllButton();
},
_createAutocomplete: function() {
var selected = this.element.children( ":selected" ),
value = selected.val() ? selected.text() : "";
this.input = $( "<input>" )
.appendTo( this.wrapper )
.val( value )
.attr( "title", "" )
.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
.autocomplete({
delay: 0,
minLength: 0,
source: $.proxy( this, "_source" )
})
.tooltip({
tooltipClass: "ui-state-highlight"
});
this._on( this.input, {
autocompleteselect: function( event, ui ) {
ui.item.option.selected = true;
this._trigger( "select", event, {
item: ui.item.option
});
},
autocompletechange: "_removeIfInvalid"
});
},
_createShowAllButton: function() {
var input = this.input,
wasOpen = false;
$( "<a>" )
.attr( "tabIndex", -1 )
.attr( "title", "Show All Items" )
.tooltip()
.appendTo( this.wrapper )
.button({
icons: {
primary: "ui-icon-triangle-1-s"
},
text: false
})
.removeClass( "ui-corner-all" )
.addClass( "custom-combobox-toggle ui-corner-right" )
.mousedown(function() {
wasOpen = input.autocomplete( "widget" ).is( ":visible" );
})
.click(function() {
input.focus();
// Close if already visible
if ( wasOpen ) {
return;
}
// Pass empty string as value to search for, displaying all results
input.autocomplete( "search", "" );
});
},
_source: function( request, response ) {
var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
response( this.element.children( "option" ).map(function() {
var text = $( this ).text();
if ( this.value && ( !request.term || matcher.test(text) ) )
return {
label: text,
value: text,
option: this
};
}) );
},
_removeIfInvalid: function( event, ui ) {
// Selected an item, nothing to do
if ( ui.item ) {
return;
}
// Search for a match (case-insensitive)
var value = this.input.val(),
valueLowerCase = value.toLowerCase(),
valid = false;
this.element.children( "option" ).each(function() {
if ( $( this ).text().toLowerCase() === valueLowerCase ) {
this.selected = valid = true;
return false;
}
});
// Found a match, nothing to do
if ( valid ) {
return;
}
// Remove invalid value
this.input
.val( "" )
.attr( "title", value + " didn't match any item" )
.tooltip( "open" );
this.element.val( "" );
this._delay(function() {
this.input.tooltip( "close" ).attr( "title", "" );
}, 2500 );
this.input.data( "ui-autocomplete" ).term = "";
},
_destroy: function() {
this.wrapper.remove();
this.element.show();
}
});
})( jQuery );
$(function() {
$( "#hora_informe" ).combobox();
$( "#toggle" ).click(function() {
$( "#hora_informe" ).toggle();
});
});
</script>

<!-- TITLE -->
<div style='height:30px;'></div>
	<div style="margin:10px;">
		<h2><?php echo lang('reports_educational_center_reports_incidents_by_day_and_hour'); ?></h2>
	</div>    


	<!-- FORM -->    
	<div style="width:40%; margin:0px auto;">
		<form method="post" action="#" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group">
					<tr>
						<td><label for="data_informe">Write Date:</label></td>
						<td><input class="form-control" id="data_informe" type="text" name="data" value="<?php echo date("d/m/Y")?>"/></td>
					</tr>
				</div>		
				<div class="ui-widget">
					<tr>
						<td><laber for="hora_informe">Select the time:</label></td>
						<td><select class="selectpicker" id="hora_informe" name="hora">
							<?php foreach ($hores as $key => $value) { ?>
								<option value="<?php echo $key ?>" <?php if($key==1){?> selected <?php } ?> ><?php echo $value ?></option>
							<?php } ?>
							</select>		
						</td>
					</tr>	
				</div>
				<div class="form-group">
					<tr>
						<td valign="top"><label for="incident">Select the type of incident:</label></td>
						<td>
							<input type="checkbox" name="F" value="1" checked> F</input><br />
							<input type="checkbox" name="FJ" value="2" checked> FJ</input><br />
							<input type="checkbox" name="R" value="3" checked> R</input><br />
							<input type="checkbox" name="RJ" value="4" checked> RJ</input><br />
							<input type="checkbox" name="E" value="5" checked> E</input>
						</td>
					</tr>	
				</div>
				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td></tr>
			</table>
		</form>
	</div>
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
$( "#grup" ).combobox();
$( "#toggle" ).click(function() {
$( "#grup" ).toggle();
});
});
</script>



<!-- TITLE -->
<div style='height:30px;'></div>
	<div style="margin:10px;">
		<h2><?php echo lang('reports_group_reports_student_sheet'); ?></h2>
	</div> 

	<!-- FORM -->    
	<div style="width:40%; margin:0px auto;">
		<form method="post" action="#" class="form-horizontal" role="form">
			<table class="table table-bordered" cellspacing="10" cellpadding="5">
				<div class="form-group ui-widget">
					<tr>
						<td><label for="grup">Selecciona el grup:</label></td>
						<td><select class="selectpicker" id="grup" name="grup">
								<option value="1AF">1AF - *1r Adm.Finan (S) - CF</option>
								<option value="1APD">1APD - *1r Atenc. Persones Dep.M) - CF</option>
								<option value="1ASIX-DAM">1ASIX-DAM - *1r Inform. superior (S)L - CF</option>
								<option value="1DIE">1DIE - 1r Diet - CF</option>
								<option value="1EE">1EE - *1r Efic. Energ.(S) L - CF</option>
								<option value="1EIN">1EIN - *1r Educaci - CF</option>
								<option value="1ES">1ES - *1r Emerg. Sanit.(M)L - CF</option>
								<option value="1FAR">1FAR - *1r Farm - CF</option>
								<option value="1GAD">1GAD - *Gesti - CF</option>
								<option value="1IEA">1IEA - *1r Ins.Elec. Autom(M)L - CF</option>
								<option value="1IME">1IME - *1r Ins. Mant. Elec.(M) - CF</option>
								<option value="1INS A">1INS A - *1r Int.Soc.(S)L - CF</option>
								<option value="1INS B">1INS B - 1r Int. Soc.(S)L - CF</option>
								<option value="1LDC">1LDC - *1r Lab. Diagnosi C (S). - CF</option>
								<option value="1MEC">1MEC - *1r Mecanitzaci - CF</option>
								<option value="1PM">1PM - *1r Prod. Mecanitza(S)L. - CF</option>
								<option value="1PRO">1PRO - *1r D. A. Projec. C (S) L - CF</option>
								<option value="1PRP">1PRP - 1r Prev. Riscos Prof.(S) - CF</option>
								<option value="1SEA">1SEA - i automa (S) - CF</option>
								<option value="1SMX A">1SMX A - *1r Inform Mitj - CF</option>
								<option value="1SMX B">1SMX B - *1r Inform. mitj - CF</option>
								<option value="1STI">1STI - 1r Sis. Teleco. Infor (S) - CF</option>
								<option value="2AF">2AF - 2n Ad. Finan (S) - CF</option>
								<option value="2APD">2APD - 2n Atenc. Persones Dep.M) - CF</option>
								<option value="2ASIX">2ASIX - 2n Adm Sist Inf xarxa(S)L - CF</option>
								<option value="2DAM">2DAM - 2n Desenv Aplic Mult (S)L - CF</option>
								<option value="2DIE">2DIE - 2n Diet - CF</option>
								<option value="2EE">2EE - 2 Efic.Energ.(S) L - CF</option>
								<option value="2EIN">2EIN - 2n Educaci - CF</option>
								<option value="2ES">2ES - 2n Emerg. Sanit.(M) - CF</option>
								<option value="2FAR">2FAR - 2n Farm - CF</option>
								<option value="2GAD">2GAD - 2n Gest. Adm. (M)L - CF</option>
								<option value="2IEA">2IEA - *2n Ins.Elec,Autom(M)L - CF</option>
								<option value="2IME">2IME - 2n Ins. Mant. Elec.(M) - CF</option>
								<option value="2INS A">2INS A - 2n Integraci - CF</option>
								<option value="2INS B">2INS B - 2n Integraci - CF</option>
								<option value="2LDC">2LDC - 2n Lab. Diagnosi C(S) - CF</option>
								<option value="2MEC">2MEC - 2n Mecanitzaci - CF</option>
								<option value="2PM">2PM - *2n Prod. Mecanitza.(S) L - CF</option>
								<option value="2PRO">2PRO - 2n D. A. Projec. C (S) - CF</option>
								<option value="2PRP">2PRP - 2n Prev. Riscos Prof.(S) - CF</option>
								<option value="2SEA">2SEA - *2n Sist. Electri i automa (S) - CF</option>
								<option value="2SIC">2SIC - 2n Soldadura i caldereria (M)  - CF</option>
								<option value="2SMX">2SMX - 2n Inform. Mitj - CF</option>
								<option value="2STI">2STI - 2n Sis. teleco. Infor (S) - CF</option>
								<option value="CAIA">CAIA - *Cures Auxiliar Inf(M) - CF</option>
								<option value="CAIB">CAIB - *Cures Auxiliar Inf(M) - CF</option>
								<option value="CAIC">CAIC - Cures Auxiliar Inf(M) - CF</option>
								<option value="CAM">CAM - *Curs Acc - CF</option>
								<option value="CAS A">CAS A - *Curs Acc - CF</option>
								<option value="CAS B">CAS B - *Curs Acc - CF</option>
								<option value="CAS C">CAS C - Curs Acc - CF</option>
								<option value="COM">COM - *Comer - CF</option>
								<option value="GCM">GCM - Ges. Comer. Mar.(S) - CF</option>
								<option value="SE">SE - Secretariat (S) - CF</option>
							</select>		
						</td>
					</tr>	
				</div>
				<div class="form-group">
					<tr>
						<td colspan="2" style="text-align:center;"><input type="submit" value="Veure l'informe" class="btn btn-primary"/></td>
					</tr>
			</table>
		</form>
	</div>		
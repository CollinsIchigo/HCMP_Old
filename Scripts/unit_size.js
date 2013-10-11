   (function( $ ) {
        $.widget( "ui.combobox", {
            _create: function() {
                var input,
                    that = this,
                    select = this.element.hide(),
                    selected = select.children( ":selected" ),
                    value = selected.val() ? selected.text() : "",
                    wrapper = this.wrapper = $( "<span>" )
                        .addClass( "ui-combobox" )
                        .insertAfter( select );
 
                function removeIfInvalid(element) {
                    var value = $( element ).val(),
                        matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
                        valid = false;
                    select.children( "option" ).each(function() {
                        if ( $( this ).text().match( matcher ) ) {
                            this.selected = valid = true;
                            return false;
                        }
                    });
                    if ( !valid ) {
                        // remove invalid value, as it didn't match anything
                        $( element )
                            .val( "" )
                            .attr( "title", value + " didn't match any item" )
                            .tooltip( "open" );
                        select.val( "" );
                        setTimeout(function() {
                            input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        input.data( "autocomplete" ).term = "";
                        return false;
                    }
                }
 
                input = $( "<input>" )
                    .appendTo( wrapper )
                    .val( value )
                    .attr( "title", "" )
                    .addClass( "ui-state-default ui-combobox-input" )
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: function( request, response ) {
                            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                            response( select.children( "option" ).map(function() {
                                var text = $( this ).text();
                                if ( this.value && ( !request.term || matcher.test(text) ) )
                                    return {
                                        label: text.replace(
                                            new RegExp(
                                                "(?![^&;]+;)(?!<[^<>]*)(" +
                                                $.ui.autocomplete.escapeRegex(request.term) +
                                                ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                            ), "<strong>$1</strong>" ),
                                        value: text,
                                        option: this
                                    };
                            }) );
                        },
                        select: function( event, ui ) {
                            ui.item.option.selected = true;
                            that._trigger( "selected", event, {
                                item: ui.item.option
                            });
                        },
                        change: function( event, ui ) {
                            if ( !ui.item )
                                return removeIfInvalid( this );
                        }
                    })
                    .addClass( "ui-widget ui-widget-content ui-corner-left" );
 
                input.data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + item.label + "</a>" )
                        .appendTo( ul );
                };
 
                $( "<a>" )
                    .attr( "tabIndex", -1 )
                    .attr( "title", "Show All Items" )
                    .tooltip()
                    .appendTo( wrapper )
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass( "ui-corner-all" )
                    .addClass( "ui-corner-right ui-combobox-toggle" )
                    .click(function() {
                        // close if already visible
                        if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
                            input.autocomplete( "close" );
                            removeIfInvalid( input );
                            return;
                        }
 
                        // work around a bug (likely same cause as #5265)
                        $( this ).blur();
 
                        // pass empty string as value to search for, displaying all results
                        input.autocomplete( "search", "" );
                        input.focus();
                    });
 
                    input
                        .tooltip({
                            position: {
                                of: this.button
                            },
                            tooltipClass: "ui-state-highlight"
                        });
            },
 
            destroy: function() {
                this.wrapper.remove();
                this.element.show();
                $.Widget.prototype.destroy.call( this );
            }
        });
    })( jQuery );
   
    function get_unit_quantity(value){
    	
    	
    	if(value=="Box of 25"){
    		return 25;
    	}
    	if(value=="Box of 100"){
    		return 100;
    	}
    	if(value=="50ml x 10 bottles"){
    		return 10;
    	}
    	if(value==null){
    		return 1;
    	}
    	var new_value=value+"x";
    	
    	var array_value=new_value.split("x");
    	var array_0=array_value[0];
    	
    	
///////////////////////////////////////////////////////////////
    	
    	var array_1=array_0.replace( /[\s\n\r]+/g, '' );
    	
    	
    	
    	switch(array_1)    
	 
{
  case '250g':
  return  1;
  break;
  case '500mL':
  return  1;
  break;
  case '100mL':
  return  1;
  break;
  case '250mL':
  return  1;
  break;
  case '50mL':
  return  1;
  break;
  case '75mL':
  return  1;
  break;
  case '30mL':
  return  1;
  break;
  case 'pack':
   return  1;
  case 'Piece':
   return  1;
  break;
  case 'piece':
   return  1;
  break;
  case 'Pair':
   return  1;
  break;
   case 'pair':
   return  1;
  break;
  case 'tube':
   return  1;
  break;
  case 'tubes':
   return  1;
  break;
   case 'Tubes':
   return  1;
  break;
  case 'Roll':
   return  1;
  break;
   case 'roll':
   return  1;
  break;
  case 'Ampoule':
   return  1;
  break;
  case 'Each':
   return  1;
  break;
  case 'bottle':
   return  1;
  break;
  case 'vial':
   return  1;
  break;
  case "5's":
   return  1;
  break;
  case 'Jar':
   return  1;
  break;
  case '5L':
   return  1;
  break;
    case 'Satchets':
   return  1;
  break;
  case 'Tablets':
   return  1;
  break;
  case 'Caps':
   return  1;
  break;
  case 'Bottles':
   return  1;
  break;
  case 'Vials':
   return  1;
  break;
   case "Packof3's":
   return  3;
   break;
    case "3x21":
   return  3;
   break;
    case "3x35":
   return  3;
   break;
   case "4*5L":
   return  4;
  break;
  case 'Boxof10':
   return  10;
  break;
     case 'Packof10':
  return  10;
  break;
    case '10sets':
  return  10;
  break;
   case 'Pack(10)':
   return  10;
  break;
   case 'Dozen':
   return  12;
  break;
  case 'Boxof25':
  return  25;
  break;
   case "Blistersof6's":
   return  30;
  break;
  case "Blistersof12's":
   return  30;
  break;
  case "Blistersof18's":
   return  30;
  break;
  case "Blistersof24's":
   return  30;
  break;
  case '50 pairs':
  return  50;
  break;
  case '50 sets':
  return  50;
  break;
   case 'Packof50': 
   return  50;
  break;
   case 'Packof50pairs': 
   return  50;
  break;
  case '100 Vials':
  return  100;
  case 'Boxof100':
   return  100;
  break;
    case 'Kit(100vials)':
   return  100;
    case '100mL*100':
   return  100;
  break;
   case '100*50mL':
   return  100;
  break;
   case '100*30mL':
   return  100;
  break;
  case 'Packof100':
   return  100;
  break;
  case 'Pack(200)':
   return  200;
  break;
  case 'Packof200':
   return  200;
  break;
  
default:
  return  parseInt(array_0.replace(",", "").replace("'s",""));
}
    	
    	
    	
    }
    
    function suggest_order_value(value){
    var i=value;
    
  
    
    var unit_size=parseInt(get_unit_quantity($(document.getElementsByName("unit_size["+i+"]")).val()));
    
    var opening_balance= parseInt($(document.getElementsByName("open["+i+"]")).val());
  
    var total_receipts=	parseInt($(document.getElementsByName("receipts["+i+"]")).val());

    var total_issues=	parseInt($(document.getElementsByName("historical["+i+"]")).val());
  
    var adjustments=	parseInt($(document.getElementsByName("adjustments["+i+"]")).val());
   
    var losses=	parseInt($(document.getElementsByName("losses["+i+"]")).val());
   
    var closing=parseInt($(document.getElementsByName("closing_stock_["+i+"]")).val());
   
    var days=	parseInt($(document.getElementsByName("days["+i+"]")).val());
    
    var new_order_value=0;
    
  
    closing=closing/unit_size;
 
    new_order_value=((total_issues*4)-closing);
  
    new_order_value=parseInt(new_order_value);
    if(new_order_value<0){
    	new_order_value =0;
    }

    
    $(document.getElementsByName("suggested["+i+"]")).val(new_order_value);
    //$(document.getElementsByName("quantity["+i+"]")).val(new_order_value);
    	
    }
    
    
    
 function number_format (number, decimals, dec_point, thousands_sep) {
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *    example 10: number_format('1.20', 2);
    // *    returns 10: '1.20'
    // *    example 11: number_format('1.20', 4);
    // *    returns 11: '1.2000'
    // *    example 12: number_format('1.2000', 3);
    // *    returns 12: '1.200'
    // *    example 13: number_format('1 000,50', 2, '.', ' ');
    // *    returns 13: '100 050.00'
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
   
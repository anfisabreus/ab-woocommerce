$(function() {
$( "#accordion" ).accordion({
      collapsible: true,
      heightStyle: "content",
       
       
       create: function(event, ui) {
            //get index in cookie on accordion create event
            if($.cookie('saved_index') != null){
               act =  parseInt($.cookie('saved_index'));
            }
        },
        activate: function(event, ui) {
            //set cookie for current index on change event
            var active = jQuery("#accordion").accordion('option', 'active');
            $.cookie('saved_index', null);
            $.cookie('saved_index', active);
        },
        active:parseInt($.cookie('saved_index'))

    
      })
 .sortable({
axis: "y",
handle: "h3",
update: function(event, ui) {
var postData = $(this).sortable('toArray').toString();
$("textarea#levelsortablenew").text(postData);

}
});

 $( "#tabs" ).tabs();

});
$(function() {


          $("#responder1").click(function(){
             $("#div_name").show();
          });
           $("#responder2").click(function(){
             $("#div_name").hide();
          });
          $("#responder3").click(function(){
             $("#div_name").hide();
          });
           $("#responder4").click(function(){
             $("#div_name").hide();
          });
          
            $("#responder5").click(function(){
             $("#div_name").hide();
          });
          
           $("#responder6").click(function(){
             $("#div_name").hide();
          });
          
           $("#responder7").click(function(){
             $("#div_name").hide();
          });
           $("#responder8").click(function(){
             $("#div_name").hide();
          });
          
          
          //#div_name
          
          
          

          $("#responder1").click(function(){
             $("#div_name1").show();
          });
        
          $("#responder2").click(function(){
             $("#div_name1").hide();
          });
          
           $("#responder3").click(function(){
             $("#div_name1").hide();
          });
           $("#responder4").click(function(){
             $("#div_name1").hide();
          });
          
           $("#responder5").click(function(){
             $("#div_name1").hide();
          });
          
          $("#responder6").click(function(){
             $("#div_name1").hide();
          });
          
          $("#responder7").click(function(){
             $("#div_name1").hide();
          });
           $("#responder8").click(function(){
             $("#div_name1").hide();
          });
          
          //#div_name1
          
          
             $("#responder2").click(function(){
             $("#div_name2").show();
          });
        
          $("#responder1").click(function(){
             $("#div_name2").hide();
          });
          
           $("#responder3").click(function(){
             $("#div_name2").hide();
          });
          
          $("#responder4").click(function(){
             $("#div_name2").hide();
          });
          
           $("#responder5").click(function(){
             $("#div_name2").hide();
          });
          
           $("#responder6").click(function(){
             $("#div_name2").hide();
          });
          
           $("#responder7").click(function(){
             $("#div_name2").hide();
          });
          
           $("#responder8").click(function(){
             $("#div_name2").hide();
          });
          
          
          
          //#div_name2
          
          
          
          
          $("#responder3").click(function(){
             $("#div_name3").show();
          });
       
            $("#responder1").click(function(){
             $("#div_name3").hide();
          }); 
          
           $("#responder2").click(function(){
             $("#div_name3").hide();
          });  
          
           $("#responder4").click(function(){
             $("#div_name3").hide();
          }); 
           $("#responder5").click(function(){
             $("#div_name3").hide();
          }); 
          
           $("#responder6").click(function(){
             $("#div_name3").hide();
          }); 
          
           $("#responder7").click(function(){
             $("#div_name3").hide();
          }); 
          
           $("#responder8").click(function(){
             $("#div_name3").hide();
          });
          
          //#div_name3
          
          
          $("#responder4").click(function(){
             $("#div_name4").show();
          });
       
            $("#responder1").click(function(){
             $("#div_name4").hide();
          }); 
          
           $("#responder2").click(function(){
             $("#div_name4").hide();
          });   
          $("#responder3").click(function(){
             $("#div_name4").hide();
          }); 
           $("#responder5").click(function(){
             $("#div_name4").hide();
          }); 
          
           $("#responder6").click(function(){
             $("#div_name4").hide();
          }); 
          
           $("#responder7").click(function(){
             $("#div_name4").hide();
          }); 
          
           $("#responder8").click(function(){
             $("#div_name4").hide();
          });
          
          //#div_name4
          
          
           $("#responder5").click(function(){
             $("#div_name5").show();
          });
 
            $("#responder1").click(function(){
             $("#div_name5").hide();
          }); 
          
           $("#responder2").click(function(){
             $("#div_name5").hide();
          });   
          $("#responder3").click(function(){
             $("#div_name5").hide();
          }); 
           $("#responder4").click(function(){
             $("#div_name5").hide();
          }); 
          
            $("#responder6").click(function(){
             $("#div_name5").hide();
          }); 
          
            $("#responder7").click(function(){
             $("#div_name5").hide();
          }); 
          
           $("#responder8").click(function(){
             $("#div_name5").hide();
          });
          
          
          //#div_name5
          
          
               $("#responder6").click(function(){
             $("#div_name6").show();
          });
     
            $("#responder1").click(function(){
             $("#div_name6").hide();
          }); 
          
           $("#responder2").click(function(){
             $("#div_name6").hide();
          });   
          $("#responder3").click(function(){
             $("#div_name6").hide();
          }); 
           $("#responder4").click(function(){
             $("#div_name6").hide();
          }); 
          
            $("#responder5").click(function(){
             $("#div_name6").hide();
          }); 
          
            $("#responder7").click(function(){
             $("#div_name6").hide();
          }); 
          
           $("#responder8").click(function(){
             $("#div_name6").hide();
          });
          
          
          //#div_name6
          
          
            $("#responder7").click(function(){
             $("#div_name7").show();
          });
          
          
       
            $("#responder1").click(function(){
             $("#div_name7").hide();
          }); 
          
           $("#responder2").click(function(){
             $("#div_name7").hide();
          });   
          $("#responder3").click(function(){
             $("#div_name7").hide();
          }); 
           $("#responder4").click(function(){
             $("#div_name7").hide();
          }); 
          
            $("#responder5").click(function(){
             $("#div_name7").hide();
          }); 
          
            $("#responder6").click(function(){
             $("#div_name7").hide();
          }); 
          
            $("#responder8").click(function(){
             $("#div_name7").hide();
          }); 
           
           //#div_name7
           
           
           
           
         
           $("#responder8").click(function(){
             $("#div_name8").show();
          });
          
          
          $("#responder1").click(function(){
             $("#div_name8").hide();
          }); 
          
           $("#responder2").click(function(){
             $("#div_name8").hide();
          });   
          $("#responder3").click(function(){
             $("#div_name8").hide();
          }); 
           $("#responder4").click(function(){
             $("#div_name8").hide();
          }); 
          
            $("#responder5").click(function(){
             $("#div_name8").hide();
          }); 
          
            $("#responder6").click(function(){
             $("#div_name8").hide();
          }); 
          
          
           $("#responder7").click(function(){
             $("#div_name8").hide();
          });
          
          

          
        $('.checkresponder').show(); 
        
        });

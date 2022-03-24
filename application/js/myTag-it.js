            var available_tags = [];
        
            function getJsonAutoComplete(){
                $.getJSON( "AutoComplete.json", function( data ) {
                    $(data).each(function (i){
                        available_tags.push(data[i]);
                    });
                });
            }
            /*
            function loadTags(){
                $.getJSON( "tags.json", function( data ) {
                    $(data).each(function (i){
                        $('#allowSpacesTags').tagit('createTag', data[i].tag);
                    });       
                });
            }
			*/
			
			var loading = false;
			function loadTagsAddedAjax() {
				var case_id = $('#allowSpacesTags').data("case_id");
				$.ajax({
					type: 'POST',
					url:  'ajaxEngine.php',
					dataType: 'json',
					data: 'action=loadTagsAddedAjax&case_id='+case_id,
					success:  function(data) {
						//console.log('log:'+JSON.stringify(data));
						$(data).each(function (i){
							$('#allowSpacesTags').tagit('createTag', data[i]);
						//	console.log("log: " + data[i]);
						});
						loading = false;
					}
				});
			}
			
			function afterTagAddedAjax(case_id , tagLabel) {
				$.ajax({
					type: 'POST',
					url:  'ajaxEngine.php',
					//contentType: "application/json",
					dataType: "json",
					data: 'action=afterTagAdded&case_id='+case_id+'&tagLabel='+tagLabel,
					success:  function(data) {
						//$('#alert'+tagLabel).fadeOut();
						//console.log(event.tagit('tagLabel', ui.tag) + " - Tag added to DB");
						//console.log(JSON.stringify(data));
					}
				});
			}
			
			function afterTagRemovedAjax(case_id, tagLabel) {
                $.ajax({
                    type: 'POST',
                    url: 'ajaxEngine.php',
                    //contentType: "application/json",
					dataType: "json",
                    data: 'action=afterTagRemoved&case_id=' + case_id + '&tagLabel=' + tagLabel,
                    success: function (data) {
                        //console.log(JSON.stringify(data));
                    }
                });
            }
            
            function handleTags(){
                var event = $('#allowSpacesTags');
                var case_id = $('#allowSpacesTags').data("case_id");
                $('#allowSpacesTags').tagit({
                    availableTags: available_tags,
                    allowSpaces: true,
                    afterTagAdded: function (evt, ui) {
                        if (!ui.duringInitialization && !loading) {
                            //console.log(event.tagit('tagLabel', ui.tag) + " - Tag added");
                            //console.log("case_id=" + JSON.stringify(case_id));
							afterTagAddedAjax(case_id , event.tagit('tagLabel', ui.tag) );
                        }

                    },
                    afterTagRemoved: function (evt, ui) {
                        if (!ui.duringInitialization) {
                            //console.log(event.tagit('tagLabel', ui.tag) + " - Tag removed");
							//console.log("afterTagRemoved case_id=" + JSON.stringify(case_id));
							afterTagRemovedAjax(case_id , event.tagit('tagLabel', ui.tag) );
                        }

                    }
                });
            }
            
            $(document).ready(function () {
				//console.log('in ready');
                //getJsonAutoComplete();
				loading = true;				
                loadTagsAddedAjax();
				
                handleTags();
                
            });
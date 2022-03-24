<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';

$userId = 1;

pageStart("מערכת קליניקה - עמוד הבית","<script type=\"text/javascript\" src=\"/js/jquery.dashboard.js\"></script>
										<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/dashboardui.css\" />");
?>
<script type="text/javascript">
      // This is the code for definining the dashboard
      $(document).ready(function() {

        // load the templates
        $('body').append('<div id="templates"></div>');
        $("#templates").hide();
        $("#templates").load("dashboard_templates.html", initDashboard);

        
        function initDashboard() {

          // to make it possible to add widgets more than once, we create clientside unique id's
          // this is for demo purposes: normally this would be an id generated serverside
          var startId = 1000;

          var dashboard = $('#dashboard').dashboard({
            // layout class is used to make it possible to switch layouts
            layoutClass:'layout',
            // feed for the widgets which are on the dashboard when opened
            json_data : {
              url: "dashboardSettings.php?userId=<?php echo $userId;?>"
            },
            //stateChangeUrl : "dashboardSettings.php",
            deleteConfirmMessage: "האם אתה בטוח?",
            // json feed; the widgets whcih you can add to your dashboard
            addWidgetSettings: {
              widgetDirectoryUrl:"jsonfeed/widgetcategories.json"
            },

            // Definition of the layout
            // When using the layoutClass, it is possible to change layout using only another class. In this case
            // you don't need the html property in the layout

            layouts :
              [        
                { title: "Layout2",
                  id: "layout2",
                  image: "layouts/layout2.png",
                  html: '<div class="layout layout-aa"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                  classname: 'layout-aa'
                }
              ]

          }); // end dashboard call

          // binding for a widgets is added to the dashboard
          dashboard.element.on('dashboardAddWidget',function(e, obj){
            var widget = obj.widget;

            dashboard.addWidget({
              "id":startId++,
              "title":widget.title,
              "url":widget.url,
              "metadata":widget.metadata
              }, dashboard.element.find('.column:first'));
          });

          // the init builds the dashboard. This makes it possible to first unbind events before the dashboars is built.
          dashboard.init();
        }
      });

    </script>

<div id="dashboard" class="dashboard">
    <!-- this HTML covers all layouts. The 5 different layouts are handled by setting another layout classname -->
    <div class="layout">
      <div class="column first column-first"></div>
      <div class="column second column-second"></div>
      <div class="column third column-third"></div>
    </div>
  </div>
<br>
<a href="/dashboardSettings.php?reset=true">Reset Widgets</a>
<?php pageEnd(); ?>
</div>
</div>
<script src="assets/vendors/core/core.js"></script>
<script src="assets/vendors/chartjs/Chart.min.js"></script>
<script src="assets/vendors/jquery.flot/jquery.flot.js"></script>
<script src="assets/vendors/jquery.flot/jquery.flot.resize.js"></script>

<script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!--<script src="assets/vendors/apexcharts/apexcharts.min.js"></script>-->
<script src="assets/vendors/progressbar.js/progressbar.min.js"></script>

<script src="assets/vendors/feather-icons/feather.min.js"></script>
<script src="assets/js/template.js"></script>

<script src="assets/js/dashboard.js"></script>
<script src="assets/js/datepicker.js"></script>
<svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;"><defs id="SvgjsDefs1002"></defs><polyline id="SvgjsPolyline1003" points="0,0"></polyline><path id="SvgjsPath1004" d="M0 0 "></path></svg>



	<!-- endinject -->
  <!-- plugin js for this page -->
  <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
 
	<!-- end plugin js for this page -->

	<!-- endinject -->
  <!-- custom js for this page -->
  <script src="assets/js/data-table.js"></script>

  <script src="assets/js/apexcharts.js"></script>

	<script>
			    $(document).ready(function(){
  
var $terms = [
  'Project',
  'Receivings',
  'Group',
  'Category',
  'Service',
  'Expense',
  'Summary',
  'Outstanding',
   ].sort(),
   $return = [];
  
function strInArray(str, strArray) {
  for (var j=0; j<strArray.length; j++) {
    if (strArray[j].match(str) && $return.length < 5) {
      var $h = strArray[j].replace(str, '<strong>'+str+'</strong>');
      $return.push('<li class="prediction-item"><span class="prediction-text">' + $h + '</span></li>');
    }
  }
}
  
function nextItem(kp) {
  if ( $('.focus').length > 0 ) {
    var $next = $('.focus').next(),
        $prev = $('.focus').prev();
  }
  
  if ( kp == 38 ) { // Up
  
    if ( $('.focus').is(':first-child') ) {
      $prev = $('.prediction-item:last-child');
    }
    
    $('.prediction-item').removeClass('focus');
    $prev.addClass('focus');
    
  } else if ( kp == 40 ) { // Down
  
    if ( $('.focus').is(':last-child') ) {
      $next = $('.prediction-item:first-child');
    }
    
    $('.prediction-item').removeClass('focus');
    $next.addClass('focus');
  }
}

$(function(){  
  $('#navbarForm').keydown(function(e){
    $key = e.keyCode;
    if ( $key == 38 || $key == 40 ) {
      nextItem($key);
      return;
    }
    
    setTimeout(function() {
      var $search = $('#navbarForm').val();
      $return = [];
      
      strInArray($search, $terms);
      
      if ( $search == '' || ! $('input').val ) {
        $('.output').html('').slideUp();
      } else {
        $('.output').html($return).slideDown();
      }
  
      $('.prediction-item').on('click', function(){
        $text = $(this).find('span').text();
        $('.output').slideUp(function(){
          $(this).html('');
        });
        $('#navbarForm').val($text);
        
        // Add your custom function here for handling the click
        customFunction($text);
          
      });
      
      $('.prediction-item:first-child').addClass('focus');
      
    }, 50);
  });
});
  
  $('#navbarForm').focus(function(){
    if ( $('.prediction-item').length > 0 ) {
      $('.output').slideDown();
    }
    
    $('#search-form').submit(function(e){
      e.preventDefault();
      $text = $('.focus').find('span').text();
      $('.output').slideUp();
      $('#navbarForm').val($text);
      $('input').blur();
    });
  });
  
  $('#navbarForm').blur(function(){
    if ( $('.prediction-item').length > 0 ) {
      $('.output').slideUp();
    }
  });
  
    function customFunction(text) {
        window.location.href = text+".php";
  }
  
});
			</script>

  
</body>
</html>
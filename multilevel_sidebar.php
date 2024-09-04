
<style>
#column_left {
	background-color: #515151;
}

.nav-list li a {
	text-decoration: none;
	display: block;
	padding: 10px;
	cursor: pointer;
	border-bottom: 1px solid #515151 !important;
	color: #9d9d9d;
}

.nav-list > li > a {
	color: #C4C4C4;
	font-size: 14px;
	padding-left: 13px !important;
	border-bottom: 1px solid #585858;
}

.nav-list > li > a:hover {
	background-color: #444444;
}

</style>

<div class="container">

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="page-header">
				<h2>Side Bar</h2>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			
		<nav id="column_left">	
		<ul class="nav nav-list">
		  	<li><a>Dashboard</a></li>	
		  
			<li>
		    	<a class="accordion-heading" data-toggle="collapse" data-target="#submenu1">
		      		<span class="nav-header-primary">Menu Link <span class="pull-right"><b class="caret"></b></span></span>
		    	</a>

			    <ul class="nav nav-list collapse" id="submenu1">
				    <li>
				      	<a class="accordion-heading" data-toggle="collapse" data-target="#submenu2">Sub Menu Link <span class="pull-right"><b class="caret"></b></span></a>
				      	<ul class="nav nav-list collapse" id="submenu2">
				      		<li><a href="#" title="Title">Sub Sub Menu Link</a></li>
				      		<li><a href="#" title="Title">Sub Sub Menu Link</a></li>
				      	</ul>
				    </li>
			    </ul>
		  	</li>

		</ul>

		</nav>

		</div>

		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">


		</div>

	</div>

</div>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
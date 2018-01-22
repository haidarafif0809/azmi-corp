<style scoped>
.error-template {padding: 40px 15px;text-align: center;}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }
</style>
<template>
<div class="container">
    <div class="row">
    <div class="error-template">
	    <h1>Oops!</h1>
	    <h2>404 Not Found</h2>
	    <div class="error-details">
		Sorry, an error has occured, Requested page not found!<br>
	    </div>
	    <div class="error-actions">
		<router-link :to="{name: 'IndexDashboard'}" class="btn btn-primary">
		    <i class="icon-home icon-white"></i> Take Me Home </router-link>
	    </div>
	</div>
    </div>
</div>
</template>
